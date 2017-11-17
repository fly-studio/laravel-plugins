<?php

namespace Plugins\Wechat\App;

use App\Model;
use Plugins\Wechat\App\Models\WechatMessageMediaTrait;

class WechatMessageMedia extends Model {

	use WechatMessageMediaTrait;

	protected $guarded = [];
	public $incrementing = false;

	public function message()
	{
		return $this->hasOne(get_namespace($this).'\\WechatMessage', 'id', 'id');
	}

}
