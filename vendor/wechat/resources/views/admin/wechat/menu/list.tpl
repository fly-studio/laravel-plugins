<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>菜单设置<{/block}>

<{block "name"}>wechat/menu<{/block}>

<{block "head-scripts-plus"}>
<{include file="admin/wechat/menu/depot-selector.tpl"}>
<script src="<{'plugins/js/wechat/choose.min.js'|url}>"></script>
<script>
(function($){
	$().ready(function(){
		$('[name="wechat/menu/list"]').addClass('active').parents('li').addClass('active');
		$('#read-menu').query(function(json){
			if (json.result == 'success')
				$('#json-content').val(JSON.stringify(json.data.menu, null, "\t"));
			else
				$.showtips(json);
		}, false);
		$('#json-form,#delete-menu').query();
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
<div class="block full">
	<div class="block-title">
		<h2 class="pull-left"><strong>专业配置</strong></h2>
		<div class="block-options pull-right">
			<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip active" data-toggle="block-toggle-content" title="折叠/展示" data-original-title="折叠/展示"><i class="fa fa-arrows-v"></i></a>
			<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-fullscreen" title="全屏切换" data-original-title="全屏切换"><i class="fa fa-desktop"></i></a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
	<div class="block-content" style="display: none;">
		<form class="form-horizontal" id="json-form" action="<{'admin/wechat/menu/publish-json'|url}>" method="POST" confirm="请仔细确认您的JSON代码无误？">
			<div class="">
				<div class="col-sm-12 text-right">
					<a href="<{'admin/wechat/menu/read-json'|url}>" id="read-menu" method="POST"><i class="fa fa-download"></i> 读取线上配置</a>
				</div>
			</div>
			<div class="form-group">
				<label for="title" class="col-sm-2 control-label">菜单JSON数据</label>
				<div class="col-sm-10">
					<textarea name="content" id="json-content" class="form-control" cols="30" rows="10">
{
	"button": [
		/*内容*/


	]
}
					</textarea>
					<span class="help-block">
						<ul>
							<li>非专业人士不可修改本内容，<a href="https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141013&token=&lang=zh_CN" target="_blank">查看教程</a></li>
							<li>可先读取线上配置，再修改后提交。</li>
							<li>使用JSON修改菜单，<b class="text-danger">并不会同步数据到本系统</b>，谨慎使用。无特殊情况，请使用上面的菜单管理。</li>
						</ul>
					</span>
				</div>
			</div>
			<div class="form-group text-center">
				<a class="btn btn-danger" id="delete-menu" method="POST" href="<{'admin/wechat/menu/delete-all'|url}>" confirm="您确定清空菜单，此操作不可恢复？"><i class="fa fa-remove"></i> 清空菜单</a>
				<button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> 发布菜单</button>
			</div>
		</form>
	</div>
	<p class="text-muted">非专业人士勿动，请点击左上角 <i class="fa fa-arrows-v"></i> 按钮展开</p>
</div>
<{/block}>