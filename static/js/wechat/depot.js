document.getElementsByTagName('html')[0].setAttribute('ng-app', 'app');
//depot controllers
var $app = angular.module('app', ['jquery', 'ui.bootstrap', 'untils', 'ngInputModified', 'ng.ueditor'])
.config(function(inputModifiedConfigProvider) {
	inputModifiedConfigProvider.disableGlobally(); //默认关闭ngInputModified
})
.config(function($provide) {
	$provide.decorator('$controller', function($delegate) {
		return function(constructor, locals, later, indent) {
			if (typeof constructor === 'string' && !locals.$scope.controllerName) {
				locals.$scope.controllerName =  constructor;
			}
			return $delegate(constructor, locals, later, indent);
		};
	});
})
.run(function($rootScope) {
	/*$rootScope.load = function(page, filters, orders) {};
	$rootScope.reload = function() {};*/
})
.controller('depotSelector',  function($rootScope, $scope, $query, $uibModal, $log, $element) {
	$scope.mode = 'preview';
	$scope.depotConfirmed = {};
	$scope.depotSelected = {};

	$scope.toSelect = function(){
		$scope.depotSelected = angular.copy($scope.depotConfirmed) || {};
		var modalInstance = $uibModal.open({
			animation: true,
			templateUrl: 'wechat/depot/selector-modal',
			controller: 'depotSelectorModal',
			size: 'lg',
			backdrop: 'static',
			scope: $scope
		});
		$element.closest('.modal').hide(); //隐藏上层modal
		modalInstance.result.then(function (){
			if (count($scope.depotSelected) >= 1)
				$scope.depotConfirmed = angular.copy($scope.depotSelected);
			
			$element.closest('.modal').show();
		}, function () {
			$element.closest('.modal').show();
		});
	}
	$scope.unpreview = function(depotId){
		if (typeof depotId == 'undefined') for(var i in $scope.depotConfirmed) delete $scope.depotConfirmed[i]; else delete $scope.depotConfirmed[depotId];
		
	}

	$scope.$watch('depotConfirmed', function(newValue, oldValue){
		if (newValue === oldValue) { return; }
		var keys = array_keys($scope.depotConfirmed);
		jQuery($scope.host).val(keys ? keys : '');
	}, true);

})
.controller('depotSelectorModal',  function($scope, $query, $uibModalInstance) {
	
})
.directive('depotSelector',function() {
	return {
		restrict: 'A',
		controller: 'depotSelector',
		replace: true,
		scope: {
			host: '@depotSelector',
			selectedLimit: '@selectedLimit',
		},
		templateUrl: function(element, attrs) {
			return attrs.templateUrl || 'wechat/depot/selector';
		}
	}
})
.controller('depotController',  function($rootScope, $scope, $query, $uibModal, $log, $element) {
	$scope.dataList = {};
	$scope.types = {'news': {title:'图文'},'text': {title:'文本'},'image': {title:'图片'},'callback': {title:'编程'},'video': {title:'视频'},'voice': {title:'录音'},'music': {title:'音乐'}};
	$scope.types[$scope.type].active = true; //根据attr参数

	$scope.depotSelected = $scope.$parent.depotSelected || {};
	$scope.load = function(type, page, filters, orders)
	{
		if (!filters) filters = {};
		filters['type'] = type;
		$scope['type'] = type;
		$query.post(jQuery.baseuri + 'admin/wechat/depot/data/json',{'page': page, 'filters': filters, 'orders': orders}, function(json){
			if (json.result == 'success')
				$scope.dataList[type] = json.data;
			else
				jQuery.showtips(json);
		}, false);
	};
	$scope.reload = function(type){
		$scope.load(type, $scope.dataList[type].current_page, $scope.dataList[type]['filters'], $scope.dataList[type]['orders']);
	};
	$scope.select = function(depot){
		if ($scope.selectedLimit <= 1) $scope.unselect();
		else if (count($scope.depotSelected) >= $scope.selectedLimit){
			jQuery.alert('最多只能选择' + $scope.selectedLimit + '项，(请查看其它分类是否被选中)', true);
			return false;
		}
		$scope.depotSelected[depot.id] = depot;
	};
	$scope.unselect = function(depot){
		if (typeof depot == 'undefined') for(var i in $scope.depotSelected) delete $scope.depotSelected[i]; else delete $scope.depotSelected[depot.id];
	}
	$scope.show = function(type, reload){
		$scope.type = type;
		if (!$scope[type] || reload)
			$scope.load(type, 1);
		$scope.types[type].active = true;
	};
	$scope.create = function(type){
		$scope.edit(type);
	}
	$scope.edit = function(type, depotId){
		$newScope = $rootScope.$new(true, $scope);
		$newScope.type = type;
		$newScope.depotId = depotId;
		var modalInstance = $uibModal.open({
			animation: true,
			templateUrl: 'wechat/depot/edit',
			controller: 'depotEditController',
			size: 'lg',
			backdrop: 'static',
			scope: $newScope,
			resolve: {
				
			}
		});
		modalInstance.result.then(function (){
			
		}, function () {
			//$log.info('Modal dismissed at: ' + new Date());
		});
	};
	$scope.destroy = function(type, depotId)
	{
		$scope.reload(type);
	}

	//monitor page change
	angular.forEach($scope.types, function(text, type){
		$scope.$watch('dataList.'+type+'.current_page', function(newValue, oldValue) {
			if (newValue === oldValue) { return; }
			if (!isNaN(oldValue)) //不是无值
				$scope.reload(type);
		});
	});

}).directive('depotController',function() {
	return {
		restrict: 'A',
		scope: {
			mode: '@mode',
			type: '@depotController',
			selectedLimit: '@'
		},
		controller: 'depotController',
		replace: true,
		templateUrl: function(element, attrs) {
			return attrs.templateUrl || 'wechat/depot/controller';
		},
		link: function(scope, element, attrs) {
			if (!scope.selectedLimit) scope.selectedLimit = 1;
		}
	}
})
.controller('depotListController',  function($scope){

}).directive('depotList',function() {
	return {
		restrict: 'A',
		scope: false,
		//transclude: true,
		require: ['^depotController'],
		controller: 'depotListController',
		replace: true,
		templateUrl: function(element, attrs) {
			return attrs.templateUrl || 'wechat/depot/list';
		},
		link: function(scope){

		}
	};
})
.directive('depotItem',function($compile, $templateRequest, $sce) {
	return {
		restrict: 'A',
		scope: false,
		transclude: true,
		require: ['^depotList'],
		replace: true,
		link: function(scope, element, attrs) {	
			/*var templateUrl = $sce.getTrustedResourceUrl('wechat/depot/' + scope.type);
			$templateRequest(templateUrl).then(function(template) {
				element.html(template);
				$compile(element.contents())(scope);
			}, function() {
				// An error has occurred
			});*/
		}
	}
})
.controller('depotListOptionsController',  function($scope){

}).directive('depotListOptions',function() {
	return {
		restrict: 'A',
		scope: false,
		//transclude: true,
		//require: ['^depotList'],
		controller: 'depotListOptionsController',
		replace: true,
		templateUrl: function(element, attrs) {
			return attrs.templateUrl || 'wechat/depot/list/options';
		},
		link: function(scope){

		}
	};
})
.controller('depotEditController', function($scope, $uibModalInstance, $query){
	// $uibModalInstance.close();
	// $uibModalInstance.dismiss('cancel');
	$scope.forms = {}; //form 变量
	$scope.submiting = false; //正在提交
	$scope.ueditor_config = jQuery.ueditor_default_setting.simple;
	$scope.init = function(){
		$scope.depot = {
			id: 0,
			type: $scope.type
		};
		$scope.depot[$scope.type] = null;
	}
	$scope.load = function(type, depotId){
		
		return $query.post(jQuery.baseuri + 'admin/wechat/depot/data/json',{'pagesize': 2,'filters[type]': $scope.type, 'filters[id]': $scope.depotId}, function(json){
			if (json.result == 'success')
				if (json.data && json.data.data && json.data.data[0]) $scope.depot = json.data.data[0];	else $scope.init();
			else
				jQuery.showtips(json);
		}, false);

	}
	
	$scope.createNews = function(){
		if (!$scope.depot.news || !($scope.depot.news instanceof Array))
			$scope.depot.news = [];
		if ($scope.depot.news.length >= 8)
		{
			jQuery.alert('最多只能创建8条图文！', true);
			return false;
		}
		$scope.depot.news.push({
			id: '',
			title: '',
			cover_id: '',
			cover_in_content: true,
			description: '',
			redirect: true,
			content: '',
			url: ''
		});
		$scope.editNews($scope.depot.news.length - 1);
	}

	$scope.editNews = function(index){
		angular.forEach($scope.depot.news, function(v){
			v.active = false;
		});
		$scope.depot.news[index].active = true;
	}

	$scope.saveNews = function()
	{
		if (!$scope.forms.news) 
			return false;

		var querys = [];
		angular.forEach($scope.forms.news, function(form, index){
			var $form = jQuery('[name="'+form.$name+'"]');

			querys.push($query.form($form, function(json){
				if (json.data) {
					$scope.depot.news[index].id = json.data.id; //如果是新建，则改变文章的id
					form.$setPristine();
					$scope.$apply();
				}
			}, false).fail(function(json){
				$scope.editNews(index);
				jQuery.showtips(json);
			}).done(function(json){
				
			}));
		});

		return jQuery.when.apply(this,querys);
	}

	$scope.destroyNews = function(index)
	{
		if ($scope.depot.news.length <= 1) return false;
		if ($scope.forms['news'][index].modified)
		{
			jQuery.confirm('您已修改本文章，是否确定删除？',function(){
				$scope.depot.news.splice(index, 1);
				$scope.editNews(index <= 0 ? 0 : index - 1);
				$scope.$apply();
			});
		} else {
			$scope.depot.news.splice(index, 1);
			$scope.editNews(index <= 0 ? 0 : index - 1);
		}
	}

	$scope.prevNews = function(index)
	{
		if (index <= 0) return false;
		//$scope.depot.news[index] = $scope.depot.news.splice(index-1, 1, $scope.depot.news[index])[0];
		var a = angular.copy($scope.depot.news[index]);var b = angular.copy($scope.depot.news[index - 1]);
		$scope.depot.news[index] = b; $scope.depot.news[index - 1] = a;
		$scope.editNews(index - 1);
	}

	$scope.nextNews = function(index)
	{
		if (index >= $scope.depot.news.length - 1) return false;
		//$scope.depot.news[index] = $scope.depot.news.splice(index+1, 1, $scope.depot.news[index])[0];
		var a = angular.copy($scope.depot.news[index]);var b = angular.copy($scope.depot.news[index + 1]);$scope.depot.news[index] = b; $scope.depot.news[index + 1] = a;
		$scope.editNews(index + 1);
	}

	$scope.cancel = function()
	{
		var modified = false;
		for(var i in $scope.form)
			if ( !!$scope.form[i].modified )
				modified = true;

		if (modified)
			jQuery.confirm('内容已修改，您确定不保存？', function(){
				$uibModalInstance.dismiss('cancel');
			});
		else
			$uibModalInstance.dismiss('cancel');
	}

	$scope.save = function()
	{
		$scope.submiting = true;
		var submit = function(){
			$query.form(jQuery('[name="forms.depot"]')).done(function(json){
				$scope.depot = json.data;
				$uibModalInstance.close();
				json.data.isCreated ? $scope.$parent.$parent.show(json.data.type) : $scope.$parent.$parent.reload(json.data.type);
			}).always(function(){
				$scope.submiting = false;
			});
		}
		if ($scope.type == 'news')
		{
			$scope.saveNews().done(submit).fail(function(){
				$scope.submiting = false;
			});
		} else {
			submit();
		}
	}
	//附件上传或者移除时
	$scope.$on('uploader.uploaded', function(e, scope, elem, file, json, ids){
		if ($scope.type != 'news' && elem.is('[name="aid"]')){
			$scope.depot[$scope.type].title = json.data.filename;
			$scope.depot[$scope.type].size = json.data.size;
			$scope.depot[$scope.type].format = json.data.ext;
			$scope.$apply();
		}
	});
	$scope.$on('uploader.removed', function(e, scope, elem, file, removeId, ids){
		if ($scope.type != 'news' && elem.is('[name="aid"]')){
			$scope.depot[$scope.type].title = '';
			$scope.depot[$scope.type].size = 0;
			$scope.depot[$scope.type].format = '';
			$scope.$apply();
		}
	});

	if (!isNaN($scope.depotId) && $scope.depotId > 0)
		$scope.load().done(function(){
			if ($scope.type == 'news')
				$scope.editNews(0);
		});
	else
	{
		$scope.init();
		if ($scope.type == 'news') //创建一条空白新闻
			$scope.createNews();
	}

});