<?php

return [
	'store' => [
		'content' => [
			'name' => '内容',
			'rules' => 'required|max:600|min:1',
		],
		'type' => [
			'name' => '类型',
			'rules' => 'required|not_zero|catalog_name:fields.wechat.message_type',
		],
	],
];
