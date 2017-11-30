<?php

return [
	'enabled' => true,
	'register' => [
		'view' => true,
		'migrate' => true,
		'translator' => true,
		'router' => true,
		'config' => true,
		'censor' => true,
		'event' =>  true,
	],
	'configs' => [
		'wechat'
	],
	'routeMiddleware' => [
		'wechat.account' => \Plugins\Wechat\App\Http\Middleware\WechatAccount::class,
		'wechat.oauth2' => \Plugins\Wechat\App\Http\Middleware\WechatOAuth2::class,
		'wechat.fake.oauth2' => \Plugins\Wechat\App\Http\Middleware\FakeWechatOAuth2::class,
	],
	'injectViews' => [
		//'admin/sidebar.inc.tpl' => 99,
		'admin/menubar.inc.tpl' => 99,
	],
	'files' => [
		'app/Tools/wechat_functions.php'
	]
];
