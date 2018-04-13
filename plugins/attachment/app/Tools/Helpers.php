<?php

namespace Plugins\Attachment\App\Tools;

use Plugins\Attachment\App\Tools\InputManager;
use Plugins\Attachment\App\Tools\OutputManager;

use Plugins\Attachment\App\Attachment;

class Helpers {

	private static $cipher;

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

	public static function getCipher()
	{
		if (empty(static::$cipher))
		{
			static::$cipher = new \phpseclib\Crypt\DES();
			static::$cipher->setPassword(config('attachment.key'));
			//static::$cipher->setIV(crypt_random_string(static::$cipher->getBlockLength() >> 3));
		}
		return static::$cipher;
	}

	public static function encode($id)
	{
		return empty($id) ? '0' : 'gF'.base64_urlencode(static::getCipher()->encrypt(pack('V', $id)));
	}

	public static function decode($id)
	{
		if (empty($id) || !preg_match('@^gF[a-z0-9\-_]+$@i', $id) ) //starts at gF
			return false;
		$result = @unpack('Vid', static::getCipher()->decrypt(base64_urldecode(substr($id, 2))));
		if (!isset($result['id']))
			return false;
		return $result['id'];
	}

	public static function getUrl($aid, $original_name = null)
	{
		return url()->route('attachment', ['id' => is_numeric($aid) ? static::encode($aid) : $aid, 'filename' => $original_name]);
	}
}
