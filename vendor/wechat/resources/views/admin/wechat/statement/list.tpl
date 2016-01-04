<{extends file="admin/extends/list.block.tpl"}>
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

<!-- 基本视图的Block -->
<{block "table-td-options"}>
	<td class="text-center">
		<div class="btn-group">
			无
		</div>
	</td>
<{/block}>

<{block "table-td-plus"}>
<td><{$item->transaction_id}></td>
<td><{$item->out_trade_no}></td>
<td><{$item->total_fee}></td>
<td><{$item->return_code}></td>
<td><{$item->return_msg}></td>
<{/block}>
