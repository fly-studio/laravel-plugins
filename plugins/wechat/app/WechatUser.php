<?php

namespace Plugins\Wechat\App;

use App\Model;

class WechatUser extends Model {

	protected $guarded = ['id'];
	protected $casts = [
		'gender' => 'catalog',
	];

	public function account()
	{
		return $this->hasOne(get_namespace($this).'\\WechatAccount', 'id', 'waid');
	}

	public function user()
	{
		return $this->hasOne(config('auth.providers.users.model'), 'id', 'uid');
	}

}
