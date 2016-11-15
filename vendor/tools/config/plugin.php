<?php
return [
	'enable' => true,
	'register' => [
		'view' => true,
		'migrate' => true, 
		'translator' => true,
		'router' => true,
		'validation' => true,
	],
	'routeMiddleware' => [
		'local' => '\\Plugins\\Tools\\App\\Http\\Middleware\\Local',
	],
];