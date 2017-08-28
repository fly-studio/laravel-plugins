<?php

return [
	'store' => [
		'title' => [
			'name' => '菜单名',
			'rules' => 'required|ansi:2|regex:/^[a-z\x{4e00}-\x{9fa5}\x{f900}-\x{fa2d}\s]*$/iu|max:50|min:1',
			'message' => ['regex' => '菜单必须为汉字、英文'],
		],
		'pid' => [
			'name' => '父菜单',
			'rules' => 'required|numeric',
		],
		'type' => [
			'name' => '类型',
			'rules' => 'required|in:view,click,event',
		],
		'event' => [
			'name' => '事件',
			'rules' => 'required_if:type,event|in:pic_sysphoto,pic_photo_or_album,pic_weixin,location_select,scancode_waitmsg,scancode_push',
			'message' => ['required_if' => '请选择具体的事件。']
		],
		'url' => [
			'name' => '链接',
			'rules' => 'required_if:type,view|url',
			'message' => ['required_if' => '请输入跳转网址。']
		],
		'wdid' => [
			'name' => '素材ID',
			'rules' => 'required_if:type,click|numeric',
			'message' => ['required_if' => '请选择素材。']
		],
		'content' => [
			'name' => 'JSON内容',
			'rules' => 'required|string|min:20',
		],
	],
];
