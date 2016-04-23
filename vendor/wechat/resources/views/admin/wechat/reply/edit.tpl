<{extends file="admin/extends/edit.block.tpl"}>

<{block "head-plus"}>
<{include file="admin/wechat/depot/selector.tpl"}>
<{/block}>

<{block "inline-script-plus"}>

<{/block}>

<{block "title"}>微信自定义回复<{/block}>
<{block "subtitle"}><{$_data.keywords}><{/block}>

<{block "name"}>wechat/reply<{/block}>

<{block "fields"}>
<{include file="[wechat]admin/wechat/reply/fields.inc.tpl"}>
<{/block}>
