<?php
namespace Plugins\Attachment\App\Models;

use Plugins\Attachment\App\Tools\Helpers;

trait AttachmentCastTrait {

	public function asAttachment($value) {
		return Helpers::encode($value);
	}

}
