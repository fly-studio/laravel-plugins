<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-pencil"></i> 修改</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<form action="index.html" id="edit-form" method="post" class="form-horizontal" >
				<{csrf_field() nofilter}>
				<{method_field('PUT') nofilter}>
					<div class="form-group">
						<label class="col-md-3 control-label" for="name">组名</label>
						<div class="col-md-9">
							<input type="text" id="name" name="name" class="form-control" value="admin@example.com">
							<span class="help-block">(*) 只能为英文、下划线，比如：admin、viewer，不可重名，提交后不可修改</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="display_name">显示名</label>
						<div class="col-md-9">
							<input type="text" id="display_name" name="display_name" class="form-control" value="">
							<span class="help-block">(*) 组名称，用于显示，比如：管理员、普通用户</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="description">介绍</label>
						<div class="col-md-9">
							<textarea name="description" id="description" class="form-control" rows="10" placeholder="请输入简介"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="url">后台路由名</label>
						<div class="col-md-9">
							<input type="text" id="url" name="url" class="form-control" value="">
							<span class="help-block">(*) 也就是文件名，比如：admin。留空表示首页</span>
						</div>
					</div>
					<div class="form-group form-actions">
						<div class="col-xs-12 text-right">
							<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">关闭</button>
							<button type="submit" class="btn btn-sm btn-primary">提交</button>
						</div>
					</div>
				</form>
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>

<div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-pencil"></i> 删除用户组</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<form action="index.html" id="delete-form" method="post" confirm="您确定删除该组吗？" class="form-horizontal" >
				<{csrf_field() nofilter}>
				<{method_field('DELETE') nofilter}>
				<input type="hidden" name="original_role_id" id="original_role_id" value="">
					<div class="form-group">
						<label class="col-md-3 control-label" for="name">待删除的组名</label>
						<div class="col-md-9">
							<p class="form-control-static" id="role_name">Admin</p>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-md-3 control-label" for="name">待转移的组名</label>
						<div class="col-md-9">
							<select class="form-control select-model" style="width:80%" name="role_id" id="role_id" data-model="role" data-id="{id}" data-text="{display_name}({name})" ></select>
							<span class="help-block">(*) 删除用户组，需要将组下的用户转移到其它组</span>
						</div>
					</div>		
					<div class="form-group form-actions">
						<div class="col-xs-12 text-right">
							<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">关闭</button>
							<button type="submit" class="btn btn-sm btn-primary">提交</button>
						</div>
					</div>
				</form>
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>
