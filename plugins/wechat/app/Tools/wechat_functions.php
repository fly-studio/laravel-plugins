<?php

namespace Plugins\Wechat\App\Tools;

function extendsConfig($template_name, array $values = []) {
	static $config = [];
	if (!isset($config[$template_name]))
		$config[$template_name] = include(__DIR__.'/../../config/templates/'.$template_name.'.php');

	return array_merge(config('wechat.defaults', []), $config[$template_name], $values);
}

function account_storage($account_id = null)
{
	$invoke = new Storages\Account();
	return $invoke($account_id);
}

function user_storage($account_id = null, $openid)
{
	$invoke = new Storages\User();
	return $invoke($account_id, $openid);
}

function oauth2_storage($account_id, $openid)
{
	$invoke = new Storages\OAuth2();
	return $invoke($account_id, $openid);
}
