<?php
namespace Plugins\Activity;

use App\Product;
use App\ProductSize;
class Discount extends Activity{
    private $discount;
    public function config($config){
        $this->discount = $config['discount']?:10;
        return $this;
    }
    //显示
    function show_edit_html($data){
        $discount = is_numeric($data)?$data:(empty($data)?'':(isset(with(json_decode($data))->discount)?with(json_decode($data))->discount:''));
        echo '<div class="form-group add_type">
        <label for="discount" class="col-md-3 control-label">折扣</label>
        <div class="col-md-9">
        <input type="text" value="'.$discount.'" placeholder="请输入折扣" class="form-control" name="discount" id="discount">
        </div>
        </div>';
    }
    //后台设置参数
    function get_json_data($data){
        //校验参数，并且返回相应的json串
        if(preg_match('/^[1-9](\.\d)?|10$/',$data['discount'])){
            return ['result'=>true,'data'=>json_encode(['discount'=>($data['discount']?:10)])];
        }else{
            return ['result'=>false,'msg'=>'activity.failure_discount'] ;
        }
    }
    //商品SIZE显示
    function product_size_decorate(ProductSize $size,$htmlShow=false){
        if($htmlShow)
            $size->price = '折扣价:'.sprintf("%.2f",$size->price*$this->discount/10);
        else
            $size->price = sprintf("%.2f",$size->price*$this->discount/10);
        return $size;
    }
    //商品显示
    function product_decorate(Product $product){
        return $product;
    }
    //红包
    function bonus($bonus_config){
        return '';
    }
}