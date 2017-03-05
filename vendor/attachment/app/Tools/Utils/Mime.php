<?php
namespace Plugins\Attachment\App\Tools\Utils;

use Addons\Core\File\Mimes;

class Mime {

	public static function byExt($ext)
	{
		return Mimes::getInstance()->mime_by_ext($ext);
	}

	public static function byHeader($path)
	{
		//
	}
}