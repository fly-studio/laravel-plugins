<?php

namespace Plugins\Attachment\App\Tools\Save;

use Illuminate\Database\Eloquent\Model;
use Plugins\Attachment\App\Contracts\Tools\Save;
use Plugins\Attachment\App\Exceptions\AttachmentException;

use Plugins\Attachment\App\Attachment;
use Plugins\Attachment\App\AttachmentFile;

class Hash extends Save {

	protected $hash = null;
	protected $size = null;

	public function hash($hash)
	{
		$this->hash = $hash;
		return $this->manager;
	}

	public function size($size)
	{
		$this->size = $size;
		return $this->manager;
	}

	public function save()
	{
		$user = $this->manager->user();
		$attchmentFile = AttachmentFile::findByHashSize($this->hash, $this->size);

		if (empty($attchmentFile))
			throw AttachmentException::create('hash_not_exists')->code(404);

		return Attachment::create([
			'afid' => $attchmentFile->getKey(),
			'filename' => $this->manager->filename(),
			'ext' => $this->manager->ext(),
			'original_name' => $this->manager->filename(),
			'extra' => $this->manager->extra(),
			'uid' => $user instanceof Model ? $user->getKey() : $user,
		]);
	}
}
