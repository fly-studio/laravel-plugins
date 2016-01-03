<script type="text/ng-template" id="wechat/depot/edit/news/controller">
<div class="depot-list row">
	<div class="col-md-12 col-xs-12 depot-col depot-col-news" ng-if="depot.news" ng-class="{'multi': depot.news && depot.news.length > 1}">
		<div class="items">
			<div class="item" ng-repeat="item in depot.news" ng-click="editNews($index)" ng-class="{active: item.active}">
				<h4 class="title">
					{{item.title || '请输入标题'}}
				</h4>
				<div class="cover">
					<img ng-src="<{'attachment'|url}>?id={{item.cover_aid}}" src="<{'placeholder'|url}>?size=250x160&text=请上传封面" alt="" class="img-responsive">
				</div>
				<p class="description">
					{{item.description || '请输入摘要'}}
				</p>
				
				<div class="clearfix"></div>
				<div class="row item-options" ng-if="depot.news.length > 1">
					<a href="#" ng-click="prevNews($index)" ng-show="!$first"><i class="glyphicon glyphicon-arrow-up"></i> 上移</a>
					<a href="#" ng-click="nextNews($index)" ng-show="!$last"><i class="glyphicon glyphicon-arrow-down"></i> 下移</a>
					<a href="#" ng-click="destroyNews($index)" ng-show="depot.news.length > 1" class="text-danger"><span class="text-danger"><i class="glyphicon glyphicon-remove"></i> 删除</a></a>
				</div>
			</div>
			<div class="options">
				<div class="row">
					<div class="col-md-12 col-xs-12 text-center tool">
						<a href="#"  ng-click="createNews()" ng-disabled="depot.news.length>=7"><i class="glyphicon glyphicon-plus"></i> 新建一條</a>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
</script>
<script type="text/ng-template" id="wechat/depot/edit/news/form">
<div class="depot-edit-form depot-edit-form-{{$index}}" ng-repeat="item in depot.news" ng-class="{active: item.active}">
	<div class="arrow-left"></div>
	<div class="inner">
		<div class="panel panel-default">
			<div class="panel-body">
			<form action="{{'<{'admin/wechat/depot-news'|url}>' + (item.id ? '/' + item.id : '')| trustUrl}}" method="POST" name="forms.news[{{$index}}]" bs-modifiable="true" class="form-horizontal form-bordered">
				<{csrf_field() nofilter}>
				<input type="hidden" value="{{item.id > 0 ? 'PUT' : 'POST'}}" name="_method" />
				<div class="tips" ng-show="forms.news[$index].modified">
					<div class=" alert alert-danger">
						数据已修改，请记得保存。
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">标题</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="title" placeholder="请输入标题" ng-model="item.title">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">作者</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="author" placeholder="请输入作者" ng-model="item.author">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">封面</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" uploader="1" class="form-control hidden" name="cover_aid" ng-model="item.cover_aid">
						<span class="help-block">（大图片建议尺寸：360像素 * 200像素）</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
					<div class="col-sm-9 col-xs-12">
						<label class="checkbox-inline">
							<input type="checkbox" name="cover_in_content" value="1" ng-model="item.cover_in_content" ng-checked="item.cover_in_content" ng-init="!!item.redirect" class="" checked="checked"> 封面图片显示在正文中
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">描述</label>
					<div class="col-sm-9 col-xs-12">
						<textarea class="form-control " name="description" placeholder="请输入简短描述" ng-model="item.description"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-4 col-md-offset-3 col-lg-offset-2 col-xs-12 col-sm-8 col-md-9 col-lg-10">
						<label class="checkbox-inline">
							<input type="checkbox" name="redirect" value="1" ng-model="item.redirect" ng-checked="item.redirect" ng-init="item.redirect" class=""> 是否直接跳转
						</label>
						<span class="help-block">如果直接跳转，则无需编辑內容。点击这条图文将直接链接至下方的原文网址中.</span>
					</div>
				</div>
				<div class="form-group" ng-show="!item.redirect">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">內容</label>
					<div class="col-sm-9 col-xs-12">
						<div style="margin-bottom:1.25rem" class="ueditor" ng-model="item.content" config="ueditor_config"></div>
						<textarea ng-model="item.content" class="hidden" name="content"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">原文网址</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="url" class="form-control" placeholder="来源网址" ng-model="item.url">
						<span class="help-block"></span>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<form name="forms.depot" action="{{'<{'admin/wechat/depot'|url}>' + (depot.id ? '/' + depot.id : '') | trustUrl}}" method="POST" class="hidden">
