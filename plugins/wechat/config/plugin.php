<?php

return [
	'enable' => true,
	'register' => [
		'view' => true,
		'migrate' => true, 
		'translator' => true,
		'router' => true,
		'censor' => true,
	],
	'routeMiddleware' => [
		'wechat.account' => \Plugins\Wechat\App\Http\Middleware\WechatAccount::class,
		'wechat.oauth2' => \Plugins\Wechat\App\Http\Middleware\WechatOAuth2::class,
	],
	'injectViews' => [
		//'admin/sidebar.inc.tpl' => 99,
		'admin/menubar.inc.tpl' => 99,
	],
];
