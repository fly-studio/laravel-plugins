<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>菜单设置<{/block}>

<{block "name"}>wechat/menu<{/block}>

<{block "head-scripts-plus"}>
<{include file="admin/wechat/menu/depot-selector.tpl"}>

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

</div>
<{/block}>