<?php

namespace Plugins\Attachment\App\Tools;

use Plugins\Attachment\App\Attachment;

class Link {

	/**
	 * 在utils目录下创建一个软连接
	 *
	 * @param  integer $id AID
	 * @return string
	 */
	public static function createSymlink(Attachment $attachment, string $toPath = null, int $life_time = 86400)
	{

		$path = !empty($toPath) ? $toPath : utils_path('attachments/'.'attachment-'.md5($attachment->getKey()).'.'.$attachment->ext);
		@unlink($path);

		symlink($attachment->full_path, $path);

		//!empty($life_time) && delay_unlink($path, $life_time);
		return $path;
	}

	/**
	 * 在utils目录下创建一个硬连接
	 *
	 * @param  integer $id AID
	 * @return string
	 */
	public static function createLink(Attachment $attachment, string $toPath = null, int $life_time = 86400)
	{
		//将云端数据同步到本地
		//
		$path = !empty($toPath) ? $toPath : utils_path('attachments/'.'attachment-'.md5($attachment->getKey()).'.'.$attachment->ext);
		@unlink($path);

		link($attachment->full_path, $path);

		//!empty($life_time) && delay_unlink($path, $life_time);
		return $path;
	}
}
