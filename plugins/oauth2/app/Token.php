<?php

namespace Plugins\OAuth2\App;

use App\Model;

class Client extends Model {

	protected $table = 'oauth_access_tokens';
	public $incrementing = false;
	protected $guarded = [];
	protected $casts = [
		'scopes' => 'array',
		'revoked' => 'bool',
	];
	protected $dates = [
		'expires_at',
	];
	public $timestamps = false;

	/**
	 * Get the client that the token belongs to.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	/**
	 * Get the user that the token belongs to.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		$provider = config('auth.guards.api.provider');

		return $this->belongsTo(config('auth.providers.'.$provider.'.model'));
	}

	/**
	 * Determine if the token has a given scope.
	 *
	 * @param  string  $scope
	 * @return bool
	 */
	public function can($scope)
	{
		return in_array('*', $this->scopes) ||
			   array_key_exists($scope, array_flip($this->scopes));
	}

	/**
	 * Determine if the token is missing a given scope.
	 *
	 * @param  string  $scope
	 * @return bool
	 */
	public function cant($scope)
	{
		return ! $this->can($scope);
	}

	/**
	 * Revoke the token instance.
	 *
	 * @return bool
	 */
	public function revoke()
	{
		return $this->forceFill(['revoked' => true])->save();
	}

	/**
	 * Determine if the token is a transient JWT token.
	 *
	 * @return bool
	 */
	public function transient()
	{
		return false;
	}

}
