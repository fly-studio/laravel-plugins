<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>菜单设置<{/block}>

<{block "name"}>catalog<{/block}>

<{block "head-scripts-plus"}>
<{include file="common/uploader.inc.tpl"}>
<script type="text/javascript" src="<{'js/zTree/jquery.ztree.core.min.js'|static}>"></script>
<script type="text/javascript" src="<{'js/zTree/jquery.ztree.exedit.min.js'|static}>"></script>
<link rel="stylesheet" href="<{'css/zTree/zTreeStyle/zTreeStyle.css'|static}>"/>

<script type="text/javascript" src="<{'js/zTree/jquery.ztree.core.min.js'|static}>"></script>
<script type="text/javascript" src="<{'js/zTree/jquery.ztree.exedit.min.js'|static}>"></script>
<link rel="stylesheet" href="<{'css/zTree/zTreeStyle/zTreeStyle.css'|static}>"/>
<link rel="stylesheet" href="<{'css/catalog/catalog.css'|plugins nofilter}>">
<{if !empty($_table_data)}>
<script>
var TreeData = <{$_table_data->toArray()|json_encode nofilter}>;
//TreeData.push({id: 0, pid: -1, title: '总分类'} );
</script>
<script src="<{'js/jquery.connections.js'|static nofilter}>"></script>
<script src="<{'js/catalog/form-check.js'|plugins nofilter}>"></script>
<script src="<{'js/catalog/catalog.js'|plugins nofilter}>"></script>
<{/if}>
<{/block}>

<{block "block-container"}>
<div class="block full">
	<div class="block-title">
		<nav class="navbar navbar-default">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><strong>系统分类</strong></a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<{foreach $_topNodes as $node}>
					<li class="<{if $_root->getKey() == $node->getKey()}>active<{/if}>"><a href="<{'admin/catalog'|url}>/<{$node->getKey()}>"><{$node->title}>(<{$node->name}>)</a></li>
					<{/foreach}>
					<li><a href="" class="btn btn-link"><i class="fa fa-plus"></i> 顶级分类</a></li>
				</ul>
				<div class="block-options pull-right">
					<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-content" title="折叠/展示" data-original-title="折叠/展示"><i class="fa fa-arrows-v"></i></a>
					<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-fullscreen" title="全屏切换" data-original-title="全屏切换"><i class="fa fa-desktop"></i></a>
				</div>
			</div>
			<div class="clearfix"></div>
		</nav>
		<div class="clearfix"></div>
	</div>
		
	<div class="block-content">
	<{if empty($_table_data)}>
		<div class="well well-lg col-sm-10 col-sm-offset-1">
			<p>请选择：<b>顶级分类</b>后，再操作。</p>
			<ul>
				<{foreach $_topNodes as $node}>
				<li><a href="<{'admin/catalog'|url}>/<{$node->getKey()}>"><{$node->title}>(<{$node->name}>)</a></li>
				<{/foreach}>
			</ul>
		</div>
	<{else}>
		<div class="row catalog-container">
			<div class="col-md-4">
				<form action="<{'admin/catalog/order'|url}>" method="POST" id="order-form">
				<{csrf_field() nofilter}>
				<div class="page-header">
					<span class="text-right">可拖动排序</span>
				</div>
				<ul id="tree" class="ztree"></ul>

				</form>
			</div>
			<div class="col-md-8">
				<div class="catalog-form">
					<form action="" method="POST" class="hidden form-horizontal form-bordered" id="form">
						<{csrf_field() nofilter}>
						<input type="hidden" name="_method" value="POST">
						<input type="hidden" name="field_class" value="<{$_filters.catalog}>">
						<div class="form-group">
							<label for="name" class="col-sm-2 control-label">名称</label>
							<div class="col-sm-10">
								<input type="text" id="name" name="name" class="form-control" placeholder="请输入名称">
								<span class="help-block">唯一值。允许英文、下划线、数字，<b>请参考已设置项</b></span>
							</div>
						</div>
						<div class="form-group">
							<label for="name" class="col-sm-2 control-label">父级</label>
							<div class="col-sm-10">
								<input type="hidden" id="pid" name="pid">
								<p class="form-control-static" id="p-title"></p>
							</div>
						</div>
						<div class="form-group">
							<label for="title" class="col-sm-2 control-label">标题</label>
							<div class="col-sm-10">
								<input type="text" id="title" name="title" class="form-control" placeholder="请输入标题">
								<span class="help-block">汉字名称，<b>请参考已设置项</b></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-10 col-sm-offset-2 text-center">
								<button type="submit" class="btn btn-success">保存</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-12" style="border-top:1px #ccc solid;">
				<h3 class="bold">操作事项：</h3>
				<ol class="help">
					<li><b>操作：</b>鼠标移动到项目上，会出现2个图标，分别是
						<ol class="help">
							<li><span class="button add"></span> <code>新增节点</code>，给当前节点添加一个子项</li>
							<li><span class="button edit"></span> <code>点击节点</code>，修改当前节点</li>
							<li><span class="button remove"></span> <code>删除节点</code>，删除当前节点</li>
						</ol>
					</li>
					<li><b>排序：</b>选中一项后，拖拽就可以进行排序（限制在同父级、同级别内），排序直接影响到前台显示</li>
				</ol>
			</div>
		</div>
	<{/if}>
	</div>
	<div class="clearfix"></div>
	
</div>

<{/block}>