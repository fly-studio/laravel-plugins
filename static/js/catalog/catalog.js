(function($){
	$().ready(function(){

		var $form = $('#form').query();
		$('a[method]').query();

		var method = {fields: ['extra[aid]', 'extra[color]', 'name', 'title']}, variant = {curDragNodes : null},dom = {lastConnection: null};
		var $zTree = null;
		$('[name="catalog/"]').addClass('active').parents('li').addClass('active');

		method.create = function(pid, title, tid){
			//init empty
			form_check.init(method.fields, $form);$form.removeClass('hide hidden').show();
			//modify form action
			$('[name="pid"]', $form).val(pid);
			$('#p-title').text(title);
			$('[name="_method"]', $form).val('POST');
			$form.attr('action', $.baseuri + 'admin/catalog');
			$('li', '.catalog-list').removeClass('active');
			$(':submit', $form).text('新建一条');
			if(dom.lastConnection) dom.lastConnection.connections('remove');
			dom.lastConnection = $('#'+tid+'_span').add('#p-title').connections({'class': 'zTree-create'});
			$('.zTree-create').html('<span>新建子项</span>');
			method.uploader();
		}

		method.edit = function(id, pid, title, tid) {
			//init empty
			form_check.init(method.fields, $form);$form.removeClass('hide hidden').show();
			//modify form action
			$('[name="_method"]', $form).val('PUT');
			$form.attr('action', $.baseuri + 'admin/catalog/' + id);
			$('li', '.catalog-list').removeClass('active').filter('#li-' + id).addClass('active');
			$(':submit', $form).text('保存');
			$('[name="pid"]', $form).val(pid);
			$('#p-title').text(title);
			$.GET($.baseuri + 'admin/catalog/'+id+'?of=json', null, function(json){
				if (json.result == 'api') {
					form_check.fill(method.fields, $form, json.data);

					if(dom.lastConnection) dom.lastConnection.connections('remove');
					dom.lastConnection = $('#'+tid+'_span').add('#name').connections({'class': 'zTree-edit'});
					$('.zTree-edit').html('<span>修改</span>');

					method.uploader();
				} else 
					$.showtips(json);
			});
		}

		method.uploader = function()
		{
			if ($('#extra-aid').closest('.form-group').is(':visible'))
				$('#extra-aid').uploader();
		}

		method.addHoverDom = function(treeId, treeNode) {
			var sObj = $("#" + treeNode.tId + "_span");
			if (treeNode.editNameFlag || $("#addBtn_"+treeNode.tId).length>0 || !$zTree.setting.edit.enable) return; //不允许编辑
			//if (treeNode.parentTId) return; //只允许父级
			//console.log(treeNode);
			var addStr = "<span class='button add' id='addBtn_" + treeNode.tId + "' title='添加子项' onfocus='this.blur();'></span>";
			sObj.after(addStr);
			var btn = $("#addBtn_"+treeNode.tId);
			btn.off('click').on("click", function(){
				$zTree.selectNode(treeNode);
				method.create(treeNode.id, treeNode.title, treeNode.tId);
				return false;
			});
		};
		method.removeHoverDom = function(treeId, treeNode) {
			$("#addBtn_"+treeNode.tId).off().remove();
		};
		method.dropPrev = function(treeId, nodes, targetNode) {
			var pNode = targetNode.getParentNode();
			for (var i=0,l=variant.curDragNodes.length; i<l; i++) {
				var curPNode = variant.curDragNodes[i].getParentNode();
				//不能移出父级
				if (curPNode && curPNode !== targetNode.getParentNode() && curPNode.childOuter === false) {
					return false;
				}
			}
			return true;
		}
		method.dropNext = method.dropPrev;
		
		method.beforeDrag = function(treeId, treeNodes) {
			for (var i=0,l=treeNodes.length; i<l; i++) {
				if (treeNodes[i].drag === false) {
					variant.curDragNodes = null;
					return false;
				//不能移出父级
				} else if (treeNodes[i].parentTId && treeNodes[i].getParentNode().childDrag === false) {
					variant.curDragNodes = null;
					return false;
				}
			}
			variant.curDragNodes = treeNodes;
			return true;
		}
		method.beforeDrop = function(treeId, treeNodes, targetNode, moveType) {
			if (!treeNodes.length || !targetNode) return false;
			var node = treeNodes[0];
			if (node.parentTId != targetNode.parentTId) return false; //如果父级不一致

			$.PUT($.baseuri + 'admin/catalog/move', {original_id: node.id , target_id: targetNode.id, move_type: moveType }, function(json){
				var src_node = $zTree.getNodeByParam("id", json.data.original_id, null);
				var target_node = $zTree.getNodeByParam("id", json.data.target_id, null);
				$zTree.moveNode(target_node,src_node,json.data.move_type);
			}, true);
			return false; //always false,manual it;
		}
		method.beforeRemove = function(treeId, treeNode) {
			$zTree.selectNode(treeNode);
			
			$.confirm(
				'<p style="text-align:left;">你<b>确认删除</b>此项：<span style="color:red">[' + treeNode.title +']</span>，此操作是不可恢復的</p>',
				function(){
					$.DELETE($.baseuri + 'admin/catalog/' + treeNode.id, null, function(json){}, true);
				}
			);
			return false;
		}
		method.showRemoveBtn = function(treeId, treeNode){
			return !treeNode.isParent && treeNode.level != 0; //不是根,也不是父级
		}

		method.onclick = function(event, treeId, treeNode) {
			if (treeNode.id != 0)
			{
				var p = treeNode.getParentNode();
				if (!p) return false;
				method.edit(treeNode.id, p.id, p.title, treeNode.tId);
			}
			else 
				method.create(treeNode.id, treeNode.title, treeNode.tId);
		}

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
				drag: {
						isCopy: false,
						autoExpandTrigger: true,
						prev: method.dropPrev,
						inner: false,
						next: method.dropNext
				}
			},
			callback: {
				beforeDrag: method.beforeDrag,
				beforeDrop: method.beforeDrop,
				beforeRemove: method.beforeRemove,
				//beforeRename: method.beforeRename,
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
					name : 'title'
				}
			}
		};
		$zTree = $.fn.zTree.init($("#tree"), setting, TreeData);
		var node = $zTree.expandAll(true);
		$zTree.selectNode(node);
		$zTree.expandNode(node, true);

		
	});
})(jQuery);