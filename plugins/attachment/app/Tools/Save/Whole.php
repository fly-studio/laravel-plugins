<?php

namespace Plugins\Attachment\App\Tools\Save;

use Illuminate\Database\Eloquent\Model;
use Plugins\Attachment\App\Contracts\Tools\Save;
use Plugins\Attachment\App\Exceptions\AttachmentException;

use Plugins\Attachment\App\Attachment;

class Whole extends Save {

	public function save()
	{
		$file = $this->manager->file();
		$user = $this->manager->user();

		$attchamentFile = $this->saveToAttachmentFile( $file);

		return Attachment::create([
			'afid' => $attchamentFile->getKey(),
			'filename' => $this->manager->filename(),
			'ext' => $this->manager->ext(),
			'original_name' => $file->getClientOriginalName(),
			'extra' => $this->manager->extra(),
			'uid' => $user instanceof Model ? $user->getKey() : $user,
		]);
	}
}