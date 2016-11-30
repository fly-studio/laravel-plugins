<{extends file="admin/extends/list.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl
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
<{block "table-td-plus"}>
<td data-from="transaction_id">{{data}}</td>
<td data-from="out_trade_no">{{data}}</td>
<td data-from="total_fee">{{data}}</td>
<td data-from="return_code">{{data}}</td>
<td data-from="return_msg">{{data}}</td>
<{/block}>

<{block "table-th-options"}><{/block}>
<{block "table-td-options"}><{/block}>
