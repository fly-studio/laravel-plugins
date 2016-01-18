<{extends file="extends/main.block.tpl"}>

<{block "head-styles-plus"}>
	<link rel="stylesheet" href="<{'static/js/flexslider/flexslider.css'|url}>">
	<link rel="stylesheet" href="<{'static/css/m/common.css'|url}>">
	<link rel="stylesheet" href="<{'static/css/m/special.css'|url}>">
	
<{/block}>

<{block "body-container"}>
	<div class="topimg">
		<{if $_activity->type_id ==3}><a href="<{'m/game'|url}>"><{/if}>
		<img src="<{'attachment/resize'|url}>?id=<{$_activity->aid}>" class="img-responsive center-block">
		<{if $_activity->type_id ==3}></a><{/if}>
	</div>
	<h5 class="special-title text-muted"><{$_activity->name}> <small class="pull-right"></small></h5>
	<div class="container-fluid imglist">
	  	<div class="row">
		<{foreach $_table_data as $product}>	
	 		<div class="item">
				<div class=""><a href="<{'m/detail?pid='|url}><{$product.id}>"><img src="<{'attachment/resize'|url}>?id=<{$product.covers[0].cover_aid}>&width=313&height=420" alt="" class="img-responsive"></a></div>
				<h5 class=""><a href="<{'m/detail?pid='|url}><{$product.id}>"><{$product.title|truncate:18:'...':true}></a></h5>
				<h6 class=""><{if !empty($product.sizes[0])}>¥&nbsp;<{$product.sizes[0]->activity()->price}><{/if}><a href="<{'m/detail?pid='|url}><{$product.id}>"><i class="glyphicon glyphicon-option-horizontal pull-right text-muted"></i></a></h6>		
			</div>	 		
		<{foreachelse}>
			<div class="item">
				<div class="">暂无活动商品</div>
				<h5 class=""></h5>
				<h6 class=""></h6>		
			</div>
		<{/foreach}>
		<{$_table_data->appends($_input)->render() nofilter}>				
		</div>
	   </div>

	<!-- 联合创美 -->
	   <h6 class="support text-center">联合创美提供技术支持</h6>
<{/block}>
