<{extends file="admin/extends/list.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>微信自定义回复<{/block}>

<{block "name"}>wechat/reply<{/block}>

<{block "filter"}>
<{include file="[wechat]admin/wechat/reply/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>关键词</th>
<th>匹配类型</th>
<th>关联素材</th>
<th>随机回复</th>
<{/block}>

<!-- 基本视图的Block -->

<{block "table-td-plus"}>
<td class="text-center"><img src="<{'attachment/resize'|url}>?id=<{$item->qr_aid}>&width=80&height=80" alt="avatar" class="img-responsive"></td>
<td><{$item->keywords}></td>
<td><{$item->appid}></td>
<td><{$item->depots()->count()}></td>
<td><{$item->reply_count}></td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个关键词：<{$item->keywords}>吗？<{/block}>
