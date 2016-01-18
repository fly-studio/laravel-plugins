<div class="form-group">
	<label class="col-md-3 control-label" for="name">类型名</label>
	<div class="col-md-9">
		<input type="text" id="name" name="name" class="form-control" placeholder="请输入活动名称" value="<{$_data.name}>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="class_dir">对应类名</label>
	<div class="col-md-9">
		<input type="text" name="class_dir" id="class_dir" class="form-control" value="<{$_data.class_dir}>" />
	</div>
</div>


<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重设</button>
	</div>
</div>