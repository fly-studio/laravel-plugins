<?php
namespace Plugins\Monkey\App\Http\Controllers\M;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WechatOAuth2Controller;
use DB;
use App\Cart;
use App\ProductSize;
use Plugins\Monkey\App\ActivityBonus;
use Plugins\Activity\App\Activity;
use App\Brand;
use App\Product;

class GameController extends WechatOAuth2Controller
{
	//游戏初始化
	public function index(Request $request)
	{
	   $uid = $request->get('uid');
	   if(!empty($uid)){
	       $share_key = "share_".$uid."_".$this->user->getKey();
	       if(session($share_key) === NULL){
	          	$key = 'bonus_'.$uid.'_game';
        	    $times = intval(session($key));
        	    session([$key=>$times+1]);
        	    //说明这个东西已经分享过
        	    session([$share_key=>1]);
	       }
	   }
	   return $this->view('monkey::m.game');
	}
	//游戏开始
	public function start(Request $request)
	{
	    $key = 'bonus_'.$this->user->getKey().'_game';
	    if(session($key) === NULL){
	        $times = 1;
	        session([$key=>$times]);
	    }else{
	        $times = intval(session($key));
	    }

	    $this->_wechat = $this->getJsParameters();
	    $this->_times = $times;
	    $this->_uid = $this->user->getKey();
	    $this->_type_id = 3;
	    $this->_data = ['title'=>'美猴捞红包','imgUrl'=>'static/img/m/monkey/monkey_main.jpg','desc'=>'关注“汉派商城”，参加游戏，赢取猴子新年红包。'];
	    $this->_bonus_cnt = ActivityBonus::where('uid',$this->user->getKey())->where('status',0)->count();
	    $stores_ids = $this->user->stores->pluck('id')->toArray();$stores_id = array_pop($stores_ids);
	    $this->_share_url = url('m/home?sid='.$stores_id.'&redirect_url='.urlencode(url('m/game').'?uid='.$this->_uid));
	    return $this->view('monkey::m.game_start');
	}

	//保存游戏积分
	public function saveScore(Request $request)
	{
	    $stores_ids = $this->user->stores->pluck('id');
	    $this->_brands = Brand::join('store_brand as s','s.bid','=','brands.id')->whereIn('s.sid',$stores_ids)->get(['brands.*']);
	    $fids = Product::whereIn('bid',$this->_brands->pluck('id'))->pluck('fid');
	    $key = 'bonus_'.$this->user->getKey().'_game';
	    $times = intval(session($key));
	    if(!empty($fids)&&$times>0){
	        $fids = array_unique((array)$fids);
	        //把关注店铺，相关的厂商都加红包
	        $score = $request->get('score');//分数
	        if($score < 1){
	            $data = ['err_msg'=>'红包金额不能为空.'];
	            return $this->failure(NULL,false,$data,true);
	        }
	        $type_id = $request->get('type_id');//活动id
	        foreach ($fids as $fid){
	            $activity_bouns = new ActivityBonus();
	            $activity_bouns->uid = $this->user->getKey();
	            $activity_bouns->fid = $fid;
	            $activity_bouns->activity_id = with(Activity::where('fid',$fid)->where('type_id',$type_id)->first())->id;
	            $activity_bouns->bonus = intval($score)>80?80:intval($score);
	            $activity_bouns->status = 0;
	            $activity_bouns->save();
	        }
	        session([$key=>--$times]);
	        //红包的个数
	        $bonus_cnt = ActivityBonus::where('uid',$this->user->getKey())->where('status',0)->count();
	        $data = ['times'=>$times,'bonus_cnt'=>$bonus_cnt];
	        return $this->success(NULL,false,$data);
	    }else{
	        $data = ['err_msg'=>'暂时没添加相关活动。'];
            return $this->failure(NULL,false,$data,true);
	    } 
	}


	public function monkey(Request $request)
	{
	   return $this->view('monkey::m.monkey');
	}
}
