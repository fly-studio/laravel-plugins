<?php
namespace Plugins\Wechat\App;

use App\Model;

class WechatLog extends Model{
	protected $guarded = ['id'];

	public function account()
	{
		return $this->hasOne(get_namespace($this).'\\WechatAccount', 'id', 'waid');
	}

}