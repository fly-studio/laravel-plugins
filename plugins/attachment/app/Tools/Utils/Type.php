<?php

namespace Plugins\Attachment\App\Tools\Utils;

class Type {

	public static function byExt(string $ext)
	{
		static $types;
		if (empty($types[$ext]))
		{
			$types[$ext] = null;
			foreach (config('attachment.file_type') as $key => $value)
				if (in_array($ext, $value))
				{
					$types[$ext] = $key;
					break;
				}
		}

		return $types[$ext];
	}
}
