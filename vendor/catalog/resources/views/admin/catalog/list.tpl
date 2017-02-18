<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>菜单设置<{/block}>

<{block "name"}>catalog<{/block}>

<{block "head-scripts-plus"}>
<{block "head-scripts-zTree"}>
<script type="text/javascript" src="<{'js/zTree/jquery.ztree.core.min.js'|static}>"></script>
<script type="text/javascript" src="<{'js/zTree/jquery.ztree.exedit.min.js'|static}>"></script>
<link rel="stylesheet" href="<{'css/zTree/zTreeStyle/zTreeStyle.css'|static}>"/>
<script type="text/javascript" src="<{'js/zTree/jquery.ztree.core.min.js'|static}>"></script>
<script type="text/javascript" src="<{'js/zTree/jquery.ztree.exedit.min.js'|static}>"></script>
<link rel="stylesheet" href="<{'css/zTree/zTreeStyle/zTreeStyle.css'|static}>"/>
<{/block}>
<{block "head-scripts-vue"}>
<script src="<{'js/vue/vue.min.js'|static nofilter}>"></script>
<{/block}>
<{if !empty($_table_data)}>
<{block "head-scripts-inner-data"}>
<script>
var RootData = <{$_root->toArray()|json_encode nofilter}>;
var TreeData = <{$_table_data->toArray()|json_encode nofilter}>;
//TreeData.push({id: 0, pid: -1, title: '总分类'} );
</script>
<{/block}>
<link rel="stylesheet" href="<{'css/catalog/catalog.css'|plugins nofilter}>">
<{block "head-script-before-vue"}><{/block}>
<{block "head-scripts-vue"}>
<script src="<{'js/catalog/catalog.min.js'|plugins nofilter}>"></script>
<{/block}>
<{block "head-script-after-vue"}><{/block}>
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
					<li class="<{if $_root->getKey() == $node->getKey()}>active<{/if}>"><a href="<{if !empty($_urlPrefix)}><{$_urlPrefix nofilter}><{else}><{'admin/catalog'|url}><{/if}>/<{$node->getKey()}>"><{$node->title}>(<{$node->name}>)</a></li>
					<{/foreach}>
					<!-- <li><a href="" class="btn btn-link"><i class="fa fa-plus"></i> 顶级分类</a></li> -->
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
				<li><a href="<{if !empty($_urlPrefix)}><{$_urlPrefix nofilter}><{else}><{'admin/catalog'|url}><{/if}>/<{$node->getKey()}>"><{$node->title}>(<{$node->name}>)</a></li>
				<{/foreach}>
			</ul>
		</div>
	<{else}>
		<div class="row catalog-container">
			<div class="col-md-4">
				<div class="page-header">
					<span class="text-right">可拖动排序</span>
				</div>
				<ul id="tree" class="ztree"></ul>
			</div>
			<div class="col-md-8">
				<div class="catalog-form" id="catalog-form" url-prefix="<{if !empty($_urlPrefix)}><{$_urlPrefix nofilter}><{else}><{'admin/catalog'|url}><{/if}>">
					<component :is="catalogContainer" csrf="<{csrf_token()}>" :url-prefix="urlPrefix" ref="catalog-form-container">
					</component>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-12" style="border-top:1px #ccc solid;">
				<h3 class="bold">操作事项：</h3>
				<ol class="help">
					<li><b>新增：</b><span class="button add"></span> 给当前节点添加一个子项</li>
					<li><b>排序：</b>选中一项后，拖拽就可以进行排序（限制在同父级、同级别内），排序完成自动保存</li>
					<li><b>编辑：</b>点击任意节点编辑</li>
					<li><b>删除：</b><span class="button remove"></span> 删除当前节点，但是当其子节点不为空，不允许删除</li>
				</ol>
			</div>
		</div>
	<{/if}>
	</div>
	<div class="clearfix"></div>
	
</div>

<{/block}>