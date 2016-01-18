<{extends file="admin/extends/create.block.tpl"}>

<{block "head-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{include file="common/editor.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#aid').uploader(640, 400, undefined, undefined, 1);
<{/block}>

<{block "title"}>活动<{/block}>

<{block "name"}>activity<{/block}>

<{block "fields"}>
<{include file="admin/activity/fields.inc.tpl"}>
<{/block}>
