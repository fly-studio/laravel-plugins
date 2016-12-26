<{extends file="admin/extends/list.block.tpl"}>

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

<!-- DataTable的Block -->
<{block "table-td-plus"}>
<td data-from="keywords">{{data}}</td>
<td data-from="match_type" data-orderable="false">
{{if data == 'part'}}
<span class="label label-info">模糊匹配</span>
{{else if data == 'part'}}
<span class="label label-warning">全字匹配</span>
{{else if data == 'part'}}
<span class="label label-danger">关注时</span>
{{/if}}
</td>
<td data-from="depots_count" data-orderable="false">{{data}}</td>
<td data-from="reply_count" data-orderable="false">{{data}}</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个关键词：{{full.keywords}}吗？<{/block}>