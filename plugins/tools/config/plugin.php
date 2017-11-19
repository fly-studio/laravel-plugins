<?php

return [
	'enabled' => true,
	'register' => [
		'view' => true,
		'migrate' => false,
		'translator' => true,
		'router' => true,
		'censor' => true,
	],
	'routeMiddleware' => [
		'local' => '\\Plugins\\Tools\\App\\Http\\Middleware\\Local',
	],
];
