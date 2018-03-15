<?php

return [
	'store' => [
		'name' => [
			'name' => '名称',
			'rules' => 'required',
		],
		'default_role_id' => [
			'name' => '默认用户组',
			'rules' => 'required|numeric',
		],
		'client_id' => [
			'name' => 'Client ID',
			'rules' => 'required|min:5',
		],
		'client_secret' => [
			'name' => 'Client Secret',
			'rules' => 'required',
		],
		'client_extra' => [
			'name' => '其它参数',
			'rules' => 'required',
		],
		'socialite_type' => [
			'name' => '类型',
			'rules' => 'required|catalog',
		],
	],

];
