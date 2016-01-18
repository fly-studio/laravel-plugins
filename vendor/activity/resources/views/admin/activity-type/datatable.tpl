<{extends file="admin/extends/datatable.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>活动类型<{/block}>

<{block "name"}>activity-type<{/block}>

<{block "table-th-plus"}>
<th>类型名</th>
<th>类名</th>
<{/block}>

<!-- DataTable的Block -->

<{block "datatable-config-pageLength"}><{$_pagesize}><{/block}>

<{block "datatable-columns-plus"}>
var columns_plus = [
	{'data': 'name'},
	{'data': 'class_dir'}
];
<{/block}>
<{block "datatable-columns-options-plus"}>
var columns_options_plus = [
	'<a href="<{'admin/activity?'|url}>base=&filters[type_id][in][]='+full['id']+'" data-toggle="tooltip" title="活动列表" class="btn btn-xs btn-info"><i class="fa fa-crosshairs"></i></a>'
];
<{/block}>
<{block "datatable-columns-options-delete-confirm"}>var columns_options_delete_confirm = '您确定删除这个活动类型：'+full['name']+'吗？';<{/block}>