<{extends file="admin/extends/list.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>微信消息<{/block}>

<{block "name"}>wechat/message<{/block}>

<{block "filter"}>
	<{include file="[wechat]admin/wechat/message/filters.inc.tpl"}>
	<{/block}>

<{block "head-styles-plus"}>
	<style>
		.media {border: 1px #ccc solid;padding: 10px;}
		.media .media-body .media-heading {font-weight: bold;}
		.media .media-body .media-heading small {font-weight: normal; font-size: 0.6em}
		.media .media-body .media-heading .time {font-weight: normal; font-size: 0.5em;color: gray;margin-left:30px;}
		.media .media-body p {padding: 10px; word-break: break-all; word-wrap: break-word; }
	</style>
	<{/block}>

<{block "head-scripts-plus"}>
	<{include file="common/uploader.inc.tpl"}>
	<script>
		(function($){
			$().ready(function(){
				$('a[method]').query();
			});
		})(jQuery);
	</script>
	<{/block}>


<{block "block-content-table"}>
	<div class="block-content-full" style="margin:0 -20px;">
		<!-- You can remove the class .media-feed-hover if you don't want each event to be highlighted on mouse hover -->
		<ul class="media-list media-feed media-feed-hover">
			<{foreach $_table_data as $item}>
			<!-- Status Updated -->
			<li class="media">
				<a href="<{'admin/wechat/user'|url}>/<{$item->user->getKey()}>" class="pull-left">
					<img src="<{'attachment'|url}>?id=<{$item.user.avatar_aid}>&width=120&height=120" alt="Avatar" class="img-circle">
				</a>
				<div class="media-body">
					<p class="push-bit">
					<span class="pull-right">
						<span class="text-info">
							<a href="<{'admin'|url}>/<{block "name"}><{/block}>/<{$item->getKey()}>" method="delete" confirm="您确定删除此条消息？此操作并不会在微信中删除！" data-toggle="tooltip" title="删除" class="text-danger close"><span aria-hidden="true">&times;</span></a>
						</span>
					</span>
						<{if $item->transport_type == 'receive'}> <i class="fa fa-send text-info"></i> <{else}> <i class="fa fa-share text-success"></i> <{/if}>
						<strong><a href="<{'admin/wechat/user'|url}>/<{$item->user->getKey()}>"><{$item->user->nickname}></a> (<{$item->user->openid}>)</strong>
						<small class="text-muted"><{$item->created_at}></small>
					</p>
					<p>
						<{if $item->type == 'text'}> <{$item->text->content|escape|nl2br nofilter}>
						<{else if $item->type == 'image'}> <a href="<{'attachment'|url}>?id=<{$item->media->aid}>" target="_blank"><img src="<{'attachment'|url}>?id=<{$item->media->aid}>" alt="" onload="resizeImg(this, 320, 200);"></a>
						<{else if $item->type == 'voice'}> <audio src="<{'attachment'|url}>?id=<{$item->media->aid}>" controls="controls"></audio> <a href="<{'attachment/download'|url}>?id=<{$item->media->aid}>" target="_blank">下载</a>
						<{else if $item->type == 'video' || $item->type == 'shortvideo'}> <video src="<{'attachment'|url}>?id=<{$item->media->aid}>" controls="controls" style="max-width:320px;max-height:240px;"></video> <a href="<{'attachment/download'|url}>?id=<{$item->media->aid}>" target="_blank">下载</a>
						<{else if $item->type == 'location'}> <{$item->location->x}>, <{$item->location->y}> <a href="">查看地图</a><br /><{$item->location->label}>
						<{else if $item->type == 'link'}> <a href="<{$item->link->url}>" target="_blank"><{$item->link->title}></a> <br /><{$item->link->description}>
						<{/if}>
					</p>
					<{if $item->transport_type == 'receive'}>
					<p>
						<a href="<{'admin'|url}>/<{block "name"}><{/block}>/<{$item->user->getKey()}>" data-nickname="<{$item->user->nickname}> (<{$item->user->openid}>)" name="reply" class="btn btn-xs btn-default"><i class="fa fa-reply"></i> 回复</a>
						<a href="javascript:void(0)" class="btn btn-xs btn-default"><i class="fa fa-share-square-o"></i> Share</a>
					</p>
					<{else }>
					<p>
						回复“<{$item->user->nickname}>”
					</p>
					<{/if}>
				</div>
				<div class="clearfix"></div>
			</li>
			<{/foreach}>
			<!-- END Status Updated -->
		</ul>
	</div>

	<div class="row">
		<div class="col-sm-5 hidden-xs">
			<span><{$_table_data->firstItem()}> - <{$_table_data->lastItem()}> / <{$_table_data->total()}></span>
		</div>
		<div class="col-sm-7 col-xs-12 clearfix"><{$_table_data->render() nofilter}></div>
	</div>
	<{include file="[wechat]admin/wechat/message/reply.inc.tpl"}>
	<{/block}>