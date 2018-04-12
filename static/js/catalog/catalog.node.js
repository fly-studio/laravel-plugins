if (typeof Vue.options.components['catalog-normal'] == 'undefined')
	Vue.component(
		'catalog-normal',
		require('./vue/catalog-normal.vue')
	);

if (typeof Vue.options.components['catalog-extra-site'] == 'undefined')
	Vue.component(
		'catalog-extra-site',
		require('./vue/catalog-extra-site.vue')
	);

(function($){
	$().ready(function(){
		$('a[method]').query();
		let ajax = new LP.http.jQueryAjax();
		let urlPrefix = $('#catalog-form').attr('url-prefix');
		let catalogForm = new Vue({
			el: '#catalog-form',
			data() {
				return {
					catalogContainer : typeof RootData != 'undefined' && typeof RootData.name != 'undefined' && Vue.options.components['catalog-' + RootData.name] ? 'catalog-' + RootData.name : 'catalog-normal',
					urlPrefix: urlPrefix
				};
			},
			methods: {
				create(pid, tId) {
					this.$refs['catalog-form-container'].create(pid, tId);
				},
				edit(id, tId) {
					this.$refs['catalog-form-container'].edit(id, tId);
				},
				hide() {
					this.$refs['catalog-form-container'].hide();
				}
			},
			mounted() {
				let $form = $('#form').query();
				$('a[method]', $form).query();
			}
		});

		let method = {}, variant = {curDragNodes : null};
		let $zTree = null;
		$('[name="catalog/list"]').addClass('active').parents('li').addClass('active');


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
				catalogForm.create(treeNode.id, treeNode.tId);
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
		};
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
		};
		method.beforeDrop = function(treeId, treeNodes, targetNode, moveType) {
			if (!treeNodes.length || !targetNode) return false;
			var node = treeNodes[0];
			//if (node.parentTId != targetNode.parentTId) return false; //如果父级不一致

			ajax.put(urlPrefix + '/move', {original_id: node.id , target_id: targetNode.id, move_type: moveType }).then(function(json){
				var src_node = $zTree.getNodeByParam("id", json.data.original_id, null);
				var target_node = $zTree.getNodeByParam("id", json.data.target_id, null);
				$zTree.moveNode(target_node,src_node,json.data.move_type);
			});
			return false; //always false, manual it;
		};
		method.beforeRemove = function(treeId, treeNode) {
			$zTree.selectNode(treeNode);
			method.onclick({}, treeNode.tId, treeNode);

			LP.tip.confirm(
				'<p style="text-align:left;">你<b>确认删除</b>此项：<span style="color:red">[' + treeNode.title +']</span>，此操作是不可恢復的</p>',
			).then(() => ajax.delete(urlPrefix + '/' + treeNode.id)).then(() => {$zTree.removeNode(treeNode);catalogForm.hide();});
			return false; //always false, manual it
		};
		method.showRemoveBtn = function(treeId, treeNode){
			return !treeNode.isParent && (~~treeNode.level) !== 0; //不是根,也不是父级
		};

		method.onclick = function(event, treeId, treeNode) {
			if ((~~treeNode.id) !== 0)
			{
				$.bbq.pushState({id: treeNode.id});
				catalogForm.edit(treeNode.id, treeNode.tId);
			}
			else
			{
				$.bbq.pushState({id: treeNode.id});
				catalogForm.create(treeNode.id, treeNode.tId);
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
		$zTree.expandAll(true);
		var config = $.bbq.getState();
		if (!isNaN(config.id))
		{
			var node = $zTree.getNodeByParam('id', config.id);
			if (node)
			{
				$zTree.selectNode(node, false, true);
				method.onclick({}, node.tId, node);
			}
		}
		$zTree.expandNode(node, true);


	});
})(window.jQuery);
