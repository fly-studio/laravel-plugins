<?php
namespace Plugins\System\App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Role;
use App\Permission;
use Addons\Core\Controllers\AdminTrait;

class RoleController extends Controller
{
	use AdminTrait;
	public $RESTful_permission = 'role';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$role = new Role;
		$builder = $role->newQuery()->with('perms');
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$role->getTable(), $this->site['pagesize']['common']);

		//view's variant
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $this->_getPaginate($request, $builder, ['*']);
		$this->_perms_data = Permission::all();
		return $this->view('system::admin.role.list');
	}

	public function data(Request $request)
	{
		$role = new Role;
		$builder = $role->newQuery()->with('perms');
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function store(Request $request)
	{
		$keys = 'name,display_name,description,url';
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
		else
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
