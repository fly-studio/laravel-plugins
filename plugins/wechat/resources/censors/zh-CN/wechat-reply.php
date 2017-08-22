<?php

return [
	'store' => [
		'keywords' => [
			'name' => '关键词',
			'rules' => 'required_unless:match_type,subscribe|max:600|min:1',
			'message' => [
				'required_unless' => '必须输入关键词'
			],
		],
		'match_type' => [
			'name' => '匹配类型',
			'rules' => 'required|in:part,whole,subscribe',
		],
		'reply_count' => [
			'name' => '回复数量',
			'rules' => 'required|numeric',
		],
		'wdid' => [
			'name' => '素材库',
			'rules' => 'required|array',
		],
	],
];
