<{extends file="admin/extends/list.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>微信用户<{/block}>

<{block "name"}>wechat/user<{/block}>

<{block "head-scripts-after"}>
<script src="<{'static/js/emojione.js'|url}>"></script>
<script>
(function($){
$().ready(function(){
	$('.enable-emoji').each(function(){
		var html = $(this).html();
		$(this).html(html.emojione());
	});
});
})(jQuery);
</script>
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

<!-- 基本视图的Block -->

<{block "table-td-plus"}>
<td class="text-center"><img src="<{'attachment/resize'|url}>?id=<{$item->avatar_aid}>&width=80&height=80" alt="avatar" class="img-responsive"></td>
<td><a href="<{'admin/wechat/user'|url}>/<{$item->getKey()}>"><{$item->openid}></a></td>
<td><{$item->unionid}></td>
<td><span class="enable-emoji"><{$item->nickname}></span></td>
<td><{$item->remark}></td>
<td><{$item->_gender|model:'title'}></td>
<td><{if !empty($item->is_subscribed)}><{$item->subscribed_at}><{else}><span class="label label-info">未关注</span><{/if}></td>
<td><{$item->country}></td>
<td><{$item->province}></td>
<td><{$item->city}></td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个微信账号：<{$item->openid}>吗？<{/block}>
