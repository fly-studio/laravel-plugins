<?php

namespace Plugins\System\App;

use App\Model;

class Setting extends Model {

	protected $guarded = ['id'];
	protected $casts = [
		'value' => 'array',
	];

}
