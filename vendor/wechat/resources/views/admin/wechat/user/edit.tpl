<{extends file="admin/extends/edit.block.tpl"}>

<{block "head-plus"}>
<script src="<{'js/DatePicker/WdatePicker.js'|static}>"></script>
<{include file="common/uploader.inc.tpl"}>
<script src="<{'js/wechat/choose.min.js'|plugins}>"></script>
<{/block}>

<{block "inline-script-plus"}>
$('#avatar_aid').uploader();
<{/block}>

<{block "title"}>微信用户<{/block}>
<{block "subtitle"}><{$_data.openid}><{/block}>

<{block "name"}>wechat/user<{/block}>

<{block "id"}><{$_data->id}><{/block}>

<{block "fields"}>
<{include file="[wechat]admin/wechat/user/fields.inc.tpl"}>
<{/block}>
