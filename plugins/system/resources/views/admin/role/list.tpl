<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>用户组<{/block}>

<{block "name"}>role<{/block}>

<{block "head-scripts-plus"}>
<script src="<{'js/zTree/jquery.ztree.core.min.js'|static}>"></script>
<script src="<{'js/zTree/jquery.ztree.exedit.min.js'|static}>"></script>
<link rel="stylesheet" href="<{'css/zTree/zTreeStyle/zTreeStyle.css'|static}>"/>
<link rel="stylesheet" href="<{'css/system/role.min.css'|plugins nofilter}>">
<script>
var TreeData = <{$_table_data->toArray()|json_encode nofilter}>;

(function($){
	$().ready(function(){
		$('a[method]').query();
		<{call validate selector='#form'}>
		$('[name="role/list"]').addClass('active').parents('li').addClass('active');
	});
})(jQuery);
</script>
<script src="<{'js/system/role.min.js'|plugins nofilter}>"></script>
<{/block}>

<{block "block-container"}>
<div class="row">
	<div class="col-xs-12">
		<div class="block">
			<div class="block-title">
				<h2>
					用户组管理
				</h2>
				<div class="block-options pull-right">
					<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-content" title="折叠/展示" data-original-title="折叠/展示"><i class="fa fa-arrows-v"></i></a>
					<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-fullscreen" title="全屏切换" data-original-title="全屏切换"><i class="fa fa-desktop"></i></a>
				</div>
			</div>
			<div>
				<div class="col-md-2 col-xs-12">
					<ul id="tree" class="ztree">
					</ul>
					<div>

					</div>
				</div>
				<div class="col-md-10 col-xs-12">
					<form action="<{'admin/role/-1'|url}>" method="POST" id="form">
					<{csrf_field() nofilter}>
					<{method_field('PUT') nofilter}>

					<{foreach $_table_data as $item}>
					<div class="tab-pane" id="role-<{$item->getKey()}>" data-id="<{$item->getKey()}>" data-role_name="<{$item->display_name}>(<{$item->name}>)" style="display: none">
						<input type="hidden" name="name" value="<{$item->name}>">
						<input type="hidden" name="display_name" value="<{$item->display_name}>">
						<input type="hidden" name="pid" value="<{$item->pid}>">
						<input type="hidden" name="url" value="<{$item->url}>">
						<textarea class="hidden" name="description"><{$item->description}></textarea>
						<h3 class="page-header">
							<{$item->display_name}> <small> (<{$item->name}>) </small>&nbsp;&nbsp;&nbsp;
							<small class="text-danger">
								<a href="javascript:void(0)" name="create-modal"><i class="fa fa-plus"></i> 添加子用户组</a>
								&nbsp;&nbsp;&nbsp;
								<a href="javascript:void(0)" name="edit-modal"><i class="fa fa-edit"></i> 修改名称</a>
								&nbsp;&nbsp;&nbsp;
								<a href="javascript:void(0)" name="delete-modal"><i class="fa fa-times"></i>  删除</a>
							</small>
						</h3>
						<p><i><{$item->description}></i></p>
						<p><b>组ID：</b><{$item->getKey()}></p>
						<p><b>用户：</b><a href="<{'admin/member'|url}>?f[role_id][in][]=<{$item->getKey()}>"><{$item->users_count}> 个</a></p>
						<{if $item->children_count > 0}>
						<div class="alert alert-danger">
							<ol>
								<li>不建议给此用户组设置权限，因为它拥有「子组」</li>
								<li>不建议将用户放入此用户组</li>
								<li>注意：用户<b>只会</b>享有所属组的权限，不会享有「父组」的权限</li>
								<li>如果该用户设置多个用户组，则权限叠加</li>
							</ol>
						</div>
						<{/if}>
						<h4 class="sub-header">权限</h4>
						<div class="row">
						<{foreach $_permissions_data as $name => $permissions}>
							<h5 class="page-header clearfix"><{$name}></h5>
							<{foreach $permissions as $perm}>
							<div class="col-md-3 col-xs-6">
								<div class="col-md-8">
									<{$perm->display_name}>
									<p>
										<small><{$perm->name}></small>
									</p>
								</div>
								<div class="col-md-3">
									<label class="switch switch-info"><input type="checkbox" name="permissions[<{$item->getKey()}>][]" value="<{$perm->getKey()}>" <{if $item->permissions->has($perm->getKey())}>checked="checked"<{/if}>><span></span></label>
								</div>
							</div>
							<{/foreach}>
							<div class="clearfix"></div>
						<{/foreach}>
						</div>
					</div>
					<{/foreach}>
					<div class="text-center">
						<button type="submit" class="btn btn-success">保存权限</button>
					</div>
					</form>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<{include file="[system]admin/role/edit.inc.tpl"}>

<script>
(function($){
	<{call validate selector='#edit-form'}>
	<{call validate selector='#delete-form'}>
})(jQuery);
</script>
<{/block}>
