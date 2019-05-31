<?php

namespace Plugins\Attachment\App\Exceptions;

use Lang;
use Addons\Core\Http\Response\TextResponse;
use Addons\Core\Exceptions\OutputResponseException;

class AttachmentException extends OutputResponseException
{

	public function setMessage($message_name, $transData = [])
	{
		$_config = config('attachment');
		$transData += ['maxsize' => format_bytes($_config['maxsize']), 'ext' => implode(',', $_config['ext'])];

		if (strpos($message_name, '::') === false && strpos($message_name, '.') === false)
		{
			$message = 'attachment.'.$message_name.'.content';
			if (Lang::has($message))
				$message_name = $message;
			else if (Lang::has('attachment::'.$message))
				$message_name = 'attachment::'.$message;
		}

		return parent::setMessage($message_name, $transData);
	}
}
