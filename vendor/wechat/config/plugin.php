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
		'wechat.account' => \Plugins\Wechat\App\Http\Middleware\WechatAccount::class,
	],
	'injectViews' => [
		'admin/sidebar.inc.tpl',
		'admin/menubar.inc.tpl',
	],
];