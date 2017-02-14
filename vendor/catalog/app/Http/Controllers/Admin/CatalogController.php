<?php
namespace Plugins\Catalog\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
	use ApiTrait;
	public $permissions = ['catalog'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$user = new User;
		$size = $request->input('size') ?: config('size.models.'.$user->getTable(), config('size.common'));
		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('admin.member.list');
	}

	public function data(Request $request)
	{
		$user = new User;
		$builder = $user->newQuery()->with(['roles']);

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder, null, ['users.*']);
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$user = new User;
		$builder = $user->newQuery()->with(['roles']);
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder, function(&$v){
			$v['gender'] = !empty($v['gender']) ? $v['gender']['title'] : NULL;
		}, ['users.*']);
		return $this->export($data);
	}

	public function show(Request $request, $id)
	{
		$user = User::with(['roles'])->find($id);
		if (empty($user))
			return $this->failure_noexists();

		$this->_data = $user;
		return !$request->offsetExists('of') ? $this->view('admin.member.show') : $this->api($user->toArray());
	}

	public function create()
	{
		$keys = ['username', 'password', 'nickname', 'realname', 'gender', 'email', 'phone', 'idcard', 'avatar_aid', 'role_ids'];
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('member.store', $keys);
		return $this->view('admin.member.create');
	}

	public function store(Request $request)
	{
		$keys = ['username', 'password', 'nickname', 'realname', 'gender', 'email', 'phone', 'idcard', 'avatar_aid', 'role_ids'];
		$data = $this->autoValidate($request, 'member.store', $keys);

		$extraKeys = [];
		$multipleKeys = [];
		$extra = array_only($data, $extraKeys);
		$multiples = array_only($data, $multipleKeys);

		$role_ids = array_pull($data, 'role_ids');
		$data = array_except($data, array_merge($extraKeys, $multipleKeys));
		DB::transaction(function() use ($data, $extra, $multiples, $role_ids){
			$user = (new User)->add($data);
			$user->extra()->create($extra);
			foreach((array)$multiples as $k => $v)
			{
				$catalog = Catalog::getCatalogsByName('fields.'.Str::singular($k));
				$game->$k()->attach($v, ['parent_cid' => $catalog['id']]);
			}
			$user->roles()->sync($role_ids);
		});
		return $this->success('', url('admin/member'));
	}

	public function edit($id)
	{
		$user = User::find($id);
		if (empty($user))
			return $this->failure_noexists();

		$keys = ['username', 'nickname', 'realname', 'gender', 'email', 'phone', 'idcard', 'avatar_aid', 'role_ids'];
		$this->_validates = $this->getScriptValidate('member.store', $keys);
		$this->_data = $user;
		return $this->view('admin.member.edit');
	}

	public function update(Request $request, $id)
	{
		$user = User::find($id);
		if (empty($user))
			return $this->failure_noexists();

		//modify the password
		if (!empty($request->input('password')))
		{
			$data = $this->autoValidate($request, 'member.store', 'password');
			$data['password'] = bcrypt($data['password']);
			$user->update($data);
		}
		$keys = ['nickname', 'realname', 'gender', 'email', 'phone', 'idcard', 'avatar_aid', 'role_ids'];
		$data = $this->autoValidate($request, 'member.store', $keys, $user);

		$extraKeys = [];
		$multipleKeys = [];
		$extra = array_only($data, $extraKeys);
		$multiples = array_only($data, $multipleKeys);

		$role_ids = array_pull($data, 'role_ids');
		$data = array_except($data, array_merge($extraKeys, $multipleKeys));
		DB::transaction(function() use ($user, $extra, $multiples, $data, $role_ids){
			$user->update($data);
			$user->extra()->update($extra);
			foreach((array)$multiples as $k => $v)
			{
				$catalog = Catalog::getCatalogsByName('fields.'.Str::singular($k));
				$game->$k()->detach();
				$game->$k()->attach($v, ['parent_cid' => $catalog['id']]);
			}
			$user->roles()->sync($role_ids);
		});
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$user = User::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}