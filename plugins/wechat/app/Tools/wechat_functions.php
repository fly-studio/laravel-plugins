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
	$instance = new Storages\Account();
	if (is_null($account_id))
		return $instance->get();
	else if ($account_id === false)
		return $instance->forget();
	else
		$instance->put($account_id);
}

function user_storage($account_id, $wuid = null)
{
	$instance = new Storages\User($account_id);
	if (is_null($wuid))
		return $instance->get();
	else if ($wuid === false)
		return $instance->forget();
	else
		$instance->put($wuid);
}

function oauth2_storage($account_id, $user = null)
{
	$instance = new Storages\OAuth2($account_id);
	if (is_null($user))
		return $instance->get();
	else if ($user === false)
		return $instance->forget();
	else
		$instance->put($user);
}
