<?php

namespace Plugins\Socialite\App;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Socialite extends Model {
	use SoftDeletes;

	protected $guarded = ['id'];
	protected $hidden = ['client_secret'];
	protected $casts = [
		'socialite_type' => 'catalog',
		'client_extra' => 'array',
	];


}
