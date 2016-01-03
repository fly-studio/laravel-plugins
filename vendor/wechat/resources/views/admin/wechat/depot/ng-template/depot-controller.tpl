<script type="text/ng-template" id="wechat/depot/tabset">
<div>
	<div class="block-title">
		<div class="block-options pull-right">
			<div class="btn-group">
				<a class="btn  btn-sm btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><i class="fa fa-plus"></i> 新建素材</a>
				<ul class="dropdown-menu dropdown-custom dropdown-menu-right">
					<li><a href="javascript:void(0)" ng-click="$parent.create('news');"><i class="fa fa-newspaper-o pull-right"></i> 图文</a></li>
					<li class="divider"></li>
					<li>
						<a href="javascript:void(0)" ng-click="$parent.create('text');"><i class="fa fa-font pull-right"></i> 文字</a>
						<a href="javascript:void(0)" ng-click="$parent.create('image');"><i class="fa fa-image pull-right"></i> 图片</a>
						<a href="javascript:void(0)" ng-click="$parent.create('video');"><i class="fa fa-video-camera pull-right"></i> 视频</a>
						<a href="javascript:void(0)" ng-click="$parent.create('voice');"><i class="fa fa-volume-up pull-right"></i> 语音</a>
						<a href="javascript:void(0)" ng-click="$parent.create('music');"><i class="fa fa-music pull-right"></i> 音乐</a>
					</li>
					<li class="divider"></li>
					<li><a href="javascript:void(0)" ng-click="$parent.create('callback');"><i class="fa fa-code pull-right"></i> 编程</a></li>
				</ul>
			</div>
		</div>
		<ul class="nav nav-{{type || 'tabs'}}" ng-class="{'nav-stacked': vertical, 'nav-justified': justified}" ng-transclude></ul>
	</div>
	<div class="tab-content">
		<div class="tab-pane" 
		ng-repeat="tab in tabs" 
		ng-class="{active: tab.active}"
		uib-tab-content-transclude="tab"></div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/controller">
<div class="row">
	<div class="col-xs-12">
		<div class="block">
			<uib-tabset type="tabs" template-url="wechat/depot/tabset">
				<uib-tab ng-repeat="(key,v) in types" heading="{{v.title}}" active="v.active" select="show(key)">
					<div depot-list=""></div>
				</uib-tab>
			</uib-tabset>
	</div>
</div>
</script>