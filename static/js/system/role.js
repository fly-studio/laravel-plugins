(function($){
	$().ready(function(){
		var method = {};

		method.show = function(roleId)
		{
			$('.tab-pane').hide();
			$('#role-' + roleId).show();
		};
		method.create = function(parentRoleId)
		{
			if (!parentRoleId) {
				$.alert('您无法创建顶级用户组，如果你是管理员，请在数据库中操作。');
				return false;
			}
			method.show(parentRoleId);
			$('#edit-modal').modal({backdrop: 'static'});
			$('#name,#display_name,#description,#url').prop('disabled', false).val('');
			$('#pid').val(parentRoleId).trigger('change').prop('disabled', true);
			$('#pid1').val(parentRoleId);
			$('#edit-form').attr('action', $.baseuri + 'admin/role').find('[name="_method"]').val('POST');
		};
		method.edit = function(roleId)
		{
			method.show(roleId);

			$('#edit-modal').modal({backdrop: 'static'});

			var $container = $('#role-' + roleId);
			['name', 'display_name', 'description', 'url'].forEach(function(i){
				$('#' + i).val($('[name="'+i+'"]', $container).val());
			});

			$('#pid').val($('[name="pid"]', $container).val()).trigger('change').prop('disabled', true);
			$('#pid1').val(0); //无法修改父组
			$('#name').prop('disabled', true);

			$('#edit-form').attr('action', $.baseuri + 'admin/role/'+roleId).find('[name="_method"]').val('PUT');
		};
		method.remove = function(roleId)
		{
			method.show(roleId);
			var $container = $('#role-' + roleId);
			$('#delete-modal').modal({backdrop: 'static'});
			$('#delete-form').attr('action', $.baseuri + 'admin/role/'+roleId);
			$('#role_name').text($container.data('role_name'));
			$('#original_role_id').val($(this).data('role_id'));
		};
		method.addHoverDom = function(treeId, treeNode) {
			var sObj = $("#" + treeNode.tId + "_span");
			if (treeNode.editNameFlag || $("#addBtn_"+treeNode.tId).length>0 || !$zTree.setting.edit.enable) return; //不允许编辑
			//if (treeNode.parentTId) return; //只允许父级
			//console.log(treeNode);
			var addStr = "<span class='button add' id='addBtn_" + treeNode.tId + "' title='添加子用户组' onfocus='this.blur();'></span>";
			sObj.after(addStr);
			var btn = $("#addBtn_"+treeNode.tId);
			btn.off('click').on("click", function(){
				$zTree.selectNode(treeNode);
				method.create(treeNode.id);
				return false;
			});
		};
		method.removeHoverDom = function(treeId, treeNode) {
			$("#addBtn_"+treeNode.tId).off().remove();
		};
		method.showRemoveBtn = function(treeId, treeNode){
			return !treeNode.isParent && treeNode.level !== 0; //不是根,也不是父级
		};
		method.beforeRemove = function(treeId, treeNode) {
			$zTree.selectNode(treeNode);console.log();
			var $obj = $('[name="delete-modal"]', '#role-' + treeNode.id);
			if ($obj.length < 1) {$.alert('该用户组不能被删除');return false;}
			$('[name="delete-modal"]', '#role-' + treeNode.id).triggerHandler('click');
			return false;
		};
		method.beforeRename = function(treeId, treeNode)
		{
			return false;
		};
		method.onclick = function(event, treeId, treeNode) {
			if (treeNode.id !== 0)
			{
				//var p = treeNode.getParentNode();
				//if (!p) return false;
				method.show(treeNode.id);
			}
		};


		var setting = {
			view: {
				addHoverDom: method.addHoverDom,
				removeHoverDom: method.removeHoverDom,
				selectedMulti: false
			},
			edit: {
				enable: true,
				editNameSelectAll: true,
				removeTitle : '删除此项',
				showRemoveBtn: method.showRemoveBtn,
				showRenameBtn:false,
				drag: false
			},
			callback: {
				beforeDrag: method.beforeDrag,
				beforeDrop: method.beforeDrop,
				beforeRemove: method.beforeRemove,
				beforeRename: method.beforeRename,
				onClick: method.onclick
			},
			data: {
				simpleData: {
					enable: true,
					idKey: "id",
					pIdKey: "pid",
					rootPId: 0
				},
				key : {
					name : 'display_name'
				}
			}
		};
		$zTree = $.fn.zTree.init($("#tree"), setting, TreeData);
		$zTree.expandAll(true);
		var node = $zTree.getNodeByParam('name', 'super');
		$zTree.selectNode(node);
		$zTree.expandNode(node, true);
		method.show(node.id);
	
		$('[name="edit-modal"]').on('click', function(){
			var roleId = $(this).closest('.tab-pane').data('id');
			method.edit(roleId);
			return false;
		});

		$('[name="create-modal"]').on('click', function(){
			var parentRoleId = $(this).closest('.tab-pane').data('id');
			method.create(parentRoleId);

			return false;
		});

		$('[name="delete-modal"]').on('click', function(){
			var roleId = $(this).closest('.tab-pane').data('id');
			method.remove(roleId);
			return false;
		});
	});
})(jQuery);