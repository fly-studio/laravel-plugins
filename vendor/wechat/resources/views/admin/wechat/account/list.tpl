<{extends file="admin/extends/list.block.tpl"}>
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
<th>APP ID</th>
<th>用户数</th>
<th>消息数</th>
<th>素材数</th>
<{/block}>

<!-- 基本视图的Block -->

<{block "table-td-plus"}>
<td class="text-center"><img src="<{'attachment/resize'|url}>?id=<{$item->qr_aid}>&width=80&height=80" alt="avatar" class="img-responsive"></td>
<td><{$item->name}></td>
<td><{$item->appid}></td>
<td><{$item->users()->count()}></td>
<td><{$item->messages()->count()}></td>
<td><{$item->depots()->count()}></td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个微信账号：<{$item->name}>吗？<{/block}>
