<div class="form-group">
	<label class="col-md-3 control-label" for="name">名称</label>
	<div class="col-md-9">
		<input type="text" id="name" name="name" class="form-control" placeholder="请输入..." value="<{$_data.name}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label">类型</label>
	<div class="col-md-9">
		<select class="select-select2 form-control" name="socialite_type" id="socialite_type">
			<option value="">请选择</option>
		<{foreach catalog_search('fields.socialite.type', 'children') as $v}>
			<option type="radio" value="<{$v.id}>" <{if !empty($_data.socialite_type) && $_data.socialite_type.id == $v.id}>selected="selected"<{/if}> > <span class="icon-sn-<{$v.name}>"></span><{$v.title}> (<{$v.name}>)</option>
		<{/foreach}>
		</select>

		<span class="help-block">
			<ul>
				<li>QQ 申请地址：<a target="_blank" href="https://connect.qq.com/">https://connect.qq.com/</a></li>
				<li>微信Web（weixin-web），网页上二维码方式登录 申请地址：<a target="_blank" href="https://open.weixin.qq.com">https://open.weixin.qq.com</a></li>
				<li>微信APP的浏览器中登录（weixin） 申请地址：<a target="_blank" href="https://mp.weixin.qq.com">https://mp.weixin.qq.com</a>，也就是公众号的OAuth2登录</li>
				<li>当系统检测网页运行在微信APP浏览器时，只会启用weixin，反之，启用weixin-web</li>
			</ul>
		</span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="name">默认用户组</label>
	<div class="col-md-9">
		<select name="default_role_id" id="default_role_id" class="form-control tree-model" data-model="admin/role" data-text="{{display_name}}({{name}})" data-placeholder="请选择用户组" value="<{$_data.default_role_id}>"></select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="client_id">Client ID</label>
	<div class="col-md-9">
		<input type="text" id="client_id" name="client_id" class="form-control" placeholder="请输入..." value="<{$_data.client_id}>">
		<span class="help-block"></span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="client_secret">Client Secret</label>
	<div class="col-md-9">
		<input type="text" id="client_secret" name="client_secret" class="form-control" placeholder="请输入..." value="<{$_data.client_secret}>">
		<span class="help-block"></span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="client_secret">Client 其它参数</label>
	<div class="col-md-9" id="json-editor">
		<div class="col-md-12">
			<div class="col-md-8">
				<div class="row" style="width: 100%">
					<v-json-editor
					:data="myData"
					:editable="editable"
					@change="$forceUpdate()" ></v-json-editor>
				</div>
				<span class="help-block">
					<ul>
						<li>value 输入 []，则识别为数组</li>
						<li>value 输入 {}，则识别为Object</li>
						<li>左边 <span class="text-danger">红色</span> 按钮表示删除</li>
						<li>右边 <span class="text-success">绿色</span> 按钮表示插入</li>
					</ul>
				</span>
			</div>
			<div class="col-md-4">
				<textarea id="client_extra" name="client_extra" class="form-control" rows="20" v-model="JSON.stringify(myData, null, 4)" @blur="myData=JSON.parse($event.target.value)" readonly="readonly"></textarea>
			</div>
		</div>
	</div>
</div>
<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
	</div>
</div>
