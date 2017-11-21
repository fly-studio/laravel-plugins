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

function user_storage($account_id = null, $wuid = null)
{
	$invoke = new Storages\User($account_id);
	return $invoke($wuid);
}

function oauth2_storage($account_id = null, $user = null)
{
	$invoke = new Storages\OAuth2($account_id);
	return $invoke($user);
}
