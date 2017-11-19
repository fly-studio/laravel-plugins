<?php

return [
	/*
	 * 微信支付
	 */
	'sandbox'            => false,
	'app_id'             => '',
	'mch_id'             => 'your-mch-id',
	'key'                => 'key-for-signature',
	'cert_path'          => 'path/to/cert/apiclient_cert.pem',    // XXX: 绝对路径！！！！
	'key_path'           => 'path/to/cert/apiclient_key.pem',      // XXX: 绝对路径！！！！
	'notify_url'         => 'http://example.com/payments/wechat-notify',  // 默认支付结果通知地址
];
