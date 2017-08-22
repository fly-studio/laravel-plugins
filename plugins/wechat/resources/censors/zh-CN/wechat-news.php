<?php

return [
	'store' => [
		'title' => [
			'name' => '标题',
			'rules' => 'required|min:1|max:62',
		],
		'author' => [
			'name' => '作者',
			'rules' => 'nullable|max:50',
		],
		'description' => [
			'name' => '摘要',
			'rules' => 'nullable|max:250',
		],
		'cover_aid' => [
			'name' => '封面(AID)',
			'rules' => 'required|numeric|not_zero',
		],
		'cover_in_content' => [
			'name' => '封面显示在正文中',
			'rules' => 'boolean',
		],
		'content' => [
			'name' => '正文',
			'rules' => [],
		],
		'url' => [
			'name' => '原文网址',
			'rules' => 'required_if:redirect,1|url|max:250',
			'message' => ['required_if' => '请输入原文网址，以便跳转。']
		],
		'redirect' => [
			'name' => '直接跳转',
			'rules' => 'boolean',
		],
	],
];
