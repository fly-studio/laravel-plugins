<{extends file="admin/extends/create.block.tpl"}>

<{block "head-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#qr_aid').uploader();
<{/block}>

<{block "title"}>微信账号<{/block}>

<{block "name"}>wechat/account<{/block}>

<{block "fields"}>
<{include file="[wechat]admin/wechat/account/fields.inc.tpl"}>
<{/block}>