<{csrf_field() nofilter}>
<input type="hidden" value="{{depot.id > 0 ? 'PUT' : 'POST'}}" name="_method" />
<input type="text" ng-model="depot.type" name="type" />
<div ng-repeat="item in depot.news"><input type="text" name="wdnid[]" ng-model="item.id"  /></div>
</form>
</script>

<script type="text/ng-template" id="wechat/depot/edit/news">
<div class="row">
	<div class="col-xs-4">
		<div ng-include src="'wechat/depot/edit/news/controller'"></div>
	</div>
	<div class="col-xs-8">
		<div ng-include src="'wechat/depot/edit/news/form'"></div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/edit/text">
<div class="row">
	<div class="col-xs-12">
		<form name="forms.depot" action="{{'<{'admin/wechat/depot'|url}>' + (depot.id ? '/' + depot.id : '') | trustUrl}}" class="form-horizontal form-bordered" method="POST">
		<{csrf_field() nofilter}>
		<input type="hidden" value="{{depot.id > 0 ? 'PUT' : 'POST'}}" name="_method" />
		<input type="text" ng-model="depot.type" name="type" class="hidden" />
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">文本</label>
			<div class="col-sm-9 col-xs-12">
				<textarea class="form-control" rows="20" name="content" placeholder="请输入文本" ng-model="depot.text.content"></textarea>
				<span class="help-block">微信回复的文本，支持&lt;a href="http://..../"&gt;超链接文本&lt;/a&gt;</span>
			</div>
		</div>
		</form>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/edit/callback">
<div class="row">
	<div class="col-xs-12">
		<form name="forms.depot" action="{{'<{'admin/wechat/depot'|url}>' + (depot.id ? '/' + depot.id : '') | trustUrl}}" class="form-horizontal form-bordered" method="POST">
		<{csrf_field() nofilter}>
		<input type="hidden" value="{{depot.id > 0 ? 'PUT' : 'POST'}}" name="_method" />
		<input type="text" ng-model="depot.type" name="type" class="hidden" />
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">标题</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control" name="title" placeholder="请输入标题" ng-model="depot.callback.title">
				<span class="help-block">描述下这段程序是做什么的</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">程序段</label>
			<div class="col-sm-9 col-xs-12">
				<textarea class="form-control" rows="20" name="callback" placeholder="请输入文本" ng-model="depot.callback.callback"></textarea>
				<div class="help-block"><code >
				function($) {

				}
				</code></div>
			</div>
		</div>
		</form>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/edit/image">
<div class="row">
	<div class="col-xs-12">
		<form name="forms.depot" action="{{'<{'admin/wechat/depot'|url}>' + (depot.id ? '/' + depot.id : '') | trustUrl}}" class="form-horizontal form-bordered" method="POST">
		<{csrf_field() nofilter}>
		<input type="hidden" value="{{depot.id > 0 ? 'PUT' : 'POST'}}" name="_method" />
		<input type="text" ng-model="depot.type" name="type" class="hidden" />
		
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">图片</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control hidden" uploader="1" name="aid" ng-model="depot.image.aid">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">文件标题</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control" name="title" placeholder="请输入标题" ng-model="depot.image.title">
			</div>
		</div>
		<input type="text" class="form-control hidden" name="size" ng-model="depot.image.size">
		</form>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/edit/video">
