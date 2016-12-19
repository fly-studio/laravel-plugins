<{extends file="admin/extends/edit.block.tpl"}>

<{block "head-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#avatar_aid').uploader();
$('#username').replaceWith('<p class="form-control-static"><{$_data.username}></p>');
$('#password,#password_confirmation,#role_ids', '#form').closest('div.form-group').remove();
<{/block}>

<{block "title"}>用户资料<{/block}>
<{block "subtitle"}>修改当前用户的资料<{/block}>


<{block "name"}>profile<{/block}>

<{block "block-title-title"}>
<{include file="admin/member/fields-nav.inc.tpl"}>
<{/block}>

<{block "fields"}>
<{include file="admin/member/fields.inc.tpl"}>
<{/block}>