<?php
namespace Plugins\Attachment\App;

use Plugins\Attachment\App\Attachment;

trait AttachmentCastTrait {

	public function asAttachment($value) {
		return Attachment::encode($value);
	}

}