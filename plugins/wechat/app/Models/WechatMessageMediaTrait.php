<?php
namespace Plugins\Wechat\App\Models;

use Plugins\Wechat\App\Jobs\WechatMedia;

trait WechatMessageMediaTrait {

	public static function bootWechatMessageMediaTrait()
	{
		//下载附件
		static::created(function($media){
			//Queue
			if (!empty($media->aid)) return true;
			$job = (new WechatMedia($media->getKey()))->onQueue('wechat')/*->delay(1)*/;
			app('Illuminate\Contracts\Bus\Dispatcher')->dispatch($job);
		});
	}
	
}
