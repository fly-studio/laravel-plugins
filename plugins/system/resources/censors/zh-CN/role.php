<?php

return [
	'store' => [
		'name' => [
			'name' => '组名',
			'rules' => 'required|regex:/[\w\d_\-]*/iu|min:1|unique:roles,{{attribute}},{{id}}',
		],
		'display_name' => [
			'name' => '显示名称',
			'rules' => 'required|string|min:1',
		],
		'description' => [
			'name' => '简介',
			'rules' => [],
		],
		'url' => [
			'name' => '后台路由',
			'rules' => [],
		],
		'permissions' => [
			'name' => '权限',
			'rules' => 'nullable|array',
		],
		'pid' => [
			'name' => '父用户组',
			'rules' => 'required|numeric|not_zero',
		],
	],
	'destroy' => [
		'original_role_id' => [
			'name' => '待删除的组',
			'rules' => 'required|numeric|not_zero',
		],
		'role_id' => [
			'name' => '待转移的组',
			'rules' => 'required|numeric|not_zero|different:original_role_id',
		],
	],
];
