<?php
namespace Plugins\Activity\App\Http\Controllers\M;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WechatOAuth2Controller;
use App\ProductSize;
use App\Brand;
use Plugins\Activity\App\ActivityType;
use Plugins\Activity\App\Activity;
use App\Product;

class ActivityController extends WechatOAuth2Controller
{
	//新品
	public function discount(Request $request)
	{
	    $stores_ids = $this->user->stores->pluck('id');
	    $this->_brands = Brand::join('store_brand as s','s.bid','=','brands.id')->whereIn('s.sid',$stores_ids)->get(['brands.*']);
	    
	    $pagesize = $request->input('pagesize') ?:$this->site['pagesize']['m'];
	    $this->_input = $request->all();
	    $product = new Product;
	    $builder = $product->newQuery()->with(['sizes','covers']);

	    $this->_table_data = $builder->whereIn('bid',$this->_brands->pluck('id'))->paginate($pagesize);
	    //查找所有专题
	    $fids = $product->newQuery()->whereIn('bid',$this->_brands->pluck('id'))->pluck('fid');
	    if(!empty($fids)){$fids = array_unique((array)$fids);}$now = date("Y-m-d H:i:s");
	    $this->_activities = Activity::whereIn('fid',$fids)->where('start_date','<=',$now)->where('end_date','>=',$now)->where('status',1)->orderBy('created_at','desc')->get();
	    
	    return $this->view('activity::m.discount');
	}
	
	//专题页
	public function special(Request $request,$activity_id=0)
	{
	    $stores_ids = $this->user->stores->pluck('id');
	    $this->_brands = Brand::join('store_brand as s','s.bid','=','brands.id')->whereIn('s.sid',$stores_ids)->get(['brands.*']);
	    
	    $pagesize = $request->input('pagesize') ?:$this->site['pagesize']['m'];
	    $this->_input = $request->all();
	    $product = new Product;
	    //查找猴子捞月所有在线，有效活动id
	    $now = date("Y-m-d H:i:s");
	    if(!empty($activity_id)){
	       $activity = Activity::find($activity_id);
	    }elseif(!empty($request->get('type_id'))){
	        $fids = $product->newQuery()->whereIn('bid',$this->_brands->pluck('id'))->pluck('fid');
	        if(!empty($fids)){$fids = array_unique((array)$fids);}
	        $builder = Activity::whereIn('fid',$fids)->where('type_id',$request->get('type_id'));
	        $activity = $builder->first();
	        $activity_id = $builder->pluck('id');
	    }else{
	        return $this->failure(NULL);
	    }
	    
	    if(empty($activity)){
	        return $this->failure('activity::activity.no_activity');
	    }elseif($activity->start_date > $now || $activity->end_date < $now || $activity->status !=1){
	    	return $this->failure('activity::activity.failure_activity');
	    }
	    
	    //查看当前以以和店铺 猴子捞月 活动所有商品
	    $builder = $product->newQuery()->with(['sizes','covers']);
	    $this->_activity = $activity;
	    $this->_table_data = $builder->whereIn('activity_type',(array)$activity_id)->whereIn('bid',$this->_brands->pluck('id'))->paginate($pagesize);
	    return $this->view('activity::m.special');
	}
}
