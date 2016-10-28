<{extends file="admin/extends/show.block.tpl"}>

<{block "title"}>微信用户<{/block}>
<{block "subtitle"}><{$_data.openid}><{/block}>

<{block "name"}>wechat/user<{/block}>

<{block "head-plus"}>
<script src="<{'plugins/js/wechat/choose.min.js'|url}>"></script>
<{/block}>

<{block "block-container"}>
<div class="row">
	<div class="col-md-6">
		
	</div>
	<div class="col-md-6">
		
	</div>
</div>
<{/block}>