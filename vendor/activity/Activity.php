<?php
namespace Plugins\Activity;
#namespace Addons\Core\Tools\Activity;

use App\Product;
use App\ProductSize;
abstract class Activity {

    function config($config){return null;}
    //显示
    function show_edit_html($data){return '';}
    //后台设置参数
    function get_json_data($data){ return null;}
    //商品Size显示
    function product_size_decorate(ProductSize $size,$htmlShow=false){return null;}
    //商品显示
    function product_decorate(Product $product){return null;}
    function bonus($bonus_config){return null;}
}