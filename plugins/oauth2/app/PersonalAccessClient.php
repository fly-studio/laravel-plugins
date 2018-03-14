<?php

namespace Plugins\OAuth2\App;

use App\Model;

class AuthCode extends Model {

	protected $table = 'oauth_personal_access_clients';
	protected $guarded = [];

	/**
	 * Get the client that owns the authentication code.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function client()
	{
		return $this->belongsTo(Client::class);
	}

}
