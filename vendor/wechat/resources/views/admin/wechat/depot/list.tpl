<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>素材库<{/block}>

<{block "name"}>wechat/depot<{/block}>

<{block "head-styles-plus"}>
<link rel="stylesheet" href="<{'plugins/css/wechat/depot.min.css'|url}>">
<{/block}>
<{block "head-scripts-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{include file="common/editor.inc.tpl"}>
<script src="<{'static/js/angular/angular-1.4.8.min.js'|url}>"></script>
<script src="<{'static/js/angular/ui-bootstrap-tpls-0.14.3.min.js'|url}>"></script>
<script src="<{'static/js/angular/angular-input-modified.min.js'|url}>"></script>
<script src="<{'static/js/ueditor/angular-ueditor.js'|url}>"></script>
<script src="<{'static/js/angular/common.js'|url}>"></script>
<script src="<{'plugins/js/wechat/depot.min.js'|url}>"></script>
<script src="<{'plugins/js/wechat/choose.min.js'|url}>"></script>
<script>
(function($){
	$().ready(function(){
		$('[name="wechat/depot/list"]').addClass('active').parents('li').addClass('active');
	});
})(jQuery);
</script>
<{/block}>

<{block "block-container"}>

<div depot-controller="news" mode="edit"></div>

<{include file="[wechat]admin/wechat/depot/ng-template/depot-controller.tpl"}>
<{include file="[wechat]admin/wechat/depot/ng-template/depot-list.tpl"}>
<{include file="[wechat]admin/wechat/depot/ng-template/depot-edit.tpl"}>


<{/block}>