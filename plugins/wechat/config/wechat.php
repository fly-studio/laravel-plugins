<?php

/*
 * This file is part of the overtrue/laravel-wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
	/*
	 * 默认配置，将会合并到各模块中
	 */
	'defaults' => [
		/*
		 * Debug 模式，bool 值：true/false
		 *
		 * 当值为 false 时，所有的日志都不会记录
		 */
		'debug' => true,

		/*
		 * 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
		 */
		'response_type' => 'array',

		/*
		 * 使用 Laravel 的缓存系统
		 */
		'use_laravel_cache' => true,

		/*
		 * 日志配置
		 *
		 * level: 日志级别，可选为：
		 *                 debug/info/notice/warning/error/critical/alert/emergency
		 * file：日志文件位置(绝对路径!!!)，要求可写权限
		 */
		'log' => [
			'level' => env('WECHAT_LOG_LEVEL', 'debug'),
			'file' => env('WECHAT_LOG_FILE', storage_path('logs/wechat.log')),
		],

		/**
		 * Guzzle 全局设置
		 *
		 * 更多请参考： http://docs.guzzlephp.org/en/latest/request-options.html
		 */
		'http' => [
			'timeout' => 10.0, // 超时时间（秒）
			//'verify' => false, // 关掉 SSL 认证（强烈不建议！！！）
		],
	],

	/*
	 * 路由配置
	 */
	'route' => [
		/*
		 * 是否开启路由
		 */
		'enabled' => false,

		/*
		 * 开放平台第三方平台路由配置
		 */
		'open_platform' => [
			'uri' => 'serve',

			'attributes' => [
				'prefix' => 'open-platform',
				'middleware' => null,
			],
		],
	],
];
