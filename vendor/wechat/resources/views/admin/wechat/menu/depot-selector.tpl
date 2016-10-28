<link rel="stylesheet" href="<{'plugins/css/wechat/depot.min.css'|url}>">
<link rel="stylesheet" href="<{'plugins/css/wechat/menu.min.css'|url}>">
<{include file="common/uploader.inc.tpl"}>
<{include file="common/editor.inc.tpl"}>
<script src="<{'static/js/angular/angular-1.4.8.min.js'|url}>"></script>
<script src="<{'static/js/angular/ui-bootstrap-tpls-0.14.3.min.js'|url}>"></script>
<script src="<{'static/js/angular/angular-input-modified.min.js'|url}>"></script>
<script src="<{'static/js/ueditor/angular-ueditor.js'|url}>"></script>
<script src="<{'static/js/angular/common.js'|url}>"></script>
<script>
	var menuList = <{$_table_data->toArray()|json_encode nofilter}>
</script>
<script src="<{'plugins/js/wechat/menu.min.js'|url}>"></script>
<script src="<{'plugins/js/wechat/depot.js'|url}>"></script>

<{include file="[wechat]admin/wechat/depot/ng-template/depot-selector.tpl"}>
<{include file="[wechat]admin/wechat/depot/ng-template/depot-controller.tpl"}>
<{include file="[wechat]admin/wechat/depot/ng-template/depot-list.tpl"}>
<{include file="[wechat]admin/wechat/depot/ng-template/depot-edit.tpl"}>
<{include file="[wechat]admin/wechat/menu/ng-template/menu-controller.tpl"}>
