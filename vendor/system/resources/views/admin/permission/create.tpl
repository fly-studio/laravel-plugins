<{extends file="admin/extends/create.block.tpl"}>

<{block "head-plus"}>
<{/block}>

<{block "inline-script-plus"}>
$('#name,#display_name').on('input propertychange',function(){
	var v = $('#name').val();
	var d = $('#display_name').val();
	var html = '';
	if (v && v.indexOf('*') > -1) {
		html += '<ul>';
		$.each({'view': '查看','create': '新建','edit': '编辑','destroy': '删除','export': '导出'}, function(k1, v1){
			html += '<li>' + v.replace('*', k1) + (d ? ' - 允许' + v1 + d : '') + '</li>';
		});
		html += '</ul>';
	}
	$('#name-example').html(html);
});
<{/block}>

<{block "title"}>权限<{/block}>

<{block "name"}>permission<{/block}>

<{block "fields"}>
<div class="form-group">
	<label class="col-md-3 control-label" for="name">帮助</label>
	<div class="col-md-9 alert alert-info">
	<b>添加一个：</b>
	<ul>
		<li>名称，写全称，比如：member.create</li>
		<li>显示名称，也需要写全称，比如：允许新建用户</li>
	</ul>
	<b>添加多个</b>
	<ul>
		<li>名称，按照通配符：比如：「member.*」。会依次生成
		<ul>
			<li>member.<i>view</i></li>
			<li>member.<i>create</i></li>
			<li>member.<i>edit</i></li>
			<li>member.<i>destroy</i></li>
			<li>member.<i>export</i></li>
		</ul>
		</li>
		<li>显示名称，只需要写主名字，比如：「用户」。会依次命名权限为
		<ul>
			<li>允许<i>查看</i>用户</li>
			<li>允许<i>新建</i>用户</li>
			<li>允许<i>编辑</i>用户</li>
			<li>允许<i>删除</i>用户</li>
			<li>允许<i>导出</i>用户</li>
		</ul>
		</li>
	</ul>
	</div>
</div>
<{include file="[system]admin/permission/fields.inc.tpl"}>

<{/block}>
