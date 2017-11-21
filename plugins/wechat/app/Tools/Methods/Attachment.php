<?php

namespace Plugins\Wechat\App\Tools\Methods;

use Plugins\Attachment\App\Tools\InputManager;
use Plugins\Attachment\App\Attachment as AttachmentModel;

class Attachment {

	private $app;

	public static function downloadAvatar($url)
	{
		app(InputManager::class)
			->download($url, 'avatar.jpg')
			->save();
	}
}
