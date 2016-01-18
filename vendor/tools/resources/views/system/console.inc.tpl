<link rel="stylesheet" href="<{'plugins/css/tools/console.css'|url nofilter}>">
<script src="<{'plugins/js/tools/console.js'|url nofilter}>"></script>
<div class="container console" id="console">
	<div class="row toolbar">
		<span><i class="glyphicon glyphicon-console"></i> &nbsp;&nbsp;控制台</span>
		<div class="pull-right">
			<a href="" class="maximize" data-toggle="tooltip" data-placement="top" title="最大化"><i class="glyphicon glyphicon-chevron-up"></i></a>&nbsp;
			<a href="" class="minimize hide" data-toggle="tooltip" data-placement="bottom" title="恢复"><i class="glyphicon glyphicon-chevron-down"></i></a>&nbsp;
			<a href="" class="remove danger" data-toggle="tooltip" data-placement="left" title="关闭"><i class="glyphicon glyphicon-remove tex-danger"></i></a>
		</div>
	</div>
	<div class="view">
		<code id="console-view"></code>
	</div>
	<div class="control">
	<form action="<{'artisans/console-query'|url}>" id="console-form" method="POST">
		<div class="form-group">
			<div class="input-group">
				<div class="input-group-addon">>_</div>
				<input type="text" class="form-control" name="command" id="console-command" placeholder="输入命令，按回车执行" autofocus="autofocus">
			</div>
		</div>
	</form>
	</div>
</div>
