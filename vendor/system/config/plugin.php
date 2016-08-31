<?php
return [
	'register' => [
		'view' => true,
		'migrate' => false, 
		'translator' => true,
		'router' => true,
		'validation' => true,
	],
	'injectViews' => [
		'admin/sidebar.inc.tpl' => 9999,
	],
];