<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>社交平台<{/block}>

<{block "name"}>socialite<{/block}>

<{block "head-plus"}>
<link rel="stylesheet" href="<{'css/socialites.css'|static nofilter}>">
<{/block}>


<{block "filter"}>
<{include file="[socialite]admin/socialite/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>名称</th>
<th>类型</th>
<th>Client ID</th>
<th>Client Extra</th>
<th>默认用户组</th>
<{/block}>

<!-- DataTable的Block -->
<{block "table-td-plus"}>
<td data-from="name">
	<a href="<{'admin/socialite'|url}>/{{full.id}}" target="_blank">{{data}}</a>
</td>
<td data-from="socialite_type"><span class="icon-sn-{{data.name}}"></span> {{data.title}} ({{data.name}})</td>
<td data-from="client_id">{{data}}</td>
<td data-from="extra">{{data}}</td>
<td data-from="default_role">{{if data}}{{data.display_name}} ({{data.name}}){{/if}}</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个微信用户：{{full.openid}}吗？<{/block}>
