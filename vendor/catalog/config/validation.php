<?php

return [
	'catalog' => [
		'store' => [
			'pid' => [
				'name' => '父ID',
				'rules' => 'required|numeric',
			],
			'name' => [
				'name' => '名称',
				'rules' => 'required|regex:/^[a-z][a-z0-9_\.\-]*$/|min:1',
			],
			'title' => [
				'name' => '标题',
				'rules' => 'required|min:1',
			],
			'order_index' => [
				'name' => '排序',
				'rules' => 'required|numeric|not_zero',
			],
			'extra' => [
				'name' => '其它数据',
				'rules' => 'nullable|array',
			],
			'orders' => [
				'name' => '排序',
				'rules' => 'required|array|min:1',
			],
		],
		'move' => [
			'original_id' => [
				'name' => '选定的ID',
				'rules' => 'required|numeric',
			],
			'target_id' => [
				'name' => '待插入ID',
				'rules' => 'required|numeric',
			],
			'move_type' => [
				'name' => '排序方式',
				'rules' => 'required|in:prev,next,inner',
			],
		],
	],
];