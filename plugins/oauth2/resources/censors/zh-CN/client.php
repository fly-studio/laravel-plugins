<?php

return [
	'store' => [
		'user_id' => [
			'name' => '绑定用户',
			'rules' => 'required|numeric',
		],
		'name' => [
			'name' => '名称',
			'rules' => 'required',
		],
		'secret' => [
			'name' => '密钥',
			'rules' => 'required|alpha_num|min:40|max:128',
		],
		'redirect' => [
			'name' => '跳转地址',
			'rules' => 'required|url',
		],
		'callback' => [
			'name' => '回调地址',
			'rules' => 'required|url',
		],
		'personal_access_client' => [
			'name' => '个人OAuth客户端',
			'rules' => 'required|bool',
		],
		'password_client' => [
			'name' => '密码OAuth客户端',
			'rules' => 'required|bool',
		],
		'revoked' => [
			'name' => '状态',
			'rules' => 'required|bool',
		],
	],

];
