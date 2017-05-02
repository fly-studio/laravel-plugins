<?php
return [
	'failure_ajax_oauth2' => [
		'title' => '微信授权失败',
		'content' => '微信授权失败，请刷新页面再试试？',
	],
	'failure_menu_overflow' => [
		'title' => '微信菜单添加失败',
		'content' => '一级菜单最多为3项，二级菜单最多为5项',
	],
	'menu_created_success' => [
		'title' => '微信菜单创建成功',
		'content' => '微信端需要5分钟后才会刷新!',
	],
	'menu_created_failure' => [
		'title' => '微信菜单创建失败',
		'content' => '失败原因：[:error_no] :error_message!',
	],
	'menu_deleted_success' => [
		'title' => '微信菜单清空成功',
		'content' => '微信端需要5分钟后才会刷新!',
	],
	'menu_deleted_failure' => [
		'title' => '微信菜单清空失败',
		'content' => '失败原因：[:error_no] :error_message!',
	],
	'menu_get_failure' => [
		'title' => '微信菜单读取失败',
		'content' => '失败原因：[:error_no] :error_message!',
	],
	'menu_json_failure' => [
		'title' => '微信JSON菜单上传失败',
		'content' => 'JSON数据解析失败，或请勿输入空的菜单内容！',
	],
];