<{extends file="admin/extends/datatable.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>对帐<{/block}>
<{block "namespace"}>admin<{/block}>
<{block "name"}>wechat/statement<{/block}>

<{block "filter"}>
<{include file="[wechat]admin/wechat/statement/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>微信订单号</th>
<th>订单号</th>
<th>支付金额</th>
<th>状态码</th>
<th>状态信息</th>
<{/block}>

<!-- DataTable的Block -->

<{block "datatable-config-pageLength"}><{$_pagesize}><{/block}>

<{block "datatable-columns-plus"}>
var columns_plus = [
	{'data': 'transaction_id'},
	{'data': 'out_trade_no'},
	{'data': 'total_fee'},
	{'data': 'return_code'},
	{'data': 'return_msg'}
];
<{/block}>

<{block "datatable-columns-options"}>
		var columns_options = [{'data': null, orderable: false, 'render': function (data, type, full){
			return '<div class="btn-group">无</div>';
			}
		}];
<{/block}>
