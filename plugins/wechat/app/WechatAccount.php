<?php

namespace Plugins\Wechat\App;

use App\Model;

class WechatAccount extends Model {

	protected $guarded = ['id'];
	protected $casts = [
		'wechat_type' => 'catalog',
	];

	public function users()
	{
		return $this->hasMany(get_namespace($this).'\\WechatUser', 'waid', 'id');
	}

	public function messages()
	{
		return $this->hasMany(get_namespace($this).'\\WechatMessage', 'waid', 'id');
	}

	public function menus()
	{
		return $this->hasMany(get_namespace($this).'\\WechatMenu', 'waid', 'id');
	}

	public function depots()
	{
		return $this->hasMany(get_namespace($this).'\\WechatDepot', 'waid', 'id');
	}

}
