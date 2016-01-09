<{extends file="extends/main.block.tpl"}>

<{block "head-title"}><title>System Tools</title><{/block}>
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
		<li><a href="">导入数据库(需要先建库)</a> <small>php artisan migrate</small></li>
		<li><a href="">执行SQL语句</a> <small>可以执行任意SQL语句</small></li>
		<li><a href="">执行Schema</a> <small>可以在此处执行<code>Schema::create</code>、<code>Schema::drop</code>、<code>Schema::table</code>等php语句（参：\Illuminate\Database\Schema\Builder）</small></li>
	</ul>
	<div class="page-header">
		<h1>创建</h1>
	</div>
	<ul class="artisan">
		<li><a href="">控制器 Controller</a> <small>php make:controller ControllerName</small></li>
		<li><a href="">数据库 表模型 Model</a> <small>php make:model ModelName</small></li>
		<li><a href="">中间件 Middleware</a> <small>php make:middleware MiddlewareName</small></li>
		<li><a href="">任务队列 Job</a> <small>php make:job JobName</small></li>
		<li><a href="">命令 Command</a> <small>php make:command CommandName</small></li>
		<li><a href="">数据库 迁移 Migration</a> <small>php make:migration MigrationName</small></li>
		<li><a href="">数据库 测试数据 Seeder</a> <small>php make:seeder SeederName</small></li>
	</ul>
	<p></p>
	<p></p>
</div>

<{/block}>

<{block "body-plus"}>
<{include file="[tools]system/console.inc.tpl"}>
<{/block}>