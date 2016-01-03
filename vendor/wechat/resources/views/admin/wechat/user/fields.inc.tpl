<div class="form-group">
	<label class="col-md-3 control-label" for="openid">OPEN ID</label>
	<div class="col-md-9">
		<input type="text" id="openid" name="openid" class="form-control" placeholder="请输入..." value="<{$_data.openid}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="unionid">Union ID</label>
	<div class="col-md-9">
		<input type="text" id="unionid" name="unionid" class="form-control" placeholder="请输入..." value="<{$_data.unionid}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="nickname">昵称</label>
	<div class="col-md-9">
		<input type="text" id="nickname" name="nickname" class="form-control" placeholder="请输入..." value="<{$_data.nickname}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="remark">备注</label>
	<div class="col-md-9">
		<input type="text" id="remark" name="remark" class="form-control" placeholder="请输入" value="<{$_data.remark}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label">性别</label>
	<div class="col-md-9">
		<{foreach $_fields.gender as $v}>
		<label class="radio-inline">
			<input type="radio" name="gender" value="<{$v.id}>" <{if $_data.gender == $v.id}>checked="checked"<{/if}> > <{$v.title}>
		</label>
		<{/foreach}>
		<div class="clearfix"></div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="avatar_aid">头像</label>
	<div class="col-md-9">
		<input type="hidden" id="avatar_aid" name="avatar_aid" class="form-control" value="<{$_data.avatar_aid}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="country">国家</label>
	<div class="col-md-9">
		<input type="text" id="country" name="country" class="form-control" placeholder="请输入..." value="<{$_data.country}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="province">省份</label>
	<div class="col-md-9">
		<input type="text" id="province" name="province" class="form-control" placeholder="请输入..." value="<{$_data.province}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="city">城市</label>
	<div class="col-md-9">
		<input type="text" id="city" name="city" class="form-control" placeholder="请输入..." value="<{$_data.city}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label">关注</label>
	<div class="col-md-9">
		<label class="radio-inline">
			<input type="radio" name="is_subscribed" value="1" <{if !empty($_data.is_subscribed)}>checked="checked"<{/if}> > 已关注
		</label>
		<label class="radio-inline">
			<input type="radio" name="is_subscribed" value="0" <{if empty($_data.is_subscribed)}>checked="checked"<{/if}> > 未关注
		</label>
		<div class="clearfix"></div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="subscribed_at">关注时间</label>
	<div class="col-md-9">
		<input type="text" id="subscribed_at" name="subscribed_at" class="form-control" placeholder="请输入..." value="<{$_data.subscribed_at}>">
	</div>
</div>

<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重设</button>
	</div>
</div>

<script>
(function($){
	$().ready(function(){
		$('#subscribed_at').on('focus',function(){
			WdatePicker({
				skin: 'twoer',
				isShowClear:true,
				readOnly:true,
				dateFmt:'yyyy-MM-dd HH:mm:ss',
				isShowOthers:false
			});
		});
	});
})(jQuery);
</script>