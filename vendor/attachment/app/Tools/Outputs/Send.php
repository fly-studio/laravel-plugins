<?php
namespace Plugins\Attachment\App\Tools\Outputs;

use Plugins\Attachment\App\Contracts\Tools\Output;
use Plugins\Attachment\App\Exceptions\AttachmentException;

class Send extends Output {
	
	public function send($cache = true)
	{
		$attachment = $this->attachment();

		$full_path = $attachment->full_path;
		$content_length = $attachment->size;
		$last_modified = $attachment->created_at;
		$etag = $attachment->hash;
		return response()->download($full_path, $attachment->filename, [], compact('mime_type', 'etag', 'last_modified', 'content_length', 'cached'));
	}
}