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
		<span class="help-block">获取地址：https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN</span>
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

<fieldset>
	<legend>支付參數</legend>
	<div class="form-group">
		<label class="col-md-3 control-label" for="mchid">商戶ID</label>
		<div class="col-md-9">
			<input type="text" id="mchid" name="mchid" class="form-control" placeholder="请输入商戶ID" value="<{$_data.mchid}>">
			<span class="help-block">(*) 如果不加密消息，可不用填写</span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="mchkey">商户支付密钥</label>
		<div class="col-md-9">
			<input type="text" id="mchkey" name="mchkey" class="form-control" placeholder="请输入商戶支付密钥" value="<{$_data.mchkey}>">
			<span class="help-block">设置地址：https://pay.weixin.qq.com/index.php/account/api_cert</span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="sub_mch_id">子商户号</label>
		<div class="col-md-9">
			<input type="text" id="sub_mch_id" name="sub_mch_id" class="form-control" placeholder="请输入商戶ID" value="<{$_data.sub_mch_id}>">
			<span class="help-block">(*) 受理机构必须提供子商户号</span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="sub_mch_id">证书</label>
		<div class="col-md-9">
			<p class="form-control-static">请将证书放置<code><{app_path('certs')}>/<i><{$_data.appid|default:'APPID'}></i>/</code>下，（对应公众号的APPID）</p>
			<span class="help-block">(*) 证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert(下载之前需要安装商户操作证书)</span>
		</div>
	</div>

</fieldset>

<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重设</button>
	</div>
</div>