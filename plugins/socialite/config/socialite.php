<?php

return [
	'drivers' => [
		'qq' => [
			'enable' => true,
			'namespace' => 'QQ',
			'client_id' => env('QQ_KEY'),
			'client_secret' => env('QQ_SECRET'),
		],

		'weixin' => [
			'enable' => true,
			'client_id' => env('WEIXIN_KEY'),
			'client_secret' => env('WEIXIN_SECRET'),
		],

		'weixin-web' => [
			'enable' => true,
			'driver_name' => 'weixinweb',
			'client_id' => env('WEIXINWEB_KEY'),
			'client_secret' => env('WEIXINWEB_SECRET'),
		],
	]

];
