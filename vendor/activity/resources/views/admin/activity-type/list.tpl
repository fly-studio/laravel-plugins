<{extends file="admin/extends/list.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>产品<{/block}>

<{block "name"}>product<{/block}>

<{block "filter"}>
<{include file="admin/product/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>类型名</th>
<th>类名</th>
<{/block}>

<!-- 基本视图的Block -->
<{block "table-td-options-plus"}>
<a href="<{'admin/activity?'|url}>base=&filters[type_id][in][]=<{$item->getKey()}>" data-toggle="tooltip" title="商品列表" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
<{/block}>

<{block "table-td-plus"}>

<td class="text-center"><img src="<{'attachment/resize'|url}>?id=<{$item->aid}>&width=80&height=80" alt="avatar" class="img-circle"></td>
<td><{$item->name}></td>
<td><{$item->class_dir}></td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个活动类型：<{$item->title}>吗？<{/block}>