(function($){
$().ready(function(){
	var method = {}, $console = $('#console'), $command = $('#console-command'), $view = $('#console-view');
	method.command = {histories: [''], historyIndex: 0};
	
	method.maximize = function() {
		$console.css({top: 0, height: '100%'});
	}
	method.minimize = function() {
		$console.css({top: 'auto', height: '200px'});
	}
	method.remove = function() {
		$console.remove();
	}
	method.console = function(command, timestamp, result, parse)
	{
		if (command)
			method.console.command(command, timestamp);
		if (result)
			method.console.result(result, parse);
		method.command.focus();

	}
	method.console.command = function(msg, timestamp) {
		method.console.result('<span class="command">['+(timestamp > 0 ? new Date(timestamp * 1000) : new Date()).toString()+'] > ' + msg + '</span>', false);
	}
	method.console.result = function(msg, parse) {
		var view = $view.append((parse ? msg.toPre() : msg) + '<br />').parent('.view');
		view.stop(true, true).animate({scrollTop: view[0].scrollHeight});
	}
	method.console.clean = function() {
		$view.empty();
	}

	method.command.push = function(command) {
		if(command != method.command.histories[method.command.histories.length-1]) method.command.histories.push(command);
		method.command.historyIndex = method.command.histories.length;
	}

	method.command.up = function()
	{
		if (--method.command.historyIndex < 0) method.command.historyIndex = method.command.histories.length - 1;
		$command.val(method.command.histories[method.command.historyIndex]);
	}

	method.command.down = function()
	{
		if (++method.command.historyIndex >= method.command.histories.length) method.command.historyIndex = 0;
		$command.val(method.command.histories[method.command.historyIndex]);
	}

	method.command.focus = function()
	{
		$command.val('').focus();
	}

	$('#console-form').on('submit', function(e){
		var command = $command.val();
		if (command == 'clean') {
			method.console.clean();
			method.console(command);
			e.stopImmediatePropagation();
			return false;
		} else if (command == '') {
			e.stopImmediatePropagation();
			return false;
		}
	}).query(function(json){
		method.command.push(json.data.command)
		method.console(json.data.command, json.time, json.result == 'success' ? json.data.result : json.message.content, true);
	},false);

	$('[data-toggle="tooltip"]', $console).tooltip();
	$('.maximize', $console).on('click', function(e){
		method.maximize();
		$('.minimize', $console).removeClass('hide');
		$(this).addClass('hide');
		return false;
	});
	$('.minimize', $console).on('click', function(e){
		method.minimize();
		$('.maximize', $console).removeClass('hide');
		$(this).addClass('hide');
		return false;
	});
	$('.remove', $console).on('click', function(e){
		method.remove();
		return false;
	});
	$command.on('keyup', function(e){
		if (e.which == 38)
			method.command.up();
		else if (e.which == 40)
			method.command.down();
	});
});
})(jQuery);