<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>菜单设置<{/block}>

<{block "name"}>wechat/menu<{/block}>

<{block "head-styles-plus"}>
<link rel="stylesheet" href="<{'plugins/css/wechat/menu.css'|url}>">
<link rel="stylesheet" href="<{'plugins/css/wechat/depot.css'|url}>">
<{/block}>
<{block "head-scripts-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{include file="common/editor.inc.tpl"}>
<script src="<{'static/js/angular/angular-1.4.8.min.js'|url}>"></script>
<script src="<{'static/js/angular/ui-bootstrap-tpls-0.14.3.min.js'|url}>"></script>
<script src="<{'static/js/angular/angular-input-modified.min.js'|url}>"></script>
<script src="<{'static/js/ueditor/angular-ueditor.js'|url}>"></script>
<script src="<{'static/js/angular/common.js'|url}>"></script>
<script src="<{'plugins/js/wechat/depot.js'|url}>"></script>
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
		<div class="row menu-container">
			<div class="col-sm-4 menu-left">
				<div class="menu-items">
					<div class="menu-item active">
						<a href="" class="">菜单1</a>
						<div class="pull-right menu-tools">
							<a href="" data-toggle="tooltip" title="修改"><i class="fa fa-pencil"></i></a>
							<a href="" data-toggle="tooltip" title="添加子项"><i class="fa fa-plus"></i></a>
						</div>
					</div>
					<div class="menu-subitem">
						<a href="">子菜单1</a>
						<div class="pull-right menu-tools">
							<a href="" data-toggle="tooltip" title="修改"><i class="fa fa-pencil"></i></a>
						</div>
					</div>
					<div class="menu-item">
						<a href="">菜单3</a>
						<div class="pull-right menu-tools">
							<a href="" data-toggle="tooltip" title="修改"><i class="fa fa-pencil"></i></a>
							<a href="" data-toggle="tooltip" title="添加子项"><i class="fa fa-plus"></i></a>
						</div>
					</div>
					<div class="menu-plus text-center">
						<a href="" class="btn btn-default btn-block disabled" title="添加菜单" data-toggle="tooltip"><i class="fa fa-plus"></i></a>
					</div>
				</div>
			</div>
			<div class="col-sm-8 menu-right">
				<div class="center-block">左边选择一个菜单</div>

			</div>
			<div class="clearfix"></div>
			<div class="menu-publish">
				<h4>已修改菜单：<small>修改之后必须「发布菜单」</small></h4>
				<ol>
					<li>asdasdasd</li>
				</ol>
				<div class="menu-publish-buttons text-center">
					<button class="btn btn-info">保存发布菜单</button>
				</div>
			</div>
		</div>
		
		
	
	</div>
	<div class="clearfix"></div>

<div depot-controller111="news" mode="selector"></div>



</div>

<{include file="[wechat]admin/wechat/depot/ng-template/depot-controller.tpl"}>
<{include file="[wechat]admin/wechat/depot/ng-template/depot-list.tpl"}>
<{/block}>