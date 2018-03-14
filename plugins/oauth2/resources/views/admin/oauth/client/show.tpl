<{extends file="admin/extends/show.block.tpl"}>

<{block "title"}>OAuth客户端<{/block}>
<{block "subtitle"}><{$_data.name}><{/block}>

<{block "name"}>oauth/client<{/block}>

<{block "head-plus"}>
<script src="<{'js/clipboard/clipboard.min.js'|static}>"></script>
<script>
(function($){
	$().ready(function(){
		new ClipboardJS('.copy-btn');
	});
})(jQuery);
</script>
<{/block}>

<{block "block-container"}>
<div class="block full">
	<div class="block-title">
		<h2>详细资料</h2>
	</div>
	<div class="block-content">
		<div class="row">
			<dl class="dl-horizontal">
				<dt>绑定用户</dt>
				<dd><{if !empty($_data->user_id)}><{$_data->user->username}> (<{$_data->user->nickname}>，UID：<{$_data->user->getKey()}>)<{/if}></dd>

				<dt>Client ID</dt>
				<dd><{$_data->getKey()}></dd>

				<dt>Client Secret</dt>
				<dd><{$_data->secret}> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:" class="copy-btn" data-clipboard-text="<{$_data->secret}>">复制</a></dd>

				<dt>来源网址</dt>
				<dd><{$_data->redirect}></dd>

				<dt>支付回调</dt>
				<dd><{$_data->callback}></dd>

				<dt>是否是个人客户端</dt>
				<dd><{if $_data->personal_access_client}> <i class="fa fa-check text-success"></i><{/if}></dd>

				<dt>是否是密码客户端</dt>
				<dd><{if $_data->password_client}> <i class="fa fa-check text-success"></i><{/if}></dd>
			</dl>
		</div>
	</div>
</div>
<{/block}>
