<?php

namespace Plugins\Activity\App\Http\Controllers\Factory;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Factory\BaseController;

use Plugins\Activity\App\Activity;
use Plugins\Activity\App\ActivityType;
use Addons\Core\Controllers\AdminTrait;

class ActivityController extends BaseController
{
	use AdminTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$activity = new Activity;
		$builder = $activity->newQuery()->with(['activity_type'])->where('fid', $this->factory->getKey());
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.factory-backend.'.$activity->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('activity::factory-backend.activity.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request)
	{
		$activity = new Activity;
		$builder = $activity->newQuery()->with(['activity_type'])->where('fid', $this->factory->getKey());
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		if($request->get('type') == 'select'){
		    $data['data'] = array_unshift(['id'=>0,'name'=>'暂无活动']);
		}
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request)
	{
		$activity = new Activity;
		$builder = $activity->newQuery()->with('activity_type')->where('fid', $this->factory->getKey());
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $activity->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('activity::factory-backend.activity.export');
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
		$keys = 'type_id,name,aid,argc,start_date,end_date,order';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('activity.store', $keys);
		return $this->view('activity::factory-backend.activity.create');
	}

	public function store(Request $request)
	{
	    $class_dir = ActivityType::find($request->get('type_id'))->class_dir;	
	    $argc = with(new $class_dir)->get_json_data($request->all());
	    if($argc['result'] == false){
	        return $this->failure($argc['msg'],'factory/activity/create');
	    }
		$keys = 'type_id,name,aid,argc,start_date,end_date,order';
		$data = $this->autoValidate($request, 'activity.store', $keys);
		$data += ['fid' => $this->factory->getKey()];
		$data['end_date'] .= ' 23:59:59';
		$data['argc'] = $argc['data'];
		$activity = Activity::create($data);
		
		return $this->success('', url('factory/activity'));
	}

	public function edit($id)
	{
		$activity = Activity::find($id);
		if (empty($activity))
			return $this->failure_noexists();

		$keys = 'type_id,name,aid,argc,start_date,end_date,order';
		$this->_validates = $this->getScriptValidate('activity.store', $keys);
		$this->_data = $activity;
		return $this->view('activity::factory-backend.activity.edit');
	}

	public function update(Request $request, $id)
	{
		$activity = Activity::find($id);
		if (empty($activity))
			return $this->failure_noexists();
		
		$class_dir = ActivityType::find($request->get('type_id'))->class_dir;
		$argc = with(new $class_dir)->get_json_data($request->all());
		if($argc['result'] == false){
		    return $this->failure($argc['msg'],'factory/activity/'.$id.'/edit');
		}
		$keys = 'type_id,name,aid,argc,start_date,end_date,order';
		$data = $this->autoValidate($request, 'activity.store', $keys, $activity);
		$data['end_date'] .= ' 23:59:59';
		$data['argc'] = $argc['data'];
		$activity->update($data);

		return $this->success();
	}
    //操作上下架
	public function setShelves(Request $request,$id,$status){
	    $activity = Activity::find($id);
	    if (empty($activity))
	        return $this->failure_noexists();
	    
	    $data['status'] = $status;
	    $activity->update($data);
	    
	    return $this->success('', url('factory/activity'));
	}
	//json_参数
	public function getTypeHtml(Request $request){
	   $id = $request->get('id');
	   $type_id = $request->get('type_id');
	   if($type_id){
	       $argc = Activity::find($id)->argc;
	       $class_dir = ActivityType::find($type_id)->class_dir;
	       
	       $html = with(new $class_dir)->show_edit_html($argc);
	   }else{
	       $html = '';
	   }
	   exit($html);
	}
	
	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$activity = Activity::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
