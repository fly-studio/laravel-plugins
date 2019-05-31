<?php

namespace Plugins\Attachment\App\Tools\Outputs;

use Plugins\Attachment\App\Contracts\Tools\Output;
use Plugins\Attachment\App\Exceptions\AttachmentException;

class Preview extends Output {

	public function preview($cached = true)
	{
		$attachment = $this->attachment();

		$full_path = $attachment->full_path;
		$mime_type = $attachment->mime;
		$content_length = $attachment->size;
		$last_modified = $attachment->created_at;
		$etag = $attachment->hash;
		return response()->preview($full_path, [], compact('mime_type', 'etag', 'last_modified', 'content_length', 'cached'));
	}
}
