<?php

return [
	'store' => [
		'name' => [
			'name' => '权限名',
			'rules' => 'required|regex:/[\w\d_\-\.\*]*/iu|min:1|unique:permissions,{{attribute}},{{id}}',
		],
		'display_name' => [
			'name' => '显示名称',
			'rules' => 'required|string|min:1',
		],
		'description' => [
			'name' => '简介',
			'rules' => [],
		],
	],
];