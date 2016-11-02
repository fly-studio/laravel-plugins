<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Loading...</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
	<script type="text/javascript" src="<{'js/jquery-2.1.0.min.js'|static}>"></script>
	<script src="<{'js/bootstrap3/bootstrap.min.js'|static}>"></script>
	<script src="<{'js/common.js'|static}>"></script>
	<link rel="stylesheet" href="<{'css/bootstrap3/bootstrap.min.css'|static}>" />
	<link rel="stylesheet" href="<{'css/loaders.min.css'|static}>" />
	<style>
	html,body {background: #ed5565;color:#fff;}
	</style>
</head>
<body>
<div class="loading" id="loading" style="position:absolute;left:50%;bottom:45%;-webkit-transform: translate(-50%,-50%);-ms-transform: translate(-50%,-50%);transform: translate(-50%,-50%);"></div>
<div class="text-center" style="position:absolute;left:0;right:0;bottom:39%;"><{$_tips|escape}></div>
<div id="progress" class="text-center" style="position:absolute;left:0;right:0;bottom:35%;"></div>

<script type="text/javascript">
//(function($){
	$('#loading').append('<div></div>'.repeat(<{$_loading_divs}>)).addClass('<{$_style}>');
	var files = <{$_files|@json_encode nofilter}>;
	var index = 0;

	var loading = function()
	{
		$('#progress').text(Math.round(index * 100 / files.length) + '%');
		if (index >= files.length) {
			window.location.href = <{$_url|@json_encode  nofilter}>;
			return false;
		}
		
		jQuery.ajax({
			url : $.baseuri + files[index],
			cache : true,
			async: true,
			dataType: 'text',
			timeout: 5000,
			success: function(){
				index++;
				loading();
			},
			error: function(){
				index++;
				loading();
			}
		});
	}
	loading();
//})(jQuery);
</script>
	
</body>
</html>