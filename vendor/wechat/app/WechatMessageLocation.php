<?php
namespace Plugins\Wechat\App;

use App\Model;

class WechatMessageLocation extends Model{
	protected $guarded = [];
	public $incrementing = false;

	public function message()
	{
		return $this->hasOne(get_namespace($this).'\\WechatMessage', 'id', 'id');
	}

	
}