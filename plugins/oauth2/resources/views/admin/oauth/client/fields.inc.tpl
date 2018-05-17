<div class="form-group">
	<label class="col-md-3 control-label" for="name">名称</label>
	<div class="col-md-9">
		<input type="text" id="name" name="name" class="form-control" placeholder="请输入..." value="<{$_data.name}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="name">捆绑用户</label>
	<div class="col-md-9">
		<select name="user_id" id="user_id" class="form-control suggest-model" data-model="admin/member" data-text="{{nickname}}({{username}})" data-placeholder="请输入用户名" value="<{$_data.user_id|default:$_uid}>" data-term="username"></select>
		<span class="help-block">创建之后无法修改，请谨慎选择</span>

	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="redirect">来源网址</label>
	<div class="col-md-9">
		<input type="text" id="redirect" name="redirect" class="form-control" placeholder="请输入..." value="<{$_data.redirect}>">
		<span class="help-block">
			<ul>
				<li>例如：<code>api/oauth/authorize?redirect_uri=<b>http://www.yourapp.com/game/123/show</b></code></li>
				<li>则本字段可设置为：<code>http://www.yourapp.com/</code>、<code>http://www.yourapp.com/game/</code>均可</li>
				<li>系统会精确检查<b>redirect_uri</b>和本字段是否匹配，匹配算法是：<code>starts_with(redirect_uri, 本字段)</code>，即<b>redirect_uri</b>的前部分必须和本字段完全相同</li>
				<li>本字段必须以 <code>/</code> 结尾</li>
			</ul>
		</span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="lang">界面语言</label>
	<div class="col-md-9">
		<input type="text" id="lang" name="lang" class="form-control" placeholder="请输入..." value="<{$_data.lang}>">
		<span class="help-block">留空表示默认，填写则表示页面会优先使用配置的语言</span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="callback">支付回调</label>
	<div class="col-md-9">
		<input type="text" id="callback" name="callback" class="form-control" placeholder="请输入..." value="<{$_data.callback}>">
		<span class="help-block">该应用的支付回调，验签算法请查看对应的文档</span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label">个人OAuth客户端</label>
	<div class="col-md-9">
		<label class="radio-inline">
			<input type="radio" name="personal_access_client" value="1" <{if !empty($_data.personal_access_client)}>checked="checked"<{/if}> > 是
		</label>
		<label class="radio-inline">
			<input type="radio" name="personal_access_client" value="0" <{if empty($_data.personal_access_client)}>checked="checked"<{/if}> > 否
		</label>
		<div class="clearfix"></div>
		<span class="help-block"> 如果需要使用<code>api/oauth/authorize?response_type=code</code>的方式获取access_token，<b>请选择 否</b></span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label">密码OAuth客户端</label>
	<div class="col-md-9">
		<label class="radio-inline">
			<input type="radio" name="password_client" value="1" <{if !empty($_data.password_client)}>checked="checked"<{/if}> > 是
		</label>
		<label class="radio-inline">
			<input type="radio" name="password_client" value="0" <{if empty($_data.password_client)}>checked="checked"<{/if}>> 否
		</label>
		<div class="clearfix"></div>
		<span class="help-block"> 如果需要使用<code>api/oauth/authorize?response_type=code</code>的方式获取access_token，<b>请选择 否</b></span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label">状态</label>
	<div class="col-md-9">
		<label class="radio-inline">
			<input type="radio" name="revoked" value="1" <{if !empty($_data.revoked)}>checked="checked"<{/if}> > 已作废
		</label>
		<label class="radio-inline">
			<input type="radio" name="revoked" value="0" <{if empty($_data.revoked)}>checked="checked"<{/if}> > 正常
		</label>
		<div class="clearfix"></div>
	</div>
</div>

<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
	</div>
</div>
