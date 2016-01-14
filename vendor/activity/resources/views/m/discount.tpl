<{extends file="extends/main.block.tpl"}>

<{block "head-styles-plus"}>
	<link rel="stylesheet" href="<{'static/js/flexslider/flexslider.css'|url}>">
	<link rel="stylesheet" href="<{'static/css/m/discount.css'|url}>">
	<link rel="stylesheet" href="<{'static/css/m/common.css'|url}>">
<{/block}>

<{block "head-scripts-plus"}>
<script src="<{'static/js/flexslider/jquery.flexslider-min.js'|url}>"></script>
<script src="<{'static/js/masonry.pkgd.min.js'|url}>"></script>
<script src="<{'static/js/imagesloaded.pkgd.min.js'|url}>"></script>
<{/block}>

<{block "body-container"}>
	
	<{include file="m/search.inc.tpl"}>
		<!-- 首页幻灯 -->
	<div class="flexslider">
		<ul class="slides">
			<li><a href="javascript:void(0)"><img src="<{'static/img/m/ban.jpg'|url}>" alt="" class="img-responsive center"></a></li>
			<li><a href="javascript:void(0)"><img src="<{'static/img/m/ban.jpg'|url}>" alt="" class="img-responsive center"></a></li>
			<li><a href="javascript:void(0)"><img src="<{'static/img/m/ban.jpg'|url}>" alt="" class="img-responsive center"></a></li>
		</ul>
	</div>

		<!-- 新品 -->
	<div class="container-fluid title">
		<div class="row">
			<div class="col-xs-12">
				<img src="<{'static/img/m/xs_06.jpg'|url}>" alt="" class="img-responsive"> 
				<a href=""><img src="<{'static/img/m/xs_09.jpg'|url}>" alt="" class="img-responsive pull-right"></a>
			</div>
		</div>
		<div class="title-line row"><img src="<{'static/img/m/xian_02.jpg'|url}>" alt="" class="img-responsive"></div>
	</div>
	

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
				<div class="">暂无新品上市</div>
				<h5 class=""></h5>
				<h6 class=""></h6>		
			</div>
		<{/foreach}>				
		</div>
	   </div>
	   	<!-- 商城特惠 -->
		<div class="container-fluid title">
			<div class="row"><h5 class="col-xs-12">商城特惠</h5></div>
			<div class="title-line row"><img src="<{'static/img/m/xian_02.jpg'|url}>" alt="" class="img-responsive"></div>
		</div>

	   <ul class="list-unstyled adpic">
	   <{foreach $_activities as $activity}>
	   	<li><a href="<{'m/special'|url}>/<{$activity->getKey()}>"><img src="<{'attachment/resize'|url}>?id=<{$activity.aid}>" class="img-responsive center-block"></a></li>
	   <{/foreach}>
	   </ul>

	<!-- 联合创美 -->
	   <h6 class="support text-center">联合创美提供技术支持</h6>
	


	<{include file='m/footer.inc.tpl'}>
<{/block}>



<{block "body-scripts"}>
<script>
(function( $ ) {
$().ready(function(){
	$('#footer-classify').addClass('active');

	var $container = $('#masonry-container');
	$container.imagesLoaded( function () {
		$container.masonry({
			columnWidth: '.sortitem',
			itemSelector: '.sortitem'
		});
	});
	
	$('.flexslider').flexslider({
		animation: "slide",
		controlNav: true,
		directionNav: false,
		slideshow: true,
		slideshowSpeed: 1000,
		pauseOnHover: true,
		touch: true,
	});
	
});
})(jQuery);
</script>
<{/block}>