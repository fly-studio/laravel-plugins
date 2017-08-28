<?php

return [
	'store' => [
		'openid' => [
			'name' => 'OPEN ID',
			'rules' => 'required|min:6',
		],
		'nickname' => [
			'name' => '昵称',
			'rules' => 'nullable|min:1',
		],
		'gender' => [
			'name' => '性别',
			'rules' => 'nullable|catalog:fields.gender',
		],
		'avatar_aid' => [
			'name' => '头像(AID)',
			'rules' => 'nullable|numeric',
		],
		'country' => [
			'name' => '国家',
			'rules' => [],
		],
		'province' => [
			'name' => '省份',
			'rules' => [],
		],
		'city' => [
			'name' => '城市',
			'rules' => [],
		],
		'language' => [
			'name' => '语言',
			'rules' => [],
		],
		'unionid' => [
			'name' => '唯一ID',
			'rules' => [],
		],
		'remark' => [
			'name' => '备注名',
			'rules' => [],
		],
		'groupid' => [
			'name' => '组ID',
			'rules' => [],
		],
		'is_subscribed' => [
			'name' => '已关注',
			'rules' => 'boolean',
		],
		'subscribed_at' => [
			'name' => '关注时间',
			'rules' => 'nullable|date',
		],
		'uid' => [
			'name' => 'UID',
			'rules' => [],
		],
	],
];
