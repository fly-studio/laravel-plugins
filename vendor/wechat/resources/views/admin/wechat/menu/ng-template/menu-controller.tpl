<script type="text/ng-template" id="wechat/menu">
<div class="menu-container">
	<div class="col-sm-4 menu-left">
		<ng-include src="'wechat/menu/list'"></ng-include>
	</div>
	<div class="col-sm-8 menu-right">
		<ng-include src="'wechat/menu/content'"></ng-include>
	</div>
	<div class="clearfix"></div>
	<ng-include src="'wechat/menu/modified'"></ng-include>
</div>
</script>

<script type="text/ng-template" id="wechat/menu/list">
<div class="menu-items">

	<ng-include src="'wechat/menu/list/item'" ng-repeat="item in dataList"></ng-include>

	<div class="menu-plus text-center">
		<a href="" class="btn btn-default btn-block" ng-class="{disabled: dataList.length >= 3}" ng-disabled="dataList.length >= 3" ng-click="create(dataList, 0, 0)" title="添加菜单" data-toggle="tooltip"><i class="fa fa-plus"></i></a>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/menu/list/item">
<div class="menu-item" ng-click="select(item)" ng-class="{active: menuSelected == item}">
	<span ng-class="{'text-danger': forms.menu[item.index].modified}">{{item.title || '(未命名)'}}</span>
	<div class="pull-right menu-tools">
		<a href="" ng-click="destroy(item, dataList);$event.stopPropagation();" data-toggle="tooltip" title="删除" class="btn btn-link text-danger"><i class="fa fa-remove"></i></a>
		<a href="" data-toggle="tooltip" title="添加子项" class="btn btn-link" ng-class="{disabled: item.children.length >= 5}" ng-disabled="item.children.length >= 5" ng-click="create(item.children, item.id, item.index);$event.stopPropagation();"><i class="fa fa-plus"></i></a>
	</div>
	<div class="clearfix"></div>
</div>
<ng-include src="'wechat/menu/list/subitem'" ng-repeat="subitem in item.children"></ng-include>
</script>

<script type="text/ng-template" id="wechat/menu/list/subitem">
<div class="menu-subitem" ng-click="select(subitem)" ng-class="{active: menuSelected == subitem}">
	<span ng-class="{'text-danger': forms.menu[subitem.index].modified}">{{subitem.title || '(未命名子项)'}}</span>
	<div class="pull-right menu-tools">
		<a href="" ng-click="destroy(subitem, item.children);$event.stopPropagation();" data-toggle="tooltip" title="删除" class="btn btn-link text-danger"><i class="fa fa-remove"></i></a>
	</div>
	<div class="clearfix"></div>
</div>
</script>

<script type="text/ng-template" id="wechat/menu/content">
	<div class="center-block" ng-show="!menuSelected">左边选择一个菜单</div>
	<div class="menu-forms">
		<ng-include src="'wechat/menu/form'" ng-repeat="item in dataList"></ng-include>
		<ng-include src="'wechat/menu/form'" ng-repeat="item in dataList[0].children"></ng-include>
		<ng-include src="'wechat/menu/form'" ng-repeat="item in dataList[1].children"></ng-include>
		<ng-include src="'wechat/menu/form'" ng-repeat="item in dataList[2].children"></ng-include>
	</div>
</script>

<script type="text/ng-template" id="wechat/menu/form">
<form action="{{'<{'admin/wechat/menu'|url}>' + (item.id > 0 ? '/' + item.id : '')| trustUrl}}" class="form-horizontal form-bordered" name="forms.menu[{{item.index}}]" bs-modifiable="true" ng-show="item == menuSelected">
	<{csrf_field() nofilter}>
	<input type="hidden" value="{{item.id > 0 ? 'PUT' : 'POST'}}" name="_method" />
	<input type="text" class="hidden" name="pid" ng-model="item.pid">
	<input type="text" class="hidden" name="order" ng-model="item.index">
	<div class="tips" ng-show="forms.menu[item.index].modified">
		<div class=" alert alert-danger">
			数据已修改，请记得保存。
		</div>
	</div>
	<div class="form-group">
		<label for="title" class="col-sm-3 control-label">菜单名称</label>
		<div class="col-sm-9">
			<input type="tex" id="title" name="title" class="form-control" ng-model="item.title" placeholder="请输入名称">
		</div>
	</div>
	<div class="form-group">
		<label for="type" class="col-sm-3 control-label">类型</label>
		<div class="col-sm-9">
			<select id="type" name="type" class="form-control" ng-model="item.type">
				<option value="">请选择</option>
				<option value="view">页面跳转</option>
				<option value="click">点击事件</option>
				<option value="event">其他事件</option>
				<option value="media_id" disabled="disabled">图片/视频等</option>
				<option value="view_limited" disabled="disabled">图文消息</option>
			</select>
		</div>
	</div>
	<div class="form-group" ng-show="item.type == 'event'">
		<label for="event" class="col-sm-3 control-label">事件</label>
		<div class="col-sm-9">
			<select id="event" name="event" class="form-control" ng-model="item.event">
				<option value="">请选择</option>
				<option value="pic_sysphoto">系统拍照发图</option>
				<option value="pic_photo_or_album">拍照或者相册发图</option>
				<option value="pic_weixin">微信相册发图</option>
				<option value="location_select">发送地理位置</option>
				<option value="scancode_waitmsg">扫码带提示</option>
				<option value="scancode_push">扫码推事件</option>
			</select>
		</div>
	</div>
	<div class="form-group" ng-show="item.type == 'click'">
		<label for="title" class="col-sm-3 control-label">素材库</label>
		<div class="col-sm-9">
			<input type="text" name="wdid" class="hidden" ng-model="item.wdid" >
			<div id="depot" depot-selector="" ng-model="item.wdid" selected-limit="1">
		</div>
	</div>
	<div class="form-group" ng-if="item.type == 'view'">
		<label for="url" class="col-sm-3 control-label">跳转网址</label>
		<div class="col-sm-9">
			<input type="text" id="url" name="url" class="form-control" ng-model="item.url" placeholder="http://">
		</div>
	</div>

</form>
</script>

<script type="text/ng-template" id="wechat/menu/modified">
<form action="<{'admin/wechat/menu/publish-query'|url}>" name="forms.publish" method="POST">
<div ng-repeat="id in deletedList" style="display: none;">
	<input type="text" name="id[]" value="{{id}}">
</div>
</form>
<div class="menu-publish">
	<div class="menu-publish-buttons text-center">
		<button class="btn btn-info" ng-click="save()" ng-disabled="submiting">保存发布菜单</button>
	</div>
</div>
</script>



