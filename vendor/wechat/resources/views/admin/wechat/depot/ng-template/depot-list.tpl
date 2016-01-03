<script type="text/ng-template" id="wechat/depot/news">
<div class="row depot-col depot-col-news" ng-if="depot.news" ng-class="{'multi': depot.news && depot.news.length > 1}">
	<div class="items">
		<div class="item" ng-repeat="item in depot.news">
			<h4 class="title">
				<a href="<{'wechat/news'|url}>?id={{item.id}}" target="_blank">{{item.title}}</a>
			</h4>
			<div class="cover">
				<img ng-src="<{'attachment'|url}>?id={{item.cover_aid}}" alt="" class="img-responsive">
			</div>
			<p class="description">
				{{item.description}}
			</p>
			<div class="clearfix"></div>
		</div>
		<div depot-list-options="mode" depot-id="depot.id"></div>
	</div>
	<div class="clearfix"></div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/text">
<div class="row depot-col depot-col-text" ng-if="depot.text">
	<div class="items">
		<div class="item">
			<p class="content" ng-bind-html="depot.text.content|nl2br"></p>
			<div class="clearfix"></div>
		</div>
		<div depot-list-options="mode" depot-id="depot.id"></div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/image">
<div class="row depot-col depot-col-image" ng-if="depot.image">
	<div class="items">
		<div class="image">
			<a href="<{'attachment'|url}>?id={{depot.image.aid}}" target="_blank"><img ng-src="<{'attachment'|url}>?id={{depot.image.aid}}" alt="" class="img-responsive"></a>
		</div>
		<h4 class="title">
			<a href="<{'attachment'|url}>?id={{depot.image.aid}}" target="_blank">{{depot.image.title}}</a>
			<span class="size pull-right">{{depot.image.size|byte2size}}</span>
		</h4>
		<div class="clearfix"></div>
		<div depot-list-options="mode" depot-id="depot.id"></div>
	</div>
</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/callback">
<div class="row depot-col depot-col-callback" ng-if="depot.callback">
	<div class="items">
		<h4 class="title">
			{{depot.callback.title}}
		</h4>
		<div class="content">
			<span ng-bind-html="depot.callback.callback|nl2br"></span>
		</div>
		<div depot-list-options="mode" depot-id="depot.id"></div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/video">
<div class="row depot-col depot-col-video" ng-if="depot.video">
	<div class="items">
		<div class="video">
			<video ng-src="{{'<{'attachment'|url}>?id='+depot.video.aid|trustUrl}}" controls="controls"></video>
		</div>
		<h4 class="title">
			<a href="<{'attachment'|url}>?id={{depot.video.aid}}" target="_blank">{{depot.video.title}}</a>
			<span class="size pull-right">{{depot.video.size|byte2size}}</span>
		</h4>
		<div depot-list-options="mode" depot-id="depot.id"></div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/voice">
<div class="row depot-col depot-col-voice" ng-if="depot.voice">
	<div class="items">
		<div class="voice">
			<audio ng-src="{{'<{'attachment'|url}>?id='+depot.voice.aid|trustUrl}}" controls="controls"></audio>
		</div>
		<h4 class="title">
			<a href="<{'attachment'|url}>?id={{depot.voice.aid}}" target="_blank">{{depot.voice.title}}</a>
			<span class="size pull-right">{{depot.voice.size|byte2size}}</span>
		</h4>
		<div depot-list-options="mode" depot-id="depot.id"></div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/music">
<div class="row depot-col depot-col-music" ng-if="depot.music">
	<div class="items">
		<div class="music">
			<audio ng-src="{{'<{'attachment'|url}>?id='+depot.music.aid|trustUrl}}" controls="controls"></audio>
		</div>
		<h4 class="title">
			<a href="<{'attachment'|url}>?id={{depot.music.aid}}" target="_blank">{{depot.music.title}}</a>
			<span class="size pull-right">{{depot.music.size|byte2size}}</span>
		</h4>
		<div depot-list-options=""></div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list">
<div>
	<div class="depot-list row">
		<div class="col-md-4 col-xs-4" ng-include="'wechat/depot/'+depot.type" ng-repeat="depot in dataList[type].data" ng-class="{selected: depotSelected[depot.id]}"></div>
	</div>
	<div class="depot-none" ng-if="dataList[type].total == 0">还没有素材，点击右上角添加一个？</div>
	<div class="clearfix"></div>
	<!--页码-->
	<div class="text-center" ng-show="dataList[type].total > 0">
		<uib-pagination boundary-links="true" total-items="dataList[type].total" items-per-page="dataList[type].per_page" ng-model="dataList[type].current_page" class="pagination-sm" previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></uib-pagination>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list/options/edit">
<div class="row">
	<div class="col-md-6 col-xs-6 text-center tool">
		<a href="javascript:void(0);" ng-click="edit(depot.type, depot.id)" class=""><i class="glyphicon glyphicon-edit"></i> 编辑</a>
	</div>
	<div class="col-md-6 col-xs-6 text-center tool">
		<a href="<{'admin/wechat/depot'|url}>/{{depot.id}}" confirm="您确定删除本素材吗？" method="delete" query done="destroy(depot.type, depot.id)"><i class="glyphicon glyphicon-trash text-danger"></i> 删除</a>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list/options/selector">
<div class="row">
	<div class="col-md-12 col-xs-12 text-center tool">
		<a href="" class="" ng-click="select(depot)" ng-if="!depotSelected[depot.id]"><i class="glyphicon glyphicon-plus"></i> 选定</a>
		<a href="" class="" ng-click="unselect(depot)" ng-if="depotSelected[depot.id]"><i class="glyphicon glyphicon-remove text-danger"></i> 取消选定</a>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list/options/preview">
<div class="row">
	<div class="col-md-12 col-xs-12 text-center tool">
		<a href="" class="" ng-click="unpreview(depot.id)"><i class="glyphicon glyphicon-remove text-danger"></i> 取消选定</a>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list/options">
<div class="options">
	<div ng-include src="'wechat/depot/list/options/'+mode"></div>
	<div class="clearfix"></div>
</div>
</script>