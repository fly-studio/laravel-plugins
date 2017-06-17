<?php
namespace Plugins\Attachment\App;

use DB, Cache;
use App\Model;
use Illuminate\Support\Str;
use Plugins\Attachment\App\Tools\Utils\Path;
use Plugins\Attachment\App\Tools\Utils\Type;
use Plugins\Attachment\App\Tools\Utils\Mime;
use Illuminate\Database\Eloquent\Model as BaseModel;

use Plugins\Attachment\App\AttachmentFile;
use Plugins\Attachment\App\AttachmentChunk;

class Attachment extends Model {
	
	protected $guarded = ['id'];
	protected $hidden = ['full_path', 'real_path', 'relative_path', 'afid', 'basename', 'path', 'cdn_at', 'chunk_count', 'created_at', 'deleted_at', 'updated_at', 'uuid', 'extra'];
	protected $casts = [
		'extra' => 'array',
	];
	protected $appends = [
		'url'
	];

	private static $cipher;

	/**
	 * 得到附件的文件类型
	 * @example image, office, video, text
	 * 
	 * @return string
	 */
	public function getFileTypeAttribute()
	{
		return Type::byExt($this->ext);
	}

	/**
	 * 得到附件的mime
	 * @example image/png, image/jpeg, video/mp4
	 * 
	 * @return string
	 */
	public function getMimeAttribute()
	{
		return Mime::byExt($this->ext);
	}

	/**
	 * 得到附件的完整路径
	 * 同下
	 * 
	 * @return string
	 */
	public function getFullPathAttribute()
	{
		return Path::realPath($this->file->path);
	}

	/**
	 * 得到附件的完整路径
	 * 同上
	 * 
	 * @return string
	 */
	public function getRealPathAttribute()
	{
		return Path::realPath($this->file->path);
	}

	/**
	 * 得到附件相对base_path()的相对路径
	 * 
	 * @return string
	 */
	public function getRelativePathAttribute()
	{
		return Path::relativePath($this->file->path);
	}

	/**
	 * 构造一个符合router标准的URL
	 * 
	 * @return string
	 */
	public function getUrlAttribute()
	{
		return url()->route('attachment', ['id' => static::encode($this->id), 'filename' => $this->original_name]);
	}

	/**
	 * 获取软连接的网址
	 * 
	 * @return string
	 */
	public function getSymlinkUrlAttribute()
	{
		$path = $this->create_symlink(null);
		if (empty($path))
			return false;

		return url(str_replace(base_path(), '', $path));
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
		return 'gF'.base64_urlencode(static::getCipher()->encrypt(pack('V', $id)));
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

	public function file()
	{
		return $this->hasOne(get_namespace($this).'\\AttachmentFile', 'id', 'afid');
	}

	public function chunks()
	{
		return $this->hasMany(get_namespace($this).'\\AttachmentChunk', 'aid', 'id');
	}

	public static function mix($id)
	{
		$attachment = static::findByCache($id);
		if (!empty($attachment) && !empty($attachment->afid))
		{
			$result = $attachment->getAttributes() + AttachmentFile::findByCache($attachment->afid)->getAttributes();
			//Model更新
			$attachment->setRawAttributes($result, true);
		}
		return $attachment;
	}

}