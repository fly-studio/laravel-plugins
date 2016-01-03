<{extends file="admin/extends/edit.block.tpl"}>

<{block "head-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#qr_aid').uploader();
<{/block}>

<{block "title"}>微信账号<{/block}>
<{block "subtitle"}><{$_data.name}><{/block}>

<{block "name"}>wechat/account<{/block}>

<{block "fields"}>
<{include file="[wechat]admin/wechat/account/fields.inc.tpl"}>
<{/block}>
