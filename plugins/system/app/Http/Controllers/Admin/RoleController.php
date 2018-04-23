<?php

namespace Plugins\System\App\Http\Controllers\Admin;

use Addons\Core\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Role;
use App\Permission;

class RoleController extends Controller
{
	use ApiTrait;

	public $permissions = ['role'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$role = new Role;
		$roles = $role->newQuery()->with('permissions')->withCount(['users', 'children'])->where($role->getKeyName(), '!=', 0)->orderBy($role->getKeyName())->get();

		$permissions = [];
		$_permissions = Permission::orderBy('id', 'asc')->get();
		foreach ($_permissions as $value) {
			list($name, ) = explode('.', $value['name']);
			$permissions[$name][] = $value;
		}
		//view's variant
		$this->_table_data = $roles->each(function($v){
			$v->setRelation('permissions', $v->permissions->keyBy('id'));
		});
		$this->_permissions_data = $permissions;
		return $this->view('system::admin.role.list');
	}

	public function data(Request $request)
	{
		$role = new Role;
		$builder = $role->newQuery()->with('permissions');
		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder, function($page) use($request, $role) {
			if ($request->input('tree') == 'true')
			{
				$items = $page->getCollection()->keyBy($role->getKeyName())->toArray();
				$page->setCollection(new Collection(Role::datasetToTree($items, false)));
			}
		});

		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->api($data);
	}

	public function store(Request $request)
	{
		$keys = ['name', 'display_name', 'description', 'url', 'pid'];
		$data = $this->censor($request, 'system::role.store', $keys);

		Role::create($data);
		return $this->success('', url('admin/role'));
	}

	public function update(Request $request, $id)
	{
		if ($id == -1) //保存所有权限
		{
			$keys = ['permissions'];
			$data = $this->censor($request, 'system::role.store', $keys);

			foreach(Role::all() as $role)
				$role->syncPermissions(isset($data['permissions'][$role->getKey()]) ? $data['permissions'][$role->getKey()] : [] );
		}
		else //修改某用户组的资料
		{
			$role = Role::find($id);
			if (empty($role))
				return $this->failure_notexists();

			$keys = ['display_name', 'description', 'url'];
			$data = $this->censor($request, 'system::role.store', $keys);
			$role->update($data);
		}

		return $this->success();
	}

	public function destroy(Request $request, $id)
	{

		$keys = ['role_id', 'original_role_id'];
		$data = $this->censor($request, 'system::role.destroy', $keys);

		$originalRole = Role::find($data['original_role_id']);
		foreach ($originalRole->users()->get(['id']) as $user)
			$user->roles()->syncWithoutDetaching([$data['role_id']]);
		$originalRole->delete(); // 外键级联删除
		return $this->success(null, true, compact('id'));
	}
}
