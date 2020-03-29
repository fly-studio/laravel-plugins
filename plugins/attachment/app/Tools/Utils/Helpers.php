<?php

namespace Plugins\Attachment\App\Tools\Utils;

use Plugins\Attachment\App\Tools\InputManager;
use Plugins\Attachment\App\Tools\OutputManager;
use Plugins\Attachment\App\Tools\ConversionManager;

use Plugins\Attachment\App\Attachment;

class Helpers {

	private static $cipher;

	/**
	 * 客户端下载附件，既发送一个下载头给客户端
	 *
	 * @param  Attachment   $attachment 待下载的附件
	 * @param  bool         $cached     是否设置E-tag，Last-Modified的缓存头
	 * @return [type]                   [description]
	 */
	public static function send(Attachment $attachment, bool $cached = true)
	{
		return app(OutputManager::class)->attachment($attachment)->send();
	}

	/**
	 * 客户端预览图片，既发送一个图片的头到客户端
	 *
	 * @param  Attachment   $attachment 待预览的附件
	 * @param  bool         $cached     是否设置E-tag，Last-Modified的缓存头
	 * @return [type]                   [description]
	 */
	public static function preview(Attachment $attachment, bool $cached = true)
	{
		return app(OutputManager::class)->attachment($attachment)->preview();
	}

	/**
	 * 客户端预览，并等比resize图片
	 *
	 * @param  Attachment   $attachment 待预览的附件
	 * @param  int          $width      待resize的宽度
	 * @param  int          $height     待resize的高度
	 * @param  bool         $cached     是否缓存resize之后的文件
	 * @return [type]                   [description]
	 */
	public static function resize(Attachment $attachment, int $width, int $height, bool $cached = true)
	{
		return app(OutputManager::class)->attachment($attachment)->resize($width, $height, $cached);
	}

	/**
	 * 客户端预览，附加覆盖水印到原图，且等比resize图片
	 *
	 * @param  Attachment   $attachment 待预览的附件
	 * @param  Attachment   $watermark  水印附件
	 * @param  int          $width      待resize的宽度
	 * @param  int          $height     待resize的高度
	 * @param  bool         $cached     是否缓存临时文件
	 * @return [type]                   [description]
	 */
	public static function watermark(Attachment $attachment, Attachment $watermark, int $width, int $height, bool $cached = true)
	{
		return app(OutputManager::class)->attachment($attachment)->watermark($watermark, $width, $height, $cached);
	}

	/**
	 * 下载一个文件到附件中心
	 *
	 * @param  string      $url      待下载的URL
	 * @param  string|null $filename 下载的源文件名，不设置则自动从header中提取
	 * @param  array       $options
	 * @return [type]                [description]
	 */
	public static function download(string $url, string $filename = null, ?array $options = [])
	{
		$download = app(InputManager::class)->download($url, $filename);

		foreach($options as $key => $value)
			$download->$key($value);

		return $download->save();
	}

	/**
	 * 文件上传到附件中心
	 *
	 * @param  string $field_name 上传的字段名：<input type="file" name="字段名" />
	 * @param  array  $options
	 * @return Attachment
	 */
	public static function upload(string $field_name, ?array $options = [])
	{
		$upload = app(InputManager::class)->upload($field_name);

		foreach($options as $key => $value)
			$upload->$key($value);

		return $upload->save();
	}

	/**
	 * 临时上传，只会保存到storage/utils/attachment临时目录下
	 * 并且返回一个包含文件信息的伪造Attachment（没有id，afid），并没有真正插入数据库中
	 *
	 * @param  string $field_name [description]
	 * @param  array  $options    [description]
	 * @return Attachment
	 */
	public static function tempUpload(string $field_name, ?array $options = [])
	{
		$upload = app(InputManager::class)->tempUpload($field_name);

		foreach($options as $key => $value)
			$upload->$key($value);

		return $upload->save();
	}

