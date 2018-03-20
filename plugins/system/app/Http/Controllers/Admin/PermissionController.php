<?php

namespace Plugins\System\App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Permission;
use Addons\Core\ApiTrait;

class PermissionController extends Controller
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
		$permission = new Permission;
		$size = $request->input('size') ?: config('size.models.'.$permission->getTable(), config('size.common'));

		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('system::admin.permission.list');
	}

	public function data(Request $request)
	{
		$permission = new Permission;
		$builder = $permission->newQuery();

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$permission = new Permission;
		$builder = $permission->newQuery();
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder);
		return $this->office($data);
	}

	public function show($id)
	{
		$perm = Permission::findOrFail($id);
		return $this->api($perm);
	}

	public function create()
	{
		$keys = ['name', 'display_name', 'description'];
		$this->_data = [];
		$this->_validates = $this->censorScripts('system::permission.store', $keys);
		return $this->view('system::admin.permission.create');
	}

	public function store(Request $request)
	{
		$keys = ['name', 'display_name', 'description'];
		$data = $this->censor($request, 'system::permission.store', $keys);
		if (strpos($data['name'], '*') !== FALSE) //添加RESTful权限
			Permission::import([$data['name'] => $data['display_name']], str_replace('*', '{{key}}', $data['name']));
		else
			Permission::create($data);
		return $this->success('', url('admin/permission'));
	}

	public function edit($id)
	{
		$permission = Permission::find($id);
		if (empty($permission))
			return $this->failure_notexists();
		$keys = ['display_name', 'description'];
		$this->_validates = $this->censorScripts('system::permission.store', $keys);
		$this->_data = $permission;
		return $this->view('system::admin.permission.edit');
	}

	public function update(Request $request, $id)
	{
		$permission = Permission::find($id);
		if (empty($permission))
			return $this->failure_notexists();

		$keys = ['display_name', 'description'];
		$data = $this->censor($request, 'system::permission.store', $keys, $permission);
		$permission->update($data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$ids = array_wrap($id);

		DB::transaction(function() use ($ids) {
			Permission::destroy($ids);
		});
		return $this->success(null, count($id) > 5, compact('id'));
	}
}
