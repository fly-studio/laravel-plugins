<?php
namespace Plugins\Wechat\App\Models;

trait WechatMessageTrait {

	public static function bootWechatMessageMediaTrait()
	{
		static::deleting(function($message){
			$message->media()->delete();
			$message->link()->delete();
			$message->text()->delete();
			$message->location()->delete();
		});
	}

}
