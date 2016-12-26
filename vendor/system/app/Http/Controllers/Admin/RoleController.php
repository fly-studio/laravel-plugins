<?php
namespace Plugins\System\App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Role;
use App\Permission;
use Addons\Core\Controllers\ApiTrait;
use Illuminate\Support\Collection;
class RoleController extends Controller
{
	use ApiTrait;
	public $RESTful_permission = 'role';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$role = new Role;
		$roles = $role->newQuery()->with('perms')->where($role->getKeyName(), '!=', 0)->orderBy($role->getKeyName())->get();


		//view's variant
		$this->_table_data = $roles;
		$this->_perms_data = Permission::all();
		return $this->view('system::admin.role.list');
	}

	public function data(Request $request)
	{
		$role = new Role;
		$builder = $role->newQuery()->with('perms');
		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder, function($page) use($request, $role) {
			if ($request->input('tree') == 'true')
			{
				$items = $page->getCollection()->keyBy($role->getKeyName())->toArray();
				$page->setCollection(new Collection($role->_data_to_tree($items, 0, false)));
			}
		});

		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->api($data);
	}

	public function store(Request $request)
	{
		$keys = 'name,display_name,description,url,pid';
		$data = $this->autoValidate($request, 'role.store', $keys);

		Role::create($data);
		return $this->success('', url('admin/role'));
	}

	public function update(Request $request, $id)
	{
		if ($id == -1) //保存所有权限
		{
			$keys = 'perms';
			$data = $this->autoValidate($request, 'role.store', $keys);

			foreach(Role::all() as $role)
				$role->perms()->sync(isset($data['perms'][$role->getKey()]) ? $data['perms'][$role->getKey()] : [] );
		}
		else //修改某用户组的资料
		{
			$role = Role::find($id);
			if (empty($role))
				return $this->failure_noexists();

			$keys = 'display_name,description,url';
			$data = $this->autoValidate($request, 'role.store', $keys);
			$role->update($data);
		}
		
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{

		$keys = 'role_id,original_role_id';
		$data = $this->autoValidate($request, 'role.destroy', $keys);

		$originalRole = Role::find($data['original_role_id']);
		foreach ($originalRole->users()->get(['id']) as $user)
			!in_array($data['role_id'], $user->roles()->get('id')->pluck('id')) && $user->attachRole($data['role_id']);
		$originalRole->delete();
		return $this->success('', TRUE, compact('id'));
	}
}
