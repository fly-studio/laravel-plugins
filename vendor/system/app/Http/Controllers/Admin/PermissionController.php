<?php
namespace Plugins\System\App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Permission;
use Addons\Core\Controllers\AdminTrait;

class PermissionController extends Controller
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
		$permission = new Permission;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$permission->getTable(), $this->site['pagesize']['common']);

		//view's variant
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request);
		return $this->view('system::admin.permission.list');
	}

	public function data(Request $request)
	{
		$permission = new Permission;
		$builder = $permission->newQuery();
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$permission = new Permission;
		$builder = $permission->newQuery();
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $permission->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('system::admin.permission.export');
		}

		$data = $this->_getExport($request, $builder);
		return $this->success('', FALSE, $data);
	}

	public function show($id)
	{
		return '';
	}

	public function create()
	{
		$keys = 'name,display_name,description';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('permission.store', $keys);
		return $this->view('system::admin.permission.create');
	}

	public function store(Request $request)
	{
		$keys = 'name,display_name,description';
		$data = $this->autoValidate($request, 'permission.store', $keys);
		if (strpos($data['name'], '*') !== FALSE) //添加多个
		{
			foreach([
				'view' => '查看',
				'create' => '新建',
				'edit' => '编辑',
				'destroy' => '删除',
				'export' => '导出'
			] as $k1 => $v1) {
				Permission::create([
					'name' => str_replace('*', $k1, $data['name']),
					'display_name' => '允许'.$v1.$data['display_name'],
					'description' => $data['description'],
				]);
			}
		} else
			Permission::create($data);
		return $this->success('', url('admin/permission'));
	}

	public function edit($id)
	{
		$permission = Permission::find($id);
		if (empty($permission))
			return $this->failure_noexists();
		$keys = 'display_name,description';
		$this->_validates = $this->getScriptValidate('permission.store', $keys);
		$this->_data = $permission;
		return $this->view('system::admin.permission.edit');
	}

	public function update(Request $request, $id)
	{
		$permission = Permission::find($id);
		if (empty($permission))
			return $this->failure_noexists();

		$keys = 'display_name,description';
		$data = $this->autoValidate($request, 'permission.store', $keys, $permission);
		$permission->update($data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$permission = Permission::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
