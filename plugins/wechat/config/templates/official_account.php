<?php

return [
	/*
	 * 公众号
	 */
	'app_id' => 'your-app-id',         // AppID
	'secret' => 'your-app-secret',    // AppSecret
	'token' => 'your-token',           // Token
	'aes_key' => '',                 // EncodingAESKey

	/*
	 * OAuth 配置
	 *
	 * only_wechat_browser: 只在微信浏览器跳转，如果设置为true，在普通浏览器下不再会跳转。
	 * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login，填写多个时，会依次调用到可以取到用户详细资料为止。比如在已关注的情况下，snsapi_base得到openid，便可使用获取已关注用户API获得详细资料，所以无需snsapi_userinfo。
	 * callback：OAuth授权完成后的回调页地址。如果使用中间件，这项配置无效
	 */
	'oauth' => [
		'only_wechat_browser' => false,
		'scopes'   => ['snsapi_base', 'snsapi_userinfo'],
		'callback' => null,
	],

];
