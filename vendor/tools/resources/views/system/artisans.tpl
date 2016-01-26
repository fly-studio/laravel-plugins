<{extends file="extends/main.block.tpl"}>

<{block "head-title"}><title>Artisan Tools</title><{/block}>
<{block "head-styles-plus"}>
<style>
.artisan {}
.artisan li {line-height: 200%}
</style>
<{/block}>

<{block "head-scripts-plus"}>
<script>
(function($){
$().ready(function(){
	$('a[method]').query();

	$('li.nav-artisan','#navigation').addClass('active');

	$('#schema-form,#sql-form').query(function(json){
		if (json.result == 'success')
			$('[name="content"]').val('');
	});

	$('[name="console"]').on('click', function(){
		var cmd = $(this).data('console');
		var submit = function() {
			$('#console-command').val(cmd);
			$('#console-form').trigger('submit');
		}
		var parse = function(){
			var patt = new RegExp('\{(.*?)\}','g');
			if ((result = patt.exec(cmd)) != null)
				$.prompt(result[1], function(text){
					cmd = cmd.replace(result[0], text);
					parse();
				}, function(){
					$.alert('操作取消！');
				});
			else
				submit();
				
		}
		parse();
		return false;
	});
});
})(jQuery);
</script>
<{/block}>

<{block "body-container"}>
<{include file="system/nav.inc.tpl"}>
<div class="container" role="main" style="margin-top:70px;">
	<div class="alert alert-info">
	<b>注意</b>
	<ul>
		<li>以下大部分命令是Artisan的在线版本，这些链接可以代替命令行的php artisan，</li>
		<li>以下命令只能在127.0.0.1下执行</li>
	</ul>
	</div>
	<div class="page-header">
		<h1>数据库</h1>
	</div>
	<ul class="artisan">
		<li><a href="javascript:void(0);" name="console" data-console="php artisan migrate">导入数据库(需要先建库)</a> <small>php artisan migrate</small></li>
		<li><a href="#sql-modal" data-toggle="modal" data-backdrop="static">执行SQL语句</a> <small>可以执行任意SQL语句</small></li>
		<li><a href="#schema-modal" data-toggle="modal" data-backdrop="static">执行Schema</a> <small>可以在此处执行<code>Schema::create</code>、<code>Schema::drop</code>、<code>Schema::table</code>等php语句（参：\Illuminate\Database\Schema\Builder）</small></li>
	</ul>
	<div class="page-header">
		<h1>创建</h1>
	</div>
	<ul class="artisan">
		<li><a href="javascript:void(0);" name="console" data-console="php artisan make:controller {请输入控制器的类名，比如：UserController}">控制器 Controller</a> <small>php artisan make:controller ControllerName</small></li>
		<li><a href="javascript:void(0);" name="console" data-console="php artisan make:model {请输入表模型的类名，比如：User}">数据库 表模型 Model</a> <small>php artisan make:model ModelName</small></li>
		<li><a href="javascript:void(0);" name="console" data-console="php artisan make:middleware {请输入中间件的类名}">中间件 Middleware</a> <small>php artisan make:middleware MiddlewareName</small></li>
		<li><a href="javascript:void(0);" name="console" data-console="php artisan make:job {请输入任务队列的类名}">任务队列 Job</a> <small>php artisan make:job JobName</small></li>
		<li><a href="javascript:void(0);" name="console" data-console="php artisan make:command {请输入命令的类名}">命令 Command</a> <small>php artisan make:command CommandName</small></li>
		<li><a href="javascript:void(0);" name="console" data-console="php artisan make:migration {请输入数据库迁移的类名，比如：CreateUserTables}">数据库 迁移 Migration</a> <small>php artisan make:migration MigrationName</small></li>
		<li><a href="javascript:void(0);" name="console" data-console="php artisan make:seeder {请输入数据库测试数据的类名}">数据库 测试数据 Seeder</a> <small>php artisan make:seeder SeederName</small></li>
	</ul>
	<p></p>
	<p></p>
</div>
<div class="modal fade" id="schema-modal">
	<div class="modal-dialog">
		<form action="<{'artisans/schema-query'|url}>" method="POST" id="schema-form">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Schema脚本（PHP）</h4>
			</div>
			<div class="modal-body">
				<textarea name="content" cols="30" rows="10" class="form-control" placeholder="Schema::create('table', function(Blueprint $table) {
	$table->increments('id');
	...
	$table->timestamps();
});"></textarea>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">提交</button>
			</div>
		</div>
		</form>
	</div>
</div>
<div class="modal fade" id="sql-modal">
	<div class="modal-dialog">
		<form action="<{'artisans/sql-query'|url}>" method="POST" id="sql-form">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">SQL脚本</h4>
			</div>
			<div class="modal-body">
				<textarea name="content" cols="30" rows="10" class="form-control" placeholder="CREATE TABLE `table` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  ...
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
"></textarea>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">提交</button>
			</div>
		</div>
		</form>
	</div>
</div>
<{/block}>

<{block "body-plus"}>
<{include file="[tools]system/console.inc.tpl"}>
<{/block}>