<?php
return [
	'register' => [
		'view' => true,
		'migrate' => true, 
		'translator' => true,
		'router' => true,
		'validation' => true,
	],
	'routeMiddleware' => [
		'wechat.account' => \Plugins\Wechat\App\Http\Middleware\WechatAccount::class,
	],
	'injectViews' => [
		'admin/sidebar.inc.tpl',
	],
];