<{extends file="admin/extends/list.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>权限<{/block}>

<{block "name"}>permission<{/block}>

<{block "filter"}>
<{include file="[system]admin/permission/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>名称</th>
<th>显示名称</th>
<th>简介</th>
<{/block}>

<!-- DataTable的Block -->

<{block "table-td-plus"}>
<td data-from="name">{{data}}</td>
<td data-from="display_name">{{data}}</td>
<td data-from="description">{{data}}</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这项：{{full.display_name}}吗？<{/block}>
