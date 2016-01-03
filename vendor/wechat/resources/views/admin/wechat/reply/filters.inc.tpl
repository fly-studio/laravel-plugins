<!-- Form Content -->
<form action="<{'admin'|url}>/<{block "name"}><{/block}>/" method="GET" class="form-bordered form-horizontal">
	<input type="hidden" name="base" value="<{$_base}>">
	<div class="form-group col-sm-4">
		<label class="col-md-3 control-label" for="name">名称</label>
		<div class="col-md-9">
			<div class="input-group">
				<input type="text" id="name" name="name[like]" class="form-control" placeholder="请输入关键词..." value="<{$_filters.name.like}>">
				<span class="input-group-addon"><i class="gi gi-user"></i></span>
			</div>
		</div>
	</div>

	<div class="form-group col-sm-4">
		<label class="col-md-3 control-label" for="appid">APP ID</label>
		<div class="col-md-9">
			<div class="input-group">
				<input type="text" id="appid" name="appid[like]" class="form-control" placeholder="请输入关键词..." value="<{$_filters.appid.like}>">
				<span class="input-group-addon"><i class="gi gi-user"></i></span>
			</div>
		</div>
	</div>

	<div class="form-group col-sm-4">
		<label class="col-md-3 control-label" for="created_at-min">加入时间</label>
		<div class="col-md-9">
			<div class="input-group input-daterange">
				<input type="text" id="created_at-min" name="created_at[min]" class="form-control text-center" placeholder="开始时间" value="<{$_filters.created_at.min}>">
				<span class="input-group-addon">～</span>
				<input type="text" id="created_at-max" name="created_at[max]" class="form-control text-center" placeholder="结束时间" value="<{$_filters.created_at.max}>">
			</div>
		</div>
	</div>
	<div class="form-group col-sm-4 pull-right text-right">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> 检索</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重置</button>
	</div>
	<div class="clearfix"></div>
</form>
<!-- END Form Content -->
<script>
(function($){
	$().ready(function(){
		$('#created_at-min').on('focus',function(){
			WdatePicker({
				skin: 'twoer',
				isShowClear:true,
				readOnly:true,
				dateFmt:'yyyy-MM-dd',
				isShowOthers:false,
				maxDate: '#F{$dp.$D(\'created_at-max\')}'
			});
		});
		$('#created_at-max').on('focus',function(){
			WdatePicker({
				skin: 'twoer',
				isShowClear:true,
				readOnly:true,
				dateFmt:'yyyy-MM-dd',
				isShowOthers:false,
				minDate: '#F{$dp.$D(\'created_at-min\')}'
			});
		});
	});
})(jQuery);
</script>