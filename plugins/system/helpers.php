<?php

if (! function_exists('setting_set'))
{
	function setting_set(string $key, $value, string $subKeys = null)
	{
		return \Plugins\System\App\Setting::set($key, $value, $subKeys);
	}
}

if (! function_exists('setting_get'))
{
	function setting_get(string $key, $default = null, string $subKeys = null)
	{
		return \Plugins\System\App\Setting::get($key, $default, $subKeys);
	}
}
