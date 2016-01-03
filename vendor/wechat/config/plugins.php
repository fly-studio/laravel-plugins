<?php
return [
	'register' => [
		'view' => true,
		'translator' => true,
		'router' => true,
		'validation' => true,
	],
	'routeMiddleware' => [
		'wechat.account' => \Plugins\Wechat\App\Http\Middleware\WechatAccount::class,
	],
];