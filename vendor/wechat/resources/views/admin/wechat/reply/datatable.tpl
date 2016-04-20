<{extends file="admin/extends/datatable.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>微信自定义回复<{/block}>

<{block "name"}>wechat/reply<{/block}>

<{block "filter"}>
<{include file="[wechat]admin/wechat/reply/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>关键词</th>
<th>匹配类型</th>
<th>关联素材</th>
<th>随机回复</th>
<{/block}>

<!-- DataTable的Block -->

<{block "datatable-config-pageLength"}><{$_pagesize}><{/block}>

<{block "datatable-columns-plus"}>
var columns_plus = [
	{'data': 'keywords'},
	{'data': "match_type", orderable: false, 'render': function(data, type, full){
		switch(data) {
			case 'part':
				return '<span class="label label-info">模糊匹配</span>';
			case 'whole':
				return '<span class="label label-warning">全字匹配</span>';
			case 'subscribe':
				return '<span class="label label-danger">关注时</span>';
		}
	}},
	{'data': 'depots-count', orderable: false},
	{'data': 'reply_count', orderable: false}
];
<{/block}>
<{block "datatable-columns-options-delete-confirm"}>var columns_options_delete_confirm = '您确定删除这个关键词：'+full['keywords']+'吗？';<{/block}>
