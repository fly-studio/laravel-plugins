<?php

$router->actions([
	'tools' => ['index', 'clear-cache-query', 'create-static-folder-query', 'recover-password-query'],
	'placeholder' => ['index'],
	'qr' => ['index', 'png', 'svg'],
	'loading' => ['index'],
]);

$router->group(['middleware' => 'local'], function($router){
	$router->actions([
		'artisans' => ['index', 'console-query', 'sql-query', 'schema-query'],
		'install' => ['index', 'save-query'],
		'database' => ['export'],
	]);
});
