<?php
namespace Plugins\Attachment\App\Exceptions;

use Lang;
use Addons\Core\Http\OutputResponse;
use Addons\Core\Exceptions\OutputResponseException;

class AttachmentException extends OutputResponseException
{
	public function __construct($message_name = null, $result = 'failure')
	{
		if ($message_name instanceof OutputResponse) {
			$this->response = $message_name;
		} else {
			$this->response = new OutputResponse;
			$_config = config('attachment');
			$_data =  ['maxsize' => format_bytes($_config['maxsize']), 'ext' => implode(',', $_config['ext'])];
			!empty($message_name) && $this->setMessage($message_name, $_data);
		}

		$this->setResult($result);
	}

	public function setMessage($message_name, $transData = [])
	{
		$message = 'attachment.'.$message_name.'.content';
		if (Lang::has($message))
			$message_name = $message;
		elseif (Lang::has('attachment::'.$message))
			$message_name = 'attachment::'.$message;

		return parent::setMessage($message_name, $transData);
	}
}