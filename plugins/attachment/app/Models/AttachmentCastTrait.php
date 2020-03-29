<?php
namespace Plugins\Attachment\App\Models;

use Plugins\Attachment\App\Tools\Utils\Helpers;

trait AttachmentCastTrait {

	public function asAttachmentUrl($value, $key) {
		return Helpers::getUrl($value);
	}

	public function asAttachment($value, $key) {
		return Helpers::encode($value);
	}

}
