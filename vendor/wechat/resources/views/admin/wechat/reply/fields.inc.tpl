<div class="form-group">
	<label class="col-md-3 control-label" for="name">名称</label>
	<div class="col-md-9">
		<input type="text" id="name" name="name" class="form-control" placeholder="请输入名称" value="<{$_data.name}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="description">简介</label>
	<div class="col-md-9">
		<textarea id="description" name="description" rows="9" class="form-control" placeholder="简介.."></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label">类型</label>
	<div class="col-md-9">
		<{foreach $_fields.wechat_type as $v}>
		<label class="radio-inline">
			<input type="radio" name="wechat_type" value="<{$v.id}>" <{if $_data.wechat_type == $v.id}>checked="checked"<{/if}> > <{$v.title}>
		</label>
		<{/foreach}>
		<div class="clearfix"></div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="account">原始ID</label>
	<div class="col-md-9">
		<input type="text" id="account" name="account" class="form-control" placeholder="请输入" value="<{$_data.account}>">
		<span class="help-block">此账号由微信自动生成（公众号设置 - 原始ID），类似：gh_xxxxxxxxxxxxx</span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="appid">APP ID</label>
	<div class="col-md-9">
		<input type="text" id="appid" name="appid" class="form-control" placeholder="请输入APP ID" value="<{$_data.appid}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="appsecret">APP Secrect</label>
	<div class="col-md-9">
		<input type="text" id="appsecret" name="appsecret" class="form-control" placeholder="请输入APP Secrect" value="<{$_data.appsecret}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="token">Token</label>
	<div class="col-md-9">
		<input type="text" id="token" name="token" class="form-control" placeholder="请输入Token" value="<{$_data.token}>">
		<span class="help-block">(*) 为开发者模式设定的token</span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="encodingaeskey">Encodingaes KEY</label>
	<div class="col-md-9">
		<input type="text" id="encodingaeskey" name="encodingaeskey" class="form-control" placeholder="请输入Encodingaes KEY" value="<{$_data.encodingaeskey}>">
		<span class="help-block">(*) 如果不加密消息，可不用填写</span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="qr_aid">二维码</label>
	<div class="col-md-9">
		<input type="hidden" id="qr_aid" name="qr_aid" class="form-control" value="<{$_data.qr_aid}>">
	</div>
</div>

<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重设</button>
	</div>
</div>