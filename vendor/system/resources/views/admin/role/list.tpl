<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>用户组<{/block}>

<{block "name"}>role<{/block}>

<{block "head-scripts-plus"}>
<script>
(function($){
	$().ready(function(){
		$('a[method]').query();
		<{call validate selector='#form'}>
		$('[name="role/list"]').addClass('active').parents('li').addClass('active');
	});
})(jQuery);
</script>
<{/block}>

<{block "block-container"}>
<div class="row">
	<div class="col-xs-12">
		<div class="block">
			<div class="block-title">
				<div class="block-options pull-right">
					<a href="<{'admin/role'|url}>" name="create-modal" class="btn btn-alt btn-info btn-sm"><i class="fa fa-plus"></i> 添加组</a>
				</div>
				<ul class="nav nav-tabs" data-toggle="tabs">
				<{foreach $_table_data as $item}>
					<li class="<{if $item@index == 0}>active<{/if}>"><a href="#role-<{$item->getKey()}>"><{$item->display_name}></a></li>
				<{/foreach}>
				</ul>
				
			</div>
			<form action="<{'admin/role/-1'|url}>" method="POST" id="form">
				<{csrf_field() nofilter}>
				<{method_field('PUT') nofilter}>
			<div class="tab-content">
				<{foreach $_table_data as $item}>
				<div class="tab-pane <{if $item@index == 0}>active<{/if}>" id="role-<{$item->getKey()}>">
					<input type="hidden" name="name" value="<{$item->name}>">
					<input type="hidden" name="display_name" value="<{$item->display_name}>">
					<input type="hidden" name="url" value="<{$item->url}>">
					<textarea class="hidden" name="description"><{$item->description}></textarea>
					<h3 class="page-header">
						<{$item->display_name}> <small> (<{$item->name}>) </small>&nbsp;&nbsp;&nbsp;
						<small class="text-danger"><a href="<{'admin/role'|url}>/<{$item->getKey()}>" name="edit-modal"><i class="fa fa-edit"></i> 修改名称</a>
						&nbsp;&nbsp;&nbsp;<{if $item->getKey() > 99}><a href="<{'admin/role'|url}>/<{$item->getKey()}>" name="delete-modal" data-role_name="<{$item->display_name}>(<{$item->name}>)" data-role_id="<{$item->getKey()}>"><i class="fa fa-times"></i>  删除</a><{/if}></small></h3>
					<p><i><{$item->description}></i></p>
					<p><b>组ID：</b><{$item->getKey()}></p>
					<p><b>用户：</b><a href="<{'admin/member'|url}>?filters[role_id][in][]=<{$item->getKey()}>"><{$item->users()->count()}> 个</a></p>
					<h4 class="sub-header">权限</h4>
					<div class="row">
					<{foreach $_perms_data as $perm}>
						<div class="col-md-6">
							<div class="col-md-8">
								<{$perm->display_name}>
								<p>
									<small><{$perm->name}></small>
								</p>
							</div>
							<div class="col-md-4">
								<label class="switch switch-info"><input type="checkbox" name="perms[<{$item->getKey()}>][]" value="<{$perm->getKey()}>" <{if array_key_exists($perm->getKey(), $item->perms->keyBy('id')->toArray())}>checked="checked"<{/if}>><span></span></label>
							</div>
						</div>
					<{/foreach}>
					</div>
				</div>
				<{/foreach}>
				<div class="text-center">
					<button type="submit" class="btn btn-success">保存权限</button>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
<{include file="[system]admin/role/edit.inc.tpl"}>

<script>
(function($){
$().ready(function(){
	<{call validate selector='#edit-form'}>
	<{call validate selector='#delete-form'}>
	$('[name="edit-modal"]').on('click', function(){
		$('#edit-modal').modal({backdrop: 'static'});

		var $container = $(this).closest('.tab-pane');
		['name', 'display_name', 'description', 'url'].forEach(function(i){
			$('#' + i).val($('[name="'+i+'"]', $container).val());
		})
		$('#name').prop('disabled', true);

		$('#edit-form').attr('action', this.href).find('[name="_method"]').val('PUT');
		return false;
	});

	$('[name="create-modal"]').on('click', function(){
		$('#edit-modal').modal({backdrop: 'static'});
		$('#name,#display_name,#description,#url').prop('disabled', false).val('');
		$('#edit-form').attr('action', this.href).find('[name="_method"]').val('POST');

		return false;
	});

	$('[name="delete-modal"]').on('click', function(){
		$('#delete-modal').modal({backdrop: 'static'});
		$('#delete-form').attr('action', this.href);
		$('#role_name').text($(this).data('role_name'));
		$('#original_role_id').val($(this).data('role_id'));
		return false;
	});
});
})(jQuery);
</script>
<{/block}>