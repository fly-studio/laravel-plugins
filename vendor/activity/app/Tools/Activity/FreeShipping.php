<?php
namespace Plugins\Activity\App\Tools\Activity;

use App\Product;
use App\ProductSize;
use Exception;
//包邮
class FreeShipping extends Activity{
    private $custom_price;
    public function config($config){
        $this->custom_price = $config['custom_price']?:0;
        return $this;
    }
    //显示
    function show_edit_html($data){
        $custom_price = is_numeric($data)?$data:(empty($data)?'':(isset(with(json_decode($data))->custom_price)?with(json_decode($data))->custom_price:''));
        echo '<div class="form-group add_type">
        <label for="custom_price" class="col-md-3 control-label">包费价</label>
        <div class="col-md-9">
        <input type="text" value="'.$custom_price.'" placeholder="请输入包邮价" class="form-control" name="custom_price" id="custom_price">
        </div>
        </div>';
    }
    //后台设置参数
    function get_json_data($data){
        //校验参数，并且返回相应的json串
        if(preg_match('/^[1-9]+(\.\d{1,2})?$/',$data['custom_price'])){
            return ['result'=>true,'data'=>json_encode(['custom_price'=>$data['custom_price']])];
        }else{
            return ['result'=>false,'msg'=>'activity.failure_freeshipping'] ;
        }
    }
    //商品SIZE显示
    function product_size_decorate(ProductSize $size,$htmlShow=false){
        if($htmlShow)
            $size->price = '包邮价:'.$this->custom_price;
        else
            $size->price = $this->custom_price;
        return $size;
    }
    //商品显示
    function product_decorate(Product $product){
        $product->express_price = 0;
        return $product;
    }
    //红包
    function bonus($bonus_config){
        return '';
    }
}