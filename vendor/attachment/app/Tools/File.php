<?php

namespace Plugins\Attachment\App\Tools;

use Illuminate\Http\UploadedFile;

class File extends UploadedFile {

	private $hash = null;

	public function hash($hash = null)
	{
		if (is_null($hash))
			return $this->hash ?: md5_file($this->getPathName());

		$this->hash = $hash;
		return $this;
	}

	public function size()
	{
		return $this->getSize();
	}
}