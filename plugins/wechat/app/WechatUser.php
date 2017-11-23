<?php

namespace Plugins\Wechat\App;

use App\Model;
use App\Models\AttachmentCastTrait;

class WechatUser extends Model {

	use AttachmentCastTrait;

	protected $guarded = ['id'];
	protected $casts = [
		'gender' => 'catalog',
		'avatar_aid' => 'attachment',
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
