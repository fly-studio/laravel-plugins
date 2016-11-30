<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>微信用户<{/block}>

<{block "name"}>wechat/user<{/block}>

<{block "head-scripts-after"}>
<script src="<{'js/emojione.js'|static}>"></script>
<script src="<{'js/wechat/choose.min.js'|plugins}>"></script>
<{/block}>

<{block "filter"}>
<{include file="[wechat]admin/wechat/user/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th class="text-center"><i class="gi gi-user"></i></th>
<th>OPEN ID</th>
<th>唯一ID</th>
<th>昵称</th>
<th>备注</th>
<th>性别</th>
<th>关注</th>
<th>国家</th>
<th>省份</th>
<th>城市</th>
<{/block}>

<!-- DataTable的Block -->
<{block "table-td-plus"}>
<td data-from="avatar_aid" data-orderable="false">
	<img src="<{'attachment/resize'|url}>?id={{data}}&width=80&height=80" alt="avatar" class="img-responsive">
</td>
<td data-from="openid">
	<a href="<{'admin/wechat/user'|url}>/{{full.id}}">{{data}}</a>
</td>
<td data-from="unionid">{{data}}</td>
<td data-from="nickname"><span class="enable-emoji">{{if data}}{{data.emojione()}}{{/if}}</span></td>
<td data-from="remark">{{data}}</td>
<td data-from="gender"><span class="label label-primary">{{data.title || '未知'}}</span></td>
<td data-from="subscribed_at">
{{if full.is_subscribed}}
{{data}}
{{else}}
<span class="label label-info">未关注</span>
{{/if}}
<td data-from="country">{{data}}</td>
<td data-from="province">{{data}}</td>
<td data-from="city">{{data}}</td>
</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个微信用户：{{full.openid}}吗？<{/block}>