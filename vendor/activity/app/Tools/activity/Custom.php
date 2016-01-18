<?php
namespace Plugins\Activity\App\Tools\Activity;

use App\Product;
use App\ProductSize;
class Custom extends Activity{
    public function config($config){return $this;}
    //显示
    function show_edit_html($data){
       echo '';
    }
    //后台设置参数
    function get_json_data($data){
        return '';
    }
    //商品SIZE显示
    function product_size_decorate(ProductSize $size,$htmlShow=false){
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