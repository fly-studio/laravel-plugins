<{extends file="admin/extends/datatable.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>微信账号<{/block}>

<{block "name"}>wechat/account<{/block}>

<{block "filter"}>
<{include file="[wechat]admin/wechat/account/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th class="text-center"><i class="glyphicon glyphicon-qrcode"></i></th>
<th>名称</th>
<th>账号</th>
<th>APP ID</th>
<th>用户数</th>
<th>消息数</th>
<th>素材数</th>
<{/block}>

<!-- DataTable的Block -->

<{block "datatable-config-pageLength"}><{$_pagesize}><{/block}>

<{block "datatable-columns-plus"}>
var columns_plus = [
	{'data': "qr_aid", orderable: false, 'render': function(data, type, full){
		return '<img src="<{'attachment/resize'|url}>?id='+data+'&width=80&height=80" alt="avatar" class="img-responsive">';
	}},
	{'data': 'name'},
	{'data': 'account'},
	{'data': 'appid'},
	{'data': 'users-count', orderable: false},
	{'data': 'messages-count', orderable: false},
	{'data': 'depots-count', orderable: false}
];
<{/block}>
<{block "datatable-columns-options-delete-confirm"}>var columns_options_delete_confirm = '您确定删除这个微信：'+full['name']+'吗？';<{/block}>
