<?php

namespace Plugins\Wechat\App;

use App\Model;

class WechatDepotText extends Model {

	protected $guarded = [];
	public $incrementing = false;

	public function depot()
	{
		return $this->belongsTo(get_namespace($this).'\\WechatDepot', 'wdid', 'id');
	}

}
