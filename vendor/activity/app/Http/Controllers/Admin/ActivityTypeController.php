<?php

namespace Plugins\Activity\App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Plugins\Activity\App\ActivityType;
use Addons\Core\Controllers\AdminTrait;

class ActivityTypeController extends Controller
{
	use AdminTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$activity_type = new ActivityType;
		$builder = $activity_type->newQuery();
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$activity_type->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('activity::admin.activity-type.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request)
	{
		$activity_type = new ActivityType;
		$builder = $activity_type->newQuery()->orderBy('id','asc');
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request)
	{
		$activity_type = new ActivityType;
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $activity_type::count();

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $activity_type->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('activity::admin.activity-type.export');
		}

		$builder = $activity_type->newQuery();
		$data = $this->_getExport($request, $builder);
		return $this->success('', FALSE, $data);
	}

	public function show($id)
	{
		return '';
	}

	public function create()
	{
		$keys = 'name,class_dir';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('activity_type.store', $keys);
		return $this->view('activity::admin.activity-type.create');
	}

	public function store(Request $request)
	{
		$keys = 'name,class_dir';
		$data = $this->autoValidate($request, 'activity_type.store', $keys);
		$activity_type = ActivityType::create($data);
		return $this->success('', url('admin/activity_type'));
	}

	public function edit($id)
	{
		$activity_type = ActivityType::find($id);
		if (empty($activity_type))
			return $this->failure_noexists();

		$keys = 'name,class_dir';
		$this->_validates = $this->getScriptValidate('activity_type.store', $keys);
		$this->_data = $activity_type;
		return $this->view('activity::admin.activity-type.edit');
	}

	public function update(Request $request, $id)
	{
		$activity_type = ActivityType::find($id);
		if (empty($activity_type))
			return $this->failure_noexists();

		$keys = 'name,class_dir';
		$data = $this->autoValidate($request, 'activity_type.store', $keys, $activity_type);
		$activity_type->update($data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$activity_type = ActivityType::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
