<?php
namespace Plugins\Wechat\App;

trait WechatMessageTrait{

	public static function bootWechatMessageMediaTrait()
	{
		static::deleting(function($message){
			$depot->media()->delete();
			$depot->link()->delete();
			$depot->text()->delete();
			$depot->location()->delete();
		});
	}
}