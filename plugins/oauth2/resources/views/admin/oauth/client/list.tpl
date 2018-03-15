<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>OAuth客户端<{/block}>

<{block "name"}>oauth/client<{/block}>

<{block "filter"}>
<{include file="[oauth2]admin/oauth/client/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>名称</th>
<th>Client ID</th>
<th>来源URI</th>
<th>回调URI</th>
<th>个人</th>
<th>密码</th>
<th>废弃</th>
<{/block}>

<!-- DataTable的Block -->
<{block "table-td-plus"}>
<td data-from="name">
	<a href="<{'admin/oauth/client'|url}>/{{full.id}}" target="_blank">{{data}}</a>
</td>
<td data-from="id">{{data}}</td>
<td data-from="redirect">{{data}}</td>
<td data-from="callback">{{data}}</td>
<td data-from="personal_access_client" class="text-center">
{{if data}}
<i class="fa fa-check text-success"></i>
{{/if}}
</td>
<td data-from="password_client" class="text-center">
{{if data}}
<i class="fa fa-check text-success"></i>
{{/if}}
</td>
<td data-from="revoked" class="text-center">
{{if data}}
<i class="fa fa-check text-danger"></i>
{{/if}}
</td>

<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个OAuth客户端：{{full.name}}吗？<{/block}>
