<script type="text/ng-template" id="wechat/depot/selector">
<div class="depot-list row">
	<div class="col-md-4 col-xs-4" ng-include="'wechat/depot/'+depot.type" ng-repeat="depot in depotConfirmed"></div>
	<div class="col-md-4 col-xs-4" ng-click="toSelect()" style="cursor:pointer;">
		<div class="row depot-col depot-col-image">
			<div class="items">
				<div class="image">
					<img src="<{'placeholder'|url}>?size=300x200&text=%20%20%20%20%20%2B%0D%0A%E9%80%89%E5%8F%96%E7%B4%A0%E6%9D%90" alt="" class="img-responsive" >
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/selector-modal">
<div class="modal-header">
	<h3 class="modal-title">选择素材</h3>
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