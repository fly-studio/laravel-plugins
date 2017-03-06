<?php
return [
	'manual' => [
		'store' => [
			'title' => [
				'name' => '标题',
				'rules' => 'required',
			],
			'content' => [
				'name' => '简介',
				'rules' => 'nullable|string',
			],
			'pid' => [
				'name' => '父级',
				'rules' => 'required|numeric',
			],
		],
	],
	'artisans' => [
		'store' => [
			'content' => [
				'name' => '内容',
				'rules' => 'required|string',
			],
		],
	],
	'install' => [
		'store' => [
			'SESSION_PATH' => [
				'name' => '相对路径',
				'rules' => 'required|regex:/^[a-z0-9\-_\/\.]*$/i',
			],
			'APP_URL' => [
				'name' => 'URL',
				'rules' => 'required|url',
			],
			'DB_HOST' => [
				'name' => '数据库地址',
				'rules' => 'required|string',
			],
			'DB_PORT' => [
				'name' => '数据库端口',
				'rules' => 'required|numeric',
			],
			'DB_DATABASE' => [
				'name' => '数据库名',
				'rules' => 'required|regex:/^[a-z0-9\-_\/\.]*$/i',
			],
			'DB_USERNAME' => [
				'name' => '数据库账号',
				'rules' => 'required',
			],
			'DB_PASSWORD' => [
				'name' => '数据库密码',
				'rules' => [],
			],
		],
	],
];