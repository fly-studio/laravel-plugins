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

<!-- 基本视图的Block -->

<{block "table-td-plus"}>
<td class="text-center"><img src="<{'attachment/resize'|url}>?id=<{$item->qr_aid}>&width=80&height=80" alt="avatar" class="img-responsive"></td>
<td><{$item->name}></td>
<td><{$item->display_name}></td>
<td><{$item->description}></td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个权限：<{$item->display_name}>吗？<{/block}>
