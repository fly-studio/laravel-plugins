<?php

return [
	'store' => [
		'name' => [
			'name' => '微信名称',
			'rules' => 'required|unique:wechat_accounts,{{attribute}},{{id}}',
		],
		'description' => [
			'name' => '简介',
			'rules' => [],
		],
		'wechat_type' => [
			'name' => '类型',
			'rules' => 'required|not_zero|catalog:fields.wechat.type',
		],
		'appid' => [
			'name' => 'APP ID',
			'rules' => 'required|min:10|unique:wechat_accounts,{{attribute}},{{id}}',
		],
		'account' => [
			'name' => '原始 ID',
			'rules' => 'required|min:10|unique:wechat_accounts,{{attribute}},{{id}}',
		],
		'appsecret' => [
			'name' => 'APP Secrect',
			'rules' => 'required|min:10',
		],
		'token' => [
			'name' => 'Token',
			'rules' => 'required|min:1',
		],
		'avatar_aid' => [
			'name' => '二维码',
			'rules' => 'nullable|numeric',
		],
		'encodingaeskey' => [
			'name' => '加密KEY',
			'rules' => 'nullable|min:10',
		],
		'mchid' => [
			'name' => '商戶ID',
			'rules' => 'nullable|min:1',
		],
		'mchkey' => [
			'name' => '商户支付密钥',
			'rules' => 'nullable|min:1',
		],
		'sub_mch_id' => [
			'name' => '子商户号',
			'rules' => 'nullable|min:1',
		],
	],
];
