<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>素材库<{/block}>

<{block "name"}>wechat/depot<{/block}>

<{block "head-styles-plus"}>
<link rel="stylesheet" href="<{'css/wechat/depot.min.css'|plugins}>">
<{/block}>
<{block "head-scripts-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{include file="common/editor.inc.tpl"}>
<script src="<{'js/angular/angular-1.4.8.min.js'|static}>"></script>
<script src="<{'js/angular/ui-bootstrap-tpls-0.14.3.min.js'|static}>"></script>
<script src="<{'js/angular/angular-input-modified.min.js'|static}>"></script>
<script src="<{'js/ueditor/angular-ueditor.js'|static}>"></script>
<script src="<{'js/angular/common.js'|static}>"></script>
<script src="<{'js/wechat/depot.min.js'|plugins}>"></script>
<script src="<{'js/wechat/choose.min.js'|plugins}>"></script>
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