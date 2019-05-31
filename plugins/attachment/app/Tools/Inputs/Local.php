<?php

namespace Plugins\Attachment\App\Tools\Inputs;

use Plugins\Attachment\App\Tools\File;
use Plugins\Attachment\App\Contracts\Tools\Input;
use Plugins\Attachment\App\Exceptions\AttachmentException;

class Local extends Input {

	public function local($filePath)
	{
		return $this->newSave()->file(new File($filePath, mb_basename($filePath)));
	}
}
