<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>菜单设置<{/block}>

<{block "name"}>wechat/menu<{/block}>

<{block "head-styles-plus"}>
<link rel="stylesheet" href="<{'plugins/css/wechat/menu.css'|url}>">
<link rel="stylesheet" href="<{'plugins/css/wechat/depot.css'|url}>">
<{/block}>
<{block "head-scripts-plus"}>
<script src="<{'static/js/angular/angular-1.4.8.min.js'|url}>"></script>
<script src="<{'static/js/angular/ui-bootstrap-tpls-0.14.3.min.js'|url}>"></script>
<script src="<{'static/js/angular/angular-input-modified.min.js'|url}>"></script>
<script src="<{'static/js/angular/common.js'|url}>"></script>
<script src="<{'plugins/js/wechat/depot.js'|url}>"></script>
<script>
	var menuList = <{$_table_data->toArray()|json_encode nofilter}>
</script>
<script src="<{'plugins/js/wechat/menu.js'|url}>"></script>
<script>
(function($){
	$().ready(function(){
		$('[name="wechat/menu/list"]').addClass('active').parents('li').addClass('active');
	});
})(jQuery);
</script>
<{/block}>

<{block "block-container"}>
<div class="block full">
	<div class="block-title">
		<h2 class="pull-left"><strong>菜单</strong> 管理</h2>
		<div class="block-options pull-right">
			<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-content" title="折叠/展示" data-original-title="折叠/展示"><i class="fa fa-arrows-v"></i></a>
			<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-fullscreen" title="全屏切换" data-original-title="全屏切换"><i class="fa fa-desktop"></i></a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>

	<div class="block-content">
		
		<div class="row" menu-controller></div>
		
	</div>
	<div class="clearfix"></div>

<div depot-controller111="news" mode="selector"></div>



</div>

<{include file="[wechat]admin/wechat/menu/ng-template/menu-controller.tpl"}>
<{include file="[wechat]admin/wechat/depot/ng-template/depot-controller.tpl"}>
<{include file="[wechat]admin/wechat/depot/ng-template/depot-list.tpl"}>
<{/block}>