<?php

namespace Plugins\Attachment\App\Tools\Inputs;

use Plugins\Attachment\App\Tools\File;
use Plugins\Attachment\App\Contracts\Tools\Input;
use Plugins\Attachment\App\Exceptions\AttachmentException;

use Plugins\Attachment\App\AttachmentFile;

class Hash extends Input {

	public function hash($hash, $size, $originalName)
	{
		return $this->newSave('hash')->filename($originalName)->hash($hash)->size($size);
	}
}
