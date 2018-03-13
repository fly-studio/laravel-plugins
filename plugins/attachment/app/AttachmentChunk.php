<?php

namespace Plugins\Attachment\App;

use App\Model;
use Plugins\Attachment\App\Tools\Utils\Path;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttachmentChunk extends Model{
	use SoftDeletes;

	protected $guarded = ['id'];

	public function attachment()
	{
		return $this->hasOne(get_namespace($this).'\\Attachment', 'id', 'aid');
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
}
