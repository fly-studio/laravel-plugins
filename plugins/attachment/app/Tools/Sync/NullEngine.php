<?php
namespace Plugins\Attachment\App\Tools\Sync;

use Plugins\Attachment\App\Contracts\Tools\Sync;

class NullEngine implements Sync {

	public function recv($hashPath, $toPath = null, $life_time = null)
	{

	}

	public function send($fromPath, $hashPath)
	{

	}
}