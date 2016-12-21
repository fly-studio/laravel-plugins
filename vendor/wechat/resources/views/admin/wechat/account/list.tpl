<{extends file="admin/extends/list.block.tpl"}>

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
<{block "table-td-plus"}>
<td data-from="qr_aid" data-orderable="false">
	<img src="<{'attachment/resize'|url}>?id={{data}}&width=80&height=80" alt="avatar" class="img-responsive">
</td>
<td data-from="name">{{data}}</td>
<td data-from="account">{{data}}</td>
<td data-from="appid">{{data}}</td>
<td data-from="users_count" data-orderable="false">{{data}}</td>
<td data-from="messages_count" data-orderable="false">{{data}}</td>
<td data-from="depots_count" data-orderable="false">{{data}}</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个微信：{{full.name}}吗？<{/block}>
