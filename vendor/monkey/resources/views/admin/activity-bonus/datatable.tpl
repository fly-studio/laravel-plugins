<{extends file="admin/extends/datatable.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>活动活动<{/block}>

<{block "name"}>activity-bonus<{/block}>

<{block "filter"}>
<{include file="admin/activity-bonus/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>用户</th>
<th>厂商</th>
<th>积分</th>
<th>活动</th>
<th>状态</th>
<{/block}>

<!-- DataTable的Block -->

<{block "datatable-config-pageLength"}><{$_pagesize}><{/block}>

<{block "datatable-columns-plus"}>
var columns_plus = [
	{'data': 'users', orderable: false, render: function(data){return data.nickname;}},
	{'data': 'factory', orderable: false, render: function(data){return data.name;}},
	{'data': 'bonus'},
	{'data': 'activity',render:function(data){return data.name;}},
	{'data': 'status_tag'}
];
<{/block}>

<{block "datatable-columns-options"}>
		var columns_options = [{'data': null, orderable: false, 'render': function (data, type, full){
			<{block "datatable-columns-options-delete-confirm"}>var columns_options_delete_confirm = '您确定删除这个积分：'+full['id']+'吗？';<{/block}>
			return '<div class="btn-group">'
				+'<a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block "name"}><{/block}>/'+full['id']+'" method="delete" confirm="'+(columns_options_delete_confirm ? columns_options_delete_confirm : '')+'" data-toggle="tooltip" title="删除" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a></div>';
			}
		}];
<{/block}>
