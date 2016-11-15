<?php
return [
	'enable' => true,
	'register' => [
		'view' => true,
		'migrate' => false, 
		'translator' => true,
		'router' => true,
		'validation' => true,
	],
	'injectViews' => [
		'admin/sidebar.inc.tpl' => 9999,
		'admin/menubar.inc.tpl' => 9999,
	],
];