document.getElementsByTagName('html')[0].setAttribute('ng-app', 'app');
//depot controllers
var $app = angular.module('app', ['jquery', 'ui.bootstrap', 'untils', 'ngInputModified'])
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

})
.directive('menuController',function() {
	return {
		restrict: 'A',
		controller: 'menuController',
		replace: true,
		scope: true,
		templateUrl: function(element, attrs) {
			return attrs.templateUrl || 'wechat/menu';
		}
	}
})
.controller('menuController', function($scope, $query){
	$scope.forms = {}; //form 变量
	$scope.submiting = false;
	$scope.dataList = menuList ? menuList.data : [];
	$scope.menuSelected = null;
	$scope.select = function(item) {
		$scope.menuSelected = item;
	}
	var newID = -1;
	$scope.create = function(parentItem, pid) {
		var item = {
			id: newID--,
			pid: pid.toString(),
			title: '',
			type: 'view',
			url: '',
			order: parentItem.length + 1,
			children: []
		}
		parentItem.push(item);
		$scope.select(parentItem[parentItem.length - 1]);
		//console.log($scope.form);
	}
	$scope.saveMenus = function()
	{
		if (!$scope.forms.menu) 
			return false;

		var querys = [];
		angular.forEach($scope.forms.menu, function(form, index){
			var $form = jQuery('[name="'+form.$name+'"]');

			querys.push($query.form($form, function(json){
				if (json.data) {
					form.from.$modelValue.id = json.data.id; //如果是新建，则改变id
					angular.forEach(form.from.$modelValue.children, function(item){
						item.pid = form.from.$modelValue.id;
					});
					form.$setPristine();
					$scope.$apply();
				}
			}, false).fail(function(json){
				$scope.select(form.from.$modelValue);
				jQuery.showtips(json);
			}).done(function(json){
				
			}));
		});

		return jQuery.when.apply(this,querys);
	}
	$scope.save = function()
	{

		var modified = false;
		for(var i in $scope.forms.menu)
			if ( !!$scope.forms.menu[i].modified )
				modified = true;
		if (!modified)
		{
			jQuery.alert('您没有修改任何内容，无需保存！');
			return false;
		}
		//提交到服务器
		var submit = function(){
			
			$query.form(jQuery('[name="forms.menu"]')).done(function(json){
				
			}).always(function(){
				$scope.submiting = false;
			});
		}
		$scope.submiting = true;
		//先保存菜单,再提交到服务器
		$scope.saveMenus().done(submit).fail(function(){
			$scope.submiting = false;
		});

	}
});