	/**
	 * 本地一个文件保存到附件中心
	 * 注意：本地源文件不会被删除
	 *
	 * @param  string $originalFile 源文件路径
	 * @param  array  $options
	 * @return Attachment
	 */
	public static function localSave(string $originalFile, ?array $options = [])
	{
		$hash = app(InputManager::class)->local($originalFile);

		foreach($options as $key => $value)
			$hash->$key($value);

		return $hash->save();
	}

	/**
	 * 秒速上传，即检测Md5+Size在系统中是否存在
	 * 如果存在则返回一个Attachment
	 * 不存在，则抛出一个AttachmentException异常
	 *
	 * @param  string $hash         文件的,md5
	 * @param  int    $size         文件大小
	 * @param  string $originalName 源文件名
	 * @param  array  $options      [description]
	 * @return Attachment
	 */
	public static function hash(string $hash, int $size, ?string $originalName, ?array $options = [])
	{
		$hash = app(InputManager::class)->hash($hash, $size, $originalName);

		foreach($options as $key => $value)
			$hash->$key($value);

		return $hash->save();
	}

	/**
	 * 二进制流上传，通常用于头像截取，或者canvas截图之后的base64上传
	 *
	 * @param  string $raw      二进制流
	 * @param  string $originalName 源文件名
	 * @param  array  $options
	 * @return Attachment
	 */
	public static function uploadRaw(string $raw, string $originalName, ?array $options = [])
	{
		$upload = app(InputManager::class)->raw($raw, $originalName);

		foreach($options as $key => $value)
			$upload->$key($value);

		return $upload->save();
	}

	/**
	 * gif webp svga mp4 截图，最终输出png格式，并保存在附件中心
	 *
	 * 如果不设置frameIndex，按照如下规则
	 * gif webp svga 取第一帧
	 * mp4 取位于时长1/10的关键帧
	 *
	 *
	 * @param  Attachment $fromAttachment 待操作的附件
	 * @param  int        $frameIndex     取哪一帧，默认按照上面的配置
	 * @return Attachment
	 */
	public static function capture(string $file, int $frameIndex = null)
	{

	}

	/**
	 * 转换图片到另外一个格式
	 * 可以转换的格式包换
	 * 图片：psd jpeg jpg png gif webp
	 * 视频：mp4 mov mkv
	 * 音频：mp3 acc ac3 amr
	 * 如果来源和目标的格式一致，则会返回源附件
	 *
	 * @param  Attachment   $fromAttachment 待操作的附件
	 * @param  string       $toExt          待转换的后缀，比如png、mp4、mp3
	 * @param  bool         $saved          是否保存到附件中心
	 * @return Attachment
	 */
	public static function convertMedia(string $file, string $toExt)
	{

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

	/**
	 * 将数字加密
	 *
	 * @param  int    $id 输入任何数字
	 * @return string 密文
	 */
	public static function encode(?int $id)
	{
		return empty($id) ? '0' : '~'.base64_urlencode(static::getCipher()->encrypt(pack('V', $id)));
	}


	/**
	 * 将上面的结果解密成数字
	 * @param  string $id 上面加密之后的密文
	 * @return int
	 */
	public static function decode(?string $id)
	{
		if (empty($id) || !preg_match('@^~[a-z0-9\-_]+$@i', $id) ) //starts with ~
			return false;

		$result = @unpack('Vid', static::getCipher()->decrypt(base64_urldecode(substr($id, 1))));
		if (!isset($result['id']))
			return false;

		return $result['id'];
	}


	/**
	 * 根据id获取URL
	 *
	 * @param  string|int      $aid        ID或密文
	 * @param  string|null  $original_name URL结尾的文件名
	 * @return string
	 */
	public static function getUrl($aid, string $original_name = null)
	{
		return url()->route('attachment', [
			'id' => is_numeric($aid) ? static::encode($aid) : $aid,
			'filename' => $original_name
		]);
	}

	/**
	 * 根据一个文件路径生成一个伪造的Attachment对象
	 *
	 * @param  string $file 文件路径
	 * @return [type]       [description]
	 */
	public static function fakeAttachment(string $file)
	{

	}
}
