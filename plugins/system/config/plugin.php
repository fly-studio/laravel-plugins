<?php

return [
	'enabled' => true,
	'register' => [
		'view' => true,
		'migrate' => true,
		'translator' => true,
		'router' => true,
		'censor' => true,
	],
	'commands' => [
		\Plugins\System\App\Console\AlterDatePartitionCommand::class,
	],
	'injectViews' => [
		'admin/sidebar.inc.tpl' => 9999,
		'admin/menubar.inc.tpl' => 9999,
	],
	'files' => [
		'helpers.php'
	],
];
