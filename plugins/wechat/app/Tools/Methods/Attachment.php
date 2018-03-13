<?php

namespace Plugins\Wechat\App\Tools\Methods;

use Plugins\Attachment\App\Tools\Helpers;
use Plugins\Attachment\App\Attachment as AttachmentModel;

class Attachment {

	private $app;

	public static function downloadAvatar($url)
	{
		return Helpers::download($url, 'avatar.jpg');
	}
}
