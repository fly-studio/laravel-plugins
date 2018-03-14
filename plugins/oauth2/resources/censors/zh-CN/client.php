<?php

return [
	'store' => [
		'user_id' => [
			'name' => '捆绑用户',
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
			'name' => '来源网址',
			'rules' => 'required|url|regex:/.*\/$/',
			'message' => [
				'regex' => '[:attribute] 必须以 / 结尾'
			]
		],
		'callback' => [
			'name' => '支付回调',
			'rules' => 'required|url|regex:/.*\/$/',
			'message' => [
				'regex' => '[:attribute] 必须以 / 结尾'
			]
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
