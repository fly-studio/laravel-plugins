<{extends file="admin/extends/create.block.tpl"}>

<{block "head-plus"}>
<script src="<{'js/DatePicker/WdatePicker.js'|static}>"></script>
<{/block}>

<{block "inline-script-plus"}>
<{/block}>

<{block "title"}>OAuth客户端<{/block}>

<{block "name"}>oauth/client<{/block}>

<{block "fields"}>
<{include file="[oauth2]admin/oauth/client/fields.inc.tpl"}>
<{/block}>
