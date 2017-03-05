<?php
return [
	'enable' => true,
	'register' => [
		'view' => false,
		'migrate' => true, 
		'translator' => true,
		'router' => true,
		'validation' => false,
		'config' => true,
	],
	'config' => [
		'attachment'
	],
	'routeMiddleware' => [
		'flash-session' => \Plugins\Attachment\App\Http\Middleware\FlashSession::class, 
	],
];