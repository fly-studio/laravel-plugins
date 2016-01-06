<div class="form-group">
	<label class="col-md-3 control-label" for="name">名称</label>
	<div class="col-md-9">
		<input type="text" id="name" name="name" class="form-control" placeholder="请输入名称" value="<{$_data.name}>">
		<span class="help-block">(*) 只能为英文、下划线，比如：member.create、order.view，不可重名，提交后不可修改</span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="display_name">显示名称</label>
	<div class="col-md-9">
		<input type="text" id="display_name" name="display_name" class="form-control" placeholder="请输入显示名称" value="<{$_data.display_name}>">
		<span class="help-block">(*) 权限名称，用于显示，比如：允许浏览后台页面</span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="description">简介</label>
	<div class="col-md-9">
		<textarea id="description" name="description" rows="9" class="form-control" placeholder="简介.."><{$_data->description}></textarea>
	</div>
</div>
<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重设</button>
	</div>
</div>