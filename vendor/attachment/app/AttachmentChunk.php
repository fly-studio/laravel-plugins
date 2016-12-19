<?php
namespace Plugins\Attachment\App;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttachmentChunk extends Model{
	use SoftDeletes;

	protected $guarded = ['id'];

	public function attachment()
	{
		return $this->hasOne(get_namespace($this).'\\Attachment', 'id', 'aid');
	}
	
	public function get_byhash($hash, $size)
	{
		return $this->where('hash', $hash)->where('size', $size)->first();
	}

	public function get_bybasename($basename)
	{
		return $this->where('basename', $basename)->first();
	}

	public function get_byhash_path($hash_path)
	{
		return $this->where('path', $hash_path)->first();
	}

	public function get($id)
	{
		return $this->find($id)->toArray();
	}
}