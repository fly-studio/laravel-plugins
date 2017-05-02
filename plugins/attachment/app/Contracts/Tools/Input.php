<?php

namespace Plugins\Attachment\App\Contracts\Tools;

use Plugins\Attachment\App\Tools\SaveManager;
use Plugins\Attachment\App\Tools\File;

abstract class Input {

	public function newSave($driver = null)
	{
		return app(SaveManager::class)->setDriver($driver);
	}

}