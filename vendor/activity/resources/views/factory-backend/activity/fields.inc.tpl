<div class="form-group">
	<label class="col-md-3 control-label" for="name">活动名称</label>
	<div class="col-md-9">
		<input type="text" id="name" name="name" class="form-control" placeholder="请输入活动名称" value="<{$_data.name}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="type_id">活动类型</label>
	<div class="col-md-9">
		<select name="type_id" id="type_id" class="form-control select-model" value="<{if $_data->type_id}><{$_data->type_id}><{else}>0<{/if}>" data-model="factory/activity-type" data-text="{name}" data-placeholder="请选择活动类型"></select>
	</div>
</div>

<div class="form-group add_type" style="display:none;">
	<label class="col-md-3 control-label" for="argc">活动参数</label>
	<div class="col-md-9">
		<input type="text" id="argc" name="argc" class="form-control" placeholder="请输入活动参数" value="<{$_data.argc}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="aid">活动图片</label>
	<div class="col-md-9">
		<select id="aid" name="aid" class="form-control hidden">
			<option value="<{$_data.aid}>" selected="selected"></option>
		</select>
		<div class="alert alert-info"><i class="fa fa-warning"></i> 可以上传20张图片作为产品的封面</div>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="start_date">活动开始时间</label>
	<div class="col-md-9">
		<input type="text" id="start_date" name="start_date" class="form-control" placeholder="请输入活动开始时间" value="<{$_data.start_date|truncate:10:"":true}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="end_date">活动结束时间</label>
	<div class="col-md-9">
		<input type="text" id="end_date" name="end_date" class="form-control" placeholder="请输入活动结束时间" value="<{$_data.end_date|truncate:10:"":true}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="order">排序</label>
	<div class="col-md-9">
		<input type="text" id="order" name="order" class="form-control" placeholder="排序" value="<{$_data.order}>">
	</div>
</div>

<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重设</button>
	</div>
</div>
<script src="<{'static/js/DatePicker/WdatePicker.js'|url}>"></script>
<script>
(function($){
	$().ready(function(){
		$('#start_date').on('focus',function(){
			WdatePicker({
				skin: 'twoer',
				isShowClear:true,
				readOnly:true,
				dateFmt:'yyyy-MM-dd',
				isShowOthers:false
			});
		});
		$('#end_date').on('focus',function(){
			WdatePicker({
				skin: 'twoer',
				isShowClear:true,
				readOnly:true,
				dateFmt:'yyyy-MM-dd',
				isShowOthers:false
			});
		});
		$('#type_id').on('change',function(){
			$.post("<{'factory/activity/getTypeHtml'|url}>", { id: "<{$_data.id}>", type_id: $(this).val(),of:'html'},
			  function(data){
			    $('#type_id').closest('.form-group').next('.add_type').remove();
			    $('#type_id').closest('.form-group').after(data)
			 });
		})<{if $_data.id == ''}>.trigger('change')<{/if}>;;
	});
})(jQuery);
</script>