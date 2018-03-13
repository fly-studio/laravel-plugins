<?php

namespace Plugins\Attachment\App\Tools;

use Plugins\Attachment\App\Tools\InputManager;
use Plugins\Attachment\App\Tools\OutputManager;

use Plugins\Attachment\App\Attachment;

class Helpers {

	public static function send(Attachment $attachment, $cached = true)
	{
		return app(OutputManager::class)->attachment($attachment)->send();
	}

	public static function preview(Attachment $attachment, $cached = true)
	{
		return app(OutputManager::class)->attachment($attachment)->preview();
	}

	public static function resize(Attachment $attachment, $width, $height, $cached = true)
	{
		return app(OutputManager::class)->attachment($attachment)->resize($width, $height, $cached);
	}

	public static function watermark(Attachment $attachment, Attachment $watermark, $width, $height, $cached = true)
	{
		return app(OutputManager::class)->attachment($attachment)->watermark($watermark, $width, $height, $cached);
	}

	public static function download($url, $filename = null, array $options = [])
	{
		$download = app(InputManager::class)->download($url, $filename);

		foreach($options as $key => $value)
			$download->$key($value);

		return $download->save();
	}

	public static function upload($field_name, array $options = [])
	{
		$upload = app(InputManager::class)->upload($field_name);

		foreach($options as $key => $value)
			$upload->$key($value);

		return $upload->save();
	}

	public static function hash($hash, $size, $originalName, $options = [])
	{
		$hash = app(InputManager::class)->hash($hash, $size, $originalName);

		foreach($options as $key => $value)
			$hash->$key($value);

		return $hash->save();
	}

	public static function uploadRaw($raw, $filename, array $options = [])
	{
		$upload = app(InputManager::class)->raw($raw, $filename);

		foreach($options as $key => $value)
			$upload->$key($value);

		return $upload->save();
	}
}
