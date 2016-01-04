<{extends file="admin/extends/list.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>微信公众号菜单<{/block}>

<{block "name"}>wechat/menu<{/block}>

<{block "table-th-plus"}>
<th>菜单名</th>
<th>链接</th>
<th>排序</th>
<th>深度</th>
<th>路径</th>
<{/block}>

<!-- 基本视图的Block -->

<{block "table-td-plus"}>
<td><{$item->title}></td>
<td><{$item->url}></td>
<td><{$item->order}></td>
<td><{$item->level}></td>
<td><{$item->path}></td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个微信菜单：<{$item->title}>吗？<{/block}>
