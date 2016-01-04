<{extends file="admin/extends/create.block.tpl"}>

<{block "head-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#qr_aid').uploader();
<{/block}>

<{block "title"}>微信公众号菜单<{/block}>

<{block "name"}>wechat/menu<{/block}>

<{block "fields"}>
<{include file="[wechat]admin/wechat/menu/fields.inc.tpl"}>
<{/block}>
