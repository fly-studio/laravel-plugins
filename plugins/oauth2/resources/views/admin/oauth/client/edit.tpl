<{extends file="admin/extends/edit.block.tpl"}>

<{block "head-plus"}>
<script src="<{'js/DatePicker/WdatePicker.js'|static}>"></script>
<{/block}>

<{block "inline-script-plus"}>
$('#user_id').prop('disabled', true);
<{/block}>

<{block "title"}>OAuth客户端<{/block}>
<{block "subtitle"}><{$_data.name}><{/block}>

<{block "name"}>oauth/client<{/block}>

<{block "id"}><{$_data->id}><{/block}>

<{block "fields"}>
<{include file="[oauth2]admin/oauth/client/fields.inc.tpl"}>
<{/block}>
