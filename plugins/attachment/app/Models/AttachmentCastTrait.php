<?php
namespace Plugins\Attachment\App\Models;

use Plugins\Attachment\App\Attachment;

trait AttachmentCastTrait {

	public function asAttachment($value) {
		return Attachment::encode($value);
	}

}
