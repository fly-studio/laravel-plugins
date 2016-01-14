<{extends file="admin/extends/edit.block.tpl"}>

<{block "title"}>活动类型<{/block}>
<{block "subtitle"}><{$_data.name}><{/block}>

<{block "name"}>activity-type<{/block}>

<{block "fields"}>
<{include file="admin/activity-type/fields.inc.tpl"}>
<{/block}>
