<?php
namespace Plugins\Attachment\App\Tools\Inputs;

use Illuminate\Http\Request;
use Plugins\Attachment\App\Tools\File;
use Plugins\Attachment\App\Contracts\Tools\Input;
use Plugins\Attachment\App\Exceptions\AttachmentException;

class Upload extends Input{

	private $request;

	public function __construct(Request $request)
	{
		//ignore_user_abort(true);
		set_time_limit(0);
		$this->request = $request;
	}


	public function upload($field_name)
	{
		$file = $this->request->file($field_name);
		if (!$this->request->hasFile($field_name) || !$file->isValid())
			throw new AttachmentException($file->getError());
		try {
			return $this->newSave()->file(new File($file->getPathname(), $file->getClientOriginalName()))->deleteFileAfterSaved();
		} catch (\Exception $e) {
			@unlink($file->getPathname());
			throw $e;
			return false;
		}
	}

}