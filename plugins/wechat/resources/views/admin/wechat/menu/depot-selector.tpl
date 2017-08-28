<link rel="stylesheet" href="<{'css/wechat/depot.min.css'|plugins}>">
<link rel="stylesheet" href="<{'css/wechat/menu.min.css'|plugins}>">
<{include file="common/uploader.inc.tpl"}>
<{include file="common/editor.inc.tpl"}>
<script src="<{'js/angular/angular-1.4.8.min.js'|static}>"></script>
<script src="<{'js/angular/ui-bootstrap-tpls-0.14.3.min.js'|static}>"></script>
<script src="<{'js/angular/angular-input-modified.min.js'|static}>"></script>
<script src="<{'js/ueditor/angular-ueditor.js'|static}>"></script>
<script src="<{'js/angular/common.js'|static}>"></script>
<script>
	var menuList = <{$_table_data->toArray()|json_encode nofilter}>
</script>
<script src="<{'js/wechat/menu.min.js'|plugins}>"></script>
<script src="<{'js/wechat/depot.js'|plugins}>"></script>

<{include file="[wechat]admin/wechat/depot/ng-template/depot-selector.tpl"}>
<{include file="[wechat]admin/wechat/depot/ng-template/depot-controller.tpl"}>
<{include file="[wechat]admin/wechat/depot/ng-template/depot-list.tpl"}>
<{include file="[wechat]admin/wechat/depot/ng-template/depot-edit.tpl"}>
<{include file="[wechat]admin/wechat/menu/ng-template/menu-controller.tpl"}>
