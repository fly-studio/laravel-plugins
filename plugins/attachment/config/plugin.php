<?php

return [
	'enabled' => true,
	'register' => [
		'view' => false,
		'migrate' => true,
		'censor' => false,
		'translator' => true,
		'router' => true,
		'config' => true,
	],
	'configs' => [
		'attachment'
	],
	'routeMiddleware' => [
		'flash-session' => \Plugins\Attachment\App\Http\Middleware\FlashSession::class,
	],
];
