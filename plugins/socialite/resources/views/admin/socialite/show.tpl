<{extends file="admin/extends/show.block.tpl"}>

<{block "title"}>社交平台<{/block}>
<{block "subtitle"}><{$_data.name}><{/block}>

<{block "name"}>socialite<{/block}>

<{block "head-plus"}>
<link rel="stylesheet" href="<{'css/socialites.css'|static nofilter}>">
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
				<dt>名称</dt>
				<dd><{$_data->name}></dd>

				<dt>类型</dt>
				<dd><span class="icon-sn-<{$_data->socialite_type->name}>"></span><{$_data->socialite_type->title}> (<{$_data->socialite_type->name}>)</dd>

				<dt>Client ID</dt>
				<dd><{$_data->client_id}></dd>

				<dt>Client Secret</dt>
				<dd><{$_data->client_secret}> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:" class="copy-btn" data-clipboard-text="<{$_data->client_secret}>">复制</a></dd>

				<dt>其它参数</dt>
				<dd><{$_data->client_extra|default:'{}'|@json_encode:384}></dd>

				<dt>用户默认用户组</dt>
				<dd><{if !empty($_data->default_role)}><{$_data->default_role->display_name}> (<{$_data->default_role->name}>)<{/if}></dd>

			</dl>
		</div>
	</div>
</div>
<{/block}>
