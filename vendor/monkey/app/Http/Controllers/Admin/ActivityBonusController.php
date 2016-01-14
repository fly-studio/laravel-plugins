<?php

namespace Plugins\Monkey\App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Plugins\Activity\App\Activity;
use Plugins\Activity\App\ActivityType;
use Plugins\Monkey\App\ActivityBonus;
use Addons\Core\Controllers\AdminTrait;

class ActivityBonusController extends Controller
{
	use AdminTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$activity = new ActivityBonus;
		$builder = $activity->newQuery()->with(['users','factory','activity']);
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$activity->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('monkey::admin.activity-bonus.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request)
	{
		$activity = new ActivityBonus;
		$builder = $activity->newQuery()->with(['users','factory','activity']);
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);

		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request)
	{
		$activity = new ActivityBonus;
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $activity::count();

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $activity->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('monkey::admin.activity-bonus.export');
		}

		$builder = $activity->newQuery()->with(['users','factory','activity']);
		$data = $this->_getExport($request, $builder);
		return $this->success('', FALSE, $data);
	}
	
	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$activity = ActivityBonus::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
