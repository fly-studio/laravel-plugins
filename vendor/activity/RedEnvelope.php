<?php
namespace Plugins\Activity;

use App\Product;
use App\ProductSize;
use App\ActivityBonus;
class RedEnvelope {
    public function config($config){return $this;}
    //显示
    function show_edit_html($data){
       echo '';
    }
    //后台设置参数
    function get_json_data($data){
        return ['result'=>true,'data'=>''];
    }
    //商品SIZE显示
    function product_size_decorate(ProductSize $size,$htmlShow=false){
       if($htmlShow)
           $size->price = $size->price.'(可使用红包)';
        return $size;
    }
    //商品显示
    function product_decorate(Product $product){
        return $product;
    }
    //红包
    function bonus($bonus_config){//$fid,$uid,$aid
        static $show_bonus = false;
        $bonus = ActivityBonus::where("fid",$bonus_config['fid'])->where('uid',$bonus_config['uid'])->where('activity_id',3)->where('status',0)->get();
        if($bonus->count()>0 && $show_bonus == false){
            $select_html = "红包:<select name=\"bonus_id\"><option value=\"0\">无</option>";
            foreach ($bonus as $bonus_item)
            {
                $select_html.="<option value=\"".$bonus_item->getKey()."\">".$bonus_item->bonus."</option>";
            }
            $select_html.="</select>";
            $show_bonus = true;
            return $select_html;
        }
        return '';
    }
}