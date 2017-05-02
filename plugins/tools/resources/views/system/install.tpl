<{extends file="[tools]system/main.block.tpl"}>

<{block "head-title"}><title>安装L+</title><{/block}>
<{block "head-styles-plus"}>
<{/block}>

<{block "head-scripts-plus"}>
<script>
(function($){
$().ready(function(){
	$('li.nav-install','#navigation').addClass('active');

	$('input').on('input propertychange', function(){
		var name = $(this).attr('name');
		$('.' + name).text($(this).val());
	});
	$('a[method]').query();
	$('#form').query(function(json){
		if (json.result == 'success')
		{
			$('#form').remove();
		}
	}, false);
});
})(jQuery);
</script>
<{/block}>

<{block "body-container"}>
<{include file="system/nav.inc.tpl"}>
<div class="container" role="main" style="margin-top:70px;margin-bottom:70px;">
	<h1 class="page-header">第一步：连接静态文件夹</h1>
	<div>
		<h3>Windows 7 / Linux</h3>
			<a href="<{'tools/create-static-folder-query'|url}>" method="get" class="" target="_blank">点击设置文件夹</a>
		<h3>Windows 8+ 必须启用Administrator权限，方可mklink</h3>
		1. <kbd>Win + X</kbd> - 命令提示符(管理员)(A)
		<p>
		<pre><code>&gt; cd /d <{base_path()}>
&gt; mklink /D static\common ..\..\static
&gt; mklink /D static\plugins ..\..\l++\static</code></pre>
		</p>
		2. 刷新本页
		
	</div>
	<h1 class="page-header">第二步</h1>
	<form class="form-horizontal" role="form" action="<{'install/save-query'|url}>" method="POST" id="form" confirm="您确认每一项都输入无误（系统不会深度检查输入的有效性）？">
		<{csrf_field() nofilter}>
		<div class="form-group">
			<label for="SESSION_PATH" class="col-sm-2 control-label">相对路径</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="SESSION_PATH" name="SESSION_PATH" value="<{env('SESSION_PATH', $_path)}>" placeholder="">
				<span class="help-block">
					比如: /project，根目录：/<br>
					<code>.htaccess</code> RewriteBase <i class="SESSION_PATH"><{env('SESSION_PATH', $_path)}></i><br>
					<code>.env</code> SESSION_PATH=<i class="SESSION_PATH"><{env('SESSION_PATH', $_path)}></i>
				</span>
			</div>
		</div>
		<div class="form-group">
			<label for="APP_URL" class="col-sm-2 control-label">URL</label>
			<div class="col-sm-10">
				<input type="url" class="form-control" id="APP_URL" name="APP_URL" value="<{env('APP_URL', $_url)}>" placeholder="">
				<span class="help-block">
					比如：http://127.0.0.1/ <br>
					<code>.env</code> APP_URL=<i class="APP_URL"><{env('APP_URL', $_url)}></i>
				</span>
			</div>
		</div>
		<div class="form-group">
			<label for="DB_HOST" class="col-sm-2 control-label">数据库地址</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="DB_HOST" name="DB_HOST" value="<{env('DB_HOST', '127.0.0.1')}>" placeholder="比如：127.0.0.1">
				<span class="help-block">
					<code>.env</code> DB_HOST=<i class="DB_HOST"><{env('DB_HOST', '127.0.0.1')}></i>
				</span>
			</div>
		</div>
		<div class="form-group">
			<label for="DB_PORT" class="col-sm-2 control-label">数据库端口</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="DB_PORT" name="DB_PORT" value="<{env('DB_PORT', 3306)}>" placeholder="比如：3306">
				<span class="help-block">
					<code>.env</code> DB_PORT=<i class="DB_PORT"><{env('DB_PORT', 3306)}></i>
				</span>
			</div>
		</div>
		<div class="form-group">
			<label for="DB_DATABASE" class="col-sm-2 control-label">数据库名</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="DB_DATABASE" name="DB_DATABASE" value="<{env('DB_DATABASE', '')}>" placeholder="比如：project">
				<span class="help-block">
					<code>.env</code> DB_DATABASE=<i class="DB_DATABASE"><{env('DB_DATABASE', '')}></i>
				</span>
			</div>
		</div>
		<div class="form-group">
			<label for="DB_USERNAME" class="col-sm-2 control-label">数据库账号</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="DB_USERNAME" name="DB_USERNAME" value="<{env('DB_USERNAME', 'root')}>" placeholder="比如：root">
				<span class="help-block">
					<code>.env</code> DB_USERNAME=<i class="DB_USERNAME"><{env('DB_USERNAME', 'root')}></i>
				</span>
			</div>
		</div>
		<div class="form-group">
			<label for="DB_PASSWORD" class="col-sm-2 control-label">数据库密码</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="DB_PASSWORD" name="DB_PASSWORD" value="<{env('DB_PASSWORD', '')}>" placeholder="请输入密码">
				<span class="help-block">
					<code>.env</code> DB_PASSWORD=<i class="DB_PASSWORD"><{env('DB_PASSWORD', '')}></i>
				</span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-success">保存</button>
				<span class="help-block"><b>注意：</b>每次保存都会重新生成APP_KEY</span>

			</div>
		</div>
	</form>
	<h1 class="page-header">第三步：迁移数据库</h1>
	<div>
		<a href="<{'artisans/console-query'|url}>?command=php%20artisan%20migrate" target="_blank">点击迁移数据库</a>
	</div>
</div>


<{/block}>