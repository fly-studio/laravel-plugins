<{extends file="admin/extends/edit.block.tpl"}>

<{block "head-plus"}>
<{/block}>

<{block "inline-script-plus"}>
var $groups = $('.form-group', '#form');
$('#password,#password_confirmation,#username,:submit', '#form').closest('.form-group').clone(true).appendTo('#form');
$groups.remove();
$('#username').replaceWith('<p class="form-control-static"><{$_data.username}></p>');
<{/block}>

<{block "title"}>用户资料<{/block}>
<{block "subtitle"}>修改当前用户的密码<{/block}>


<{block "name"}>password<{/block}>

<{block "fields"}>
<{include file="admin/member/fields.inc.tpl"}>
<{/block}>
