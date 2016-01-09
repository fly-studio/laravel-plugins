<?php
return [
	'register' => [
		'view' => true,
		'translator' => true,
		'router' => true,
		'validation' => true,
	],
	'routeMiddleware' => [
		'local' => '\\Plugins\\Tools\\App\\Http\\Middleware\\Local',
	],
];