<div class="row">
	<div class="col-xs-12">
		<form name="forms.depot" action="{{'<{'admin/wechat/depot'|url}>' + (depot.id ? '/' + depot.id : '') | trustUrl}}" class="form-horizontal form-bordered" method="POST">
		<{csrf_field() nofilter}>
		<input type="hidden" value="{{depot.id > 0 ? 'PUT' : 'POST'}}" name="_method" />
		<input type="text" ng-model="depot.type" name="type" class="hidden" />
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">视频标题</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control" name="title" placeholder="请输入标题" ng-model="depot.video.title">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">视频</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control hidden" uploader="1" filetype="mp4" filesize="52428800" name="aid" ng-model="depot.video.aid">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">视频描述</label>
			<div class="col-sm-9 col-xs-12">
				<textarea class="form-control " name="description" placeholder="请输入简短的描述" ng-model="depot.video.description"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">视频截图</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control hidden" uploader="1" name="thumb_aid" ng-model="depot.video.thumb_aid">
				<span class="help-block">可以使用播放器截取一张图片后上传，也可以不填写</span>
			</div>
		</div>
		<input type="text" class="form-control hidden" name="size" ng-model="depot.video.size">
		<input type="text" class="form-control hidden" name="format" ng-model="depot.video.format">
		</form>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/edit/voice">
<div class="row">
	<div class="col-xs-12">
		<form name="forms.depot" action="{{'<{'admin/wechat/depot'|url}>' + (depot.id ? '/' + depot.id : '') | trustUrl}}" class="form-horizontal form-bordered" method="POST">
		<{csrf_field() nofilter}>
		<input type="hidden" value="{{depot.id > 0 ? 'PUT' : 'POST'}}" name="_method" />
		<input type="text" ng-model="depot.type" name="type" class="hidden" />
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">录音标题</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control" name="title" placeholder="请输入标题" ng-model="depot.voice.title">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">录音</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control hidden" uploader="1" filetype="mp3,amr" filesize="5242880" name="aid" ng-model="depot.voice.aid">
			</div>
		</div>
		<input type="text" class="form-control hidden" name="size" ng-model="depot.voice.size">
		<input type="text" class="form-control hidden" name="format" ng-model="depot.voice.format">
		</form>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/edit/music">
<div class="row">
	<div class="col-xs-12">
		<form name="forms.depot" action="{{'<{'admin/wechat/depot'|url}>' + (depot.id ? '/' + depot.id : '') | trustUrl}}" class="form-horizontal form-bordered" method="POST">
		<{csrf_field() nofilter}>
		<input type="hidden" value="{{depot.id > 0 ? 'PUT' : 'POST'}}" name="_method" />
		<input type="text" ng-model="depot.type" name="type" class="hidden" />
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">音乐标题</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control" name="title" placeholder="请输入标题" ng-model="depot.music.title">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">音乐</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control hidden" uploader="1" filetype="mp3" filesize="5242880" name="aid" ng-model="depot.music.aid">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">描述</label>
			<div class="col-sm-9 col-xs-12">
				<textarea class="form-control " name="description" placeholder="请输入简短描述" ng-model="depot.music.description"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">音乐封面</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control hidden" uploader="1" name="thumb_aid" ng-model="depot.music.thumb_aid">
				<span class="help-block">音乐专辑封面，没有可以不上传</span>
			</div>
		</div>
		<input type="text" class="form-control hidden" name="size" ng-model="depot.music.size">
		<input type="text" class="form-control hidden" name="format" ng-model="depot.music.format">
		</form>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/edit">
<div class="modal-header">
	<h3 class="modal-title">新建/修改素材</h3>
</div>
<div class="modal-body">
	<div ng-include src="'wechat/depot/edit/'+type"></div>
</div>
<div class="modal-footer">
	<button class="btn btn-primary" type="button" ng-click="save()" ng-disabled="submiting">保存</button>
	<button class="btn btn-warning" type="button" ng-click="cancel()">取消</button>
</div>
</script>