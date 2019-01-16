<?php

namespace Plugins\Attachment\App\Tools\Save;

use Illuminate\Database\Eloquent\Model;
use Plugins\Attachment\App\Contracts\Tools\Save;
use Plugins\Attachment\App\Exceptions\AttachmentException;

use Plugins\Attachment\App\Attachment;

class Temp extends Save {

	public function save()
	{
		$file = $this->manager->file();
		$user = $this->manager->user();

		$tempFile = $this->saveToTempFile($file);

		return (new Attachment())->forceFill([
			'id' => 0,
			'afid' => 0,
			'filename' => pathinfo($tempFile, PATHINFO_BASENAME),
			//'filename' => $this->manager->filename(),
			'ext' => $this->manager->ext(),
			'original_name' => $file->getClientOriginalName(),
			'extra' => $this->manager->extra(),
			'uid' => $user instanceof Model ? $user->getKey() : $user,
		]);

	}
}
