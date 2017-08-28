<?php

return [
	'store' => [
		'type' => [
			'name' => '类型',
			'rules' => 'required|field_name:wechat_message_type',
		],
		'wdnid' => [
			'name' => '文章ID',
			'rules' => 'required|array|min:1',
		],
		'title' => [ // 音乐/视频/图片/录音
			'name' => '内容',
			'rules' => 'required|max:250',
		],
		'size' => [
			'name' => '文件大小',
			'rules' => 'required_with:aid|numeric|not_zero',
		],
		'aid' => [
			'name' => '媒体文件(AID)',
			'rules' => 'required|numeric|not_zero',
		],
		'thumb_aid' => [
			'name' => '缩略图文件(AID)',
			'rules' => 'nullable|numeric',
		],
		'content' => [ // 文本
			'name' => '内容',
			'rules' => 'required|min:1',
		],
		'callback' => [ // 回调
			'name' => '编程内容',
			'rules' => 'required|min:1',
		],
		'description' => [
			'name' => '简介',
			'rules' => [],
		],
		'format' => [
			'name' => '格式',
			'rules' => 'required_with:aid',
		],
	],
];
