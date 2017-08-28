<?php

namespace Plugins\Attachment\App\Contracts\Tools;

interface Sync {

	public function recv($hashPath, $toPath = null, $life_time = null);
	public function send($fromPath, $hashPath);

}