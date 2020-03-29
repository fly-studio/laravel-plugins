<?php

namespace Plugins\Attachment\App;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttachmentFile extends Model {

	use SoftDeletes;

	protected $guarded = ['id'];
	protected $hidden = ['basename', 'path'];

	public function attachments()
	{
		return $this->hasMany(get_namespace($this).'\\Attachment', 'afid', 'id');
	}

	/**
	 * 得到附件的完整路径
	 * 同下
	 *
	 * @return string
	 */
	public function getFullPathAttribute()
	{
		return Path::realPath($this->path);
	}

	/**
	 * 得到附件的完整路径
	 * 同上
	 *
	 * @return string
	 */
	public function getRealPathAttribute()
	{
		return Path::realPath($this->path);
	}

	/**
	 * 得到附件相对base_path()的相对路径
	 *
	 * @return string
	 */
	public function getRelativePathAttribute()
	{
		return Path::relativePath($this->path);
	}

}
