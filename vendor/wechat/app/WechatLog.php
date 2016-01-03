<?php
namespace Plugins\Wechat\App;

use Addons\Core\Models\Model;

class WechatLog extends Model{
	public $auto_cache = true;
	protected $guarded = ['id'];

	public function account()
	{
		return $this->hasOne(get_namespace($this).'\\WechatAccount', 'id', 'waid');
	}

}