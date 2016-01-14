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
<th>封面</th>
<th>标题</th>
<th>活动类型</th>
<th>起始时间</th>
<th>终止时间</th>
<th>状态</th>
<{/block}>

<!-- 基本视图的Block -->
<{block "table-td-options-plus"}>
<a href="<{'factory/product?'|url}>base=&filters[activity_type][in][]=<{$item->getKey()}>" data-toggle="tooltip" title="商品列表" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
<{/block}>

<{block "table-td-plus"}>

<td class="text-center"><img src="<{'attachment/resize'|url}>?id=<{$item->aid}>&width=80&height=80" alt="avatar" class="img-circle"></td>
<td><{$item->name}></td>
<td><{$item->activity_type->name}>%</td>
<td><{$item->start_date}>%</td>
<td><{$item->end_date}></td>
<td><{$item->status_tag}></td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个产品：<{$item->title}>吗？<{/block}>