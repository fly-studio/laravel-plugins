<?php

namespace Plugins\Attachment\App\Tools\Inputs;

use Throwable;
use Illuminate\Http\Request;
use Plugins\Attachment\App\Tools\File;
use Plugins\Attachment\App\Contracts\Tools\Input;
use Plugins\Attachment\App\Exceptions\AttachmentException;

class Raw extends Input{

	public function __construct()
	{
		//ignore_user_abort(true);
		//set_time_limit(0);
	}

	public function raw(string $data, ?string $originalName)
	{
		$filePath = tempnam(sys_get_temp_dir(), 'raw-');

		try {
			file_put_contents($filePath, $data);

			return $this->newSave()
				->file(new File($filePath, $originalName))
				->deleteFileAfterSaved();

		} catch (Throwable $e) {
			@unlink($filePath);
			throw $e;
		}
	}

}
