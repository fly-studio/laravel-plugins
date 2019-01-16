<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Redirect...</title>
</head>

<body>
	<{$_schema}>
	<script>
		window.location.href='<{$_schema}>';
		setTimeout(function(){
			window.close();
		}, 2000);
	</script>
</body>
</html>
