<div class="form-group">
	<label class="col-md-3 control-label" for="keywords">关键字</label>
	<div class="col-md-9">
		<input type="text" id="keywords" name="keywords" class="form-control" placeholder="请输入关键字" value="<{$_data.keywords}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label">类型</label>
	<div class="col-md-9">
		<label class="radio-inline">
			<input type="radio" name="match_type" value="subscribe" <{if $_data.match_type == 'subscribe'}>checked="checked"<{/if}> > 关注时回复
		</label>
		<label class="radio-inline">
			<input type="radio" name="match_type" value="part" <{if $_data.match_type == 'part'}>checked="checked"<{/if}> > 模糊匹配
		</label>
		<label class="radio-inline">
			<input type="radio" name="match_type" value="whole" <{if $_data.match_type == 'whole'}>checked="checked"<{/if}> > 全字匹配
		</label>
		<div class="clearfix"></div>
		<span class="help-block">
			<ul>
				<li><b>关注时回复：</b>用户在关注时，推送一条消息；</li>
				<li><b>模糊匹配：</b>比如关键词为「天安门」，用户输入：「我爱北京天安门」，则匹配成功；</li>
				<li><b>全字匹配：</b>关键词和用户输入的完全相同时，则匹配成功；</li>
				<li>全字匹配 优先于 模糊匹配。</li>
			</ul>
		</span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="wdid">素材库</label>
	<div class="col-md-9">
		<select name="wdid[]" id="wdid" class="form-control hidden" multiple="multiple">
			<{foreach $_data.depots as $depot}><option value="<{$depot->getKey()}>" selected="selected"><{$depot->getKey()}></option><{/foreach}>
		</select>
		<div class="" id="depot" depot-selector="#wdid" selected-limit="10">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label"></label>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="reply_count">一次回复数量</label>
	<div class="col-md-9">
		<input type="text" id="reply_count" name="reply_count" class="form-control" placeholder="请输入数量" value="<{$_data.reply_count|default:0}>">
		<span class="help-block">比如选择了3个素材，可以设置为只随机回复1条。0 表示全部回复</span>
	</div>
</div>

<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重设</button>
	</div>
</div>