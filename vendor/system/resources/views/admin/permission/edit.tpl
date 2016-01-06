<{extends file="admin/extends/edit.block.tpl"}>

<{block "head-plus"}>
<{/block}>

<{block "inline-script-plus"}>
$('[name="name"]', '#form').prop('disabled', true);
<{/block}>

<{block "title"}>权限<{/block}>
<{block "subtitle"}><{$_data.name}><{/block}>

<{block "name"}>permission<{/block}>

<{block "fields"}>
<{include file="[system]admin/permission/fields.inc.tpl"}>
<{/block}>
