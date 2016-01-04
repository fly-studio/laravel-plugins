<div class="form-group">
	<label class="col-md-3 control-label" for="name">上级菜单</label>
	<div class="col-md-9">
		<label  class="form-control"><{if $_data.superior}><{$_data.superior.title}><{else}> <{if $_data.upname}><{$_data.upname}><{else}> 顶级<{/if}><{/if}></label>
		<input type="hidden" id="pid" name="pid" class="form-control" placeholder="请输入菜单名" value="<{$_data.pid}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="title">菜单名</label>
	<div class="col-md-9">
		<input type="text" id="title" name="title" class="form-control" placeholder="请输入菜单名" value="<{$_data.title}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="url">链接</label>
	<div class="col-md-9">
		<input type="text" id="url" name="url" class="form-control" placeholder="链接" value="<{$_data.url}>"/>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="order">排序</label>
	<div class="col-md-9">
		<input type="text" id="order" name="order" class="form-control" placeholder="排序从小到大排列" value="<{$_data.order}>"/>
	</div>
</div>

<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重设</button>
	</div>
</div>