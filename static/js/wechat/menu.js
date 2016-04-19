//depot controllers
var $app = angular.module('app');
$app.requires = ['jquery','ui.bootstrap', 'untils', 'ngInputModified'];
$app.config(function(inputModifiedConfigProvider) {
	inputModifiedConfigProvider.disableGlobally(); //默认关闭ngInputModified
}).directive('menuController',function() {
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
	$scope.deletedList = [];
	//设定index
	for(var i = 0; i < $scope.dataList.length; ++i)
	{
		$scope.dataList[i].index = (i+1);
		if ($scope.dataList[i].children)
			for (var j = 0; j < $scope.dataList[i].children.length; j++)
				$scope.dataList[i].children[j].index = (i+1) * 10 + (j+1);
	}

	$scope.select = function(item) {
		$scope.menuSelected = item;
	}
	var newID = -1;
	$scope.create = function(parentItem, pid, index) {
		var item = {
			id: newID--,
			pid: pid.toString(),
			title: '',
			type: 'view',
			url: '',
			order: parentItem.length + 1,
			children: [],
			index: index * 10 + (parentItem.length + 1)
		}
		parentItem.push(item);
		$scope.select(parentItem[parentItem.length - 1]); //选中最后一个
		//console.log($scope.form);
	}
	$scope.saveMenus = function()
	{
		if (!$scope.forms.menu) 
			return false;
//console.log($scope.forms.menu);
		var querys = [];
		angular.forEach($scope.forms.menu, function(form, index){
			if (!form) return;
			var $form = jQuery('[name="'+form.$name+'"]');
			var item = index > 10 ? $scope.dataList[ parseInt(index / 10) - 1 ].children[ index % 10 - 1 ] : $scope.dataList[ index - 1 ]; 

			querys.push($query.form($form, function(json){
				if (json.result == 'success') {
					item.id = json.data.id; //如果是新建，则改变id
					if (item.children) for (var i = 0; i < item.children.length; i++) 
						item.children[i].pid = item.id;
					form.$setPristine();
					$scope.$apply();
				}
			}, false).fail(function(json){
				$scope.select(item);
				jQuery.showtips(json);
			}).done(function(json){
				
			}));
		});

		return jQuery.when.apply(this,querys);
	}
	$scope.save = function()
	{
		//提交到服务器
		var submit = function(){
			
			$query.form(jQuery('[name="forms.publish"]')).done(function(json){
				$.showtips(json);
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
	$scope.destroy = function(item, parentItem)
	{
		jQuery.confirm('您确定删除此项吗？', function(){
			for (var i = 0; i < parentItem.length; i++)
				if (parentItem[i].index > item.index)
					parentItem[i].index--;

			if (item.id > 0 ) $scope.deletedList.push(item.id);
			parentItem.splice(item.index % 10 - 1, 1);
			$scope.$apply();

			//delete $scope.forms.menu[item.index];
		});
	}
});