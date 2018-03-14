<?php

namespace Plugins\OAuth2\App;

use App\Model;

class Client extends Model {

	protected $table = 'oauth_clients';
	protected $guarded = ['id'];
	protected $hidden = ['secret'];
	protected $casts = [
		'personal_access_client' => 'bool',
		'password_client' => 'bool',
		'revoked' => 'bool',
		'extra' => 'array',
	];

	public function user()
	{
		return $this->hasOne('App\User', 'id', 'user_id');
	}

	/**
	 * Get all of the authentication codes for the client.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function authCodes()
	{
		return $this->hasMany(AuthCode::class, 'client_id');
	}

	/**
	 * Get all of the tokens that belong to the client.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function tokens()
	{
		return $this->hasMany(Token::class, 'client_id');
	}

}
