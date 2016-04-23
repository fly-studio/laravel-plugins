<script type="text/ng-template" id="wechat/depot/selector">
<div class="depot-list row">
	<div class="col-md-12 col-xs-12"  style="cursor:pointer;padding: 10px;">
		<a href="javascript:;" ng-click="toSelect()" class="btn btn-default"> <i class="fa fa-search"></i> 选择素材 (<={{selectedLimit}}条)</a>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-6 col-xs-6" ng-include="'wechat/depot/'+depot.type" ng-repeat="depot in depotConfirmed"></div>
	<div class="clearfix"></div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/selector-modal">
<div class="modal-header">
	<h3 class="modal-title">选择素材 (<={{selectedLimit}}条)</h3>
</div>
<div class="modal-body~">
	<div depot-controller="news" mode="selector" selected-limit="{{selectedLimit}}"></div>
</div>
<div class="modal-footer">
	<span class="pull-left" ng-if="selectLength > 1">（*）可以选择多个不同类型的素材，翻页也会保留已选中的素材</span>
	<span ng-if="selectLength > 1">已选择：{{depotSelected | count}}/{{selectLength}} </span>
	<button class="btn btn-primary" type="button" ng-click="$close()" ng-disabled="(depotSelected|count) <= 0"><i ></i>选择素材</button>
	<button class="btn btn-warning" type="button" ng-click="$dismiss()">取消</button>
</div>
</script>