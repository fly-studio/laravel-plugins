<?php

return [
	'enabled' => true,
	'register' => [
		'view' => true,
		'migrate' => true,
		'translator' => true,
		'router' => true,
		'censor' => true,
		'event' => true,
	],
	'configs' => [
		'socialite',
	],
	'injectViews' => [
		'admin/sidebar.inc.tpl' => 9997,
	],
];
