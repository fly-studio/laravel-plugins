<?php
namespace Plugins\Wechat\App;

use App\Model;

class WechatUser extends Model{
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
		return $this->hasOne(config('auth.model'), 'id', 'uid');
	}

	public function _gender()
	{
		return $this->hasOne('App\\Field', 'id', 'gender');
	}

}