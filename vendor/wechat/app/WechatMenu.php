<?php
namespace Plugins\Wechat\App;

use Addons\Core\Models\Tree;

class WechatMenu extends Tree{
	public $auto_cache = true;
	protected $guarded = ['id'];

	public function account()
	{
		return $this->hasOne(get_namespace($this).'\\WechatAccount', 'id', 'waid');
	}

	public function depot()
	{
		return $this->hasOne(get_namespace($this).'\\WechatDepot', 'id', 'wdid');
	}
}