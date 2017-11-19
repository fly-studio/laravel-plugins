<?php

namespace Plugins\Wechat\App\Tools;

function extendsConfig($template_name, array $values = []) {
	static $config = [];
	if (!isset($config[$template_name]))
		$config[$template_name] = include(__DIR__.'/../../config/templates/'.$template_name.'.php');



	return array_merge($config[$template_name], $values);
}
