<{extends file="admin/extends/datatable.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>微信账号菜单<{/block}>

<{block "name"}>wechat/menu<{/block}>

<{block "item_add"}>&nbsp;&nbsp;<a href="<{'admin/wechat/menu/takeEffect'|url}>">生效</a><{/block}>

<{block "table-th-plus"}>
<th>菜单名</th>
<th>链接</th>
<th>排序</th>
<th>深度</th>
<th>路径</th>
<{/block}>

<!-- DataTable的Block -->

<{block "datatable-columns-options-plus"}>
    if(full['level']<2)
		var columns_options_plus = [
	'<a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block "name"}><{/block}>/?pid='+full['id']+'" data-toggle="tooltip" title="子项" class="btn btn-xs btn-default"><i class="fa fa-adjust"></i></a>'
	+'<a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block "name"}><{/block}>/create?pid='+full['id']+'" data-toggle="tooltip" title="增加子项" class="btn btn-xs btn-default"><i class="fa fa-info"></i></a>'
	];
	else
	   var columns_options_plus = [];
<{/block}>

<{block "datatable-config-pageLength"}><{$_pagesize}><{/block}>

<{block "datatable-columns-plus"}>
var columns_plus = [
	{'data': 'title', orderable: false},
	{'data': 'url', orderable: false},
	{'data': 'order', orderable: false},
	{'data': 'level', orderable: false},
	{'data': 'path', orderable: false}
];
<{/block}>
<{block "datatable-columns-options-delete-confirm"}>var columns_options_delete_confirm = '您确定删除这个菜单：'+full['title']+'吗？';<{/block}>
