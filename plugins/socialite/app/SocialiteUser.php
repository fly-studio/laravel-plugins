<?php

namespace Plugins\Socialite\App;

use App\Model;
use App\Models\AttachmentCastTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialiteUser extends Model {
	use SoftDeletes, AttachmentCastTrait;

	protected $guarded = ['id'];
	protected $hidden = ['client_secret'];
	protected $casts = [
		'avatar_aid' => 'attachment',
		'profile' => 'array',
	];

	public function socialite()
	{
		return $this->hasOne('Plugins\Socialite\App\Socialite', 'id', 'sid');
	}

	public function user()
	{
		return $this->hasOne('App\User', 'id', 'uid');
	}

}
