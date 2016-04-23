<?php
namespace Plugins\Wechat\App\Tools;

use Plugins\Wechat\App\Tools\API;

use Plugins\Wechat\App\WechatAccount;
use Plugins\Wechat\App\WechatUser;

use Plugins\Wechat\App\Jobs\WechatSend;
class Send {

	private $user,$api;

	private $messages;

	public function __construct(WechatUser $user, API $api = NULL)
	{
		$this->user = $user;
		$this->api = $api;
		$this->messages = [];
	}
	/**
	 * [add description]
	 * @param mixed $obj WechatDepot/WechatTemplate/Attachment/String
	 */
	public function add($obj)
	{
		foreach (func_get_args() as $value)
			$this->messages[] = $value;
		return $this;
	}

	public function getMessages()
	{
		return $this->messages;
	}

	public function send($random = NULL, $realtime = FALSE)
	{
		$messages = !empty($random) ? array_pick($this->messages, $random) : $this->messages;
		$result = NULL;
		if ($realtime)
		{
			$message = array_shift($messages);
			$result = (new WechatSend($this->user, $message))->reply($this->api);
		}
		foreach ($messages as $value)
		{
			//Queue
			$job = (new WechatSend($this->user, $value))->onQueue('wechat')/*->delay(1)*/;
			app('Illuminate\Contracts\Bus\Dispatcher')->dispatch($job);
		}

		return $result;
	}

}