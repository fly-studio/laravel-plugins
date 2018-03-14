<?php

namespace Plugins\OAuth2\App\Repositories;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Addons\Core\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;

use Plugins\OAuth2\App\Token;
use Plugins\OAuth2\App\Client;

class TokenRepository extends Repository
{

	public function prePage()
	{
		return config('size.models.'.(new Token)->getTable(), config('size.common'));
	}

	public function find($id)
	{
		return Token::find($id);
	}

	/**
	 * Get a token by the given user ID and token ID.
	 *
	 * @param  string  $id
	 * @param  int  $userId
	 * @return \Laravel\Passport\Token|null
	 */
	public function findForUser($id, $userId)
	{
		return Token::where('id', $id)->where('user_id', $userId)->first();
	}

	/**
	 * Get the token instances for the given user ID.
	 *
	 * @param  mixed  $userId
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function forUser($userId)
	{
		return Token::where('user_id', $userId)->get();
	}

	/**
	 * Get a valid token instance for the given user and client.
	 *
	 * @param  \Illuminate\Database\Eloquent\Model  $user
	 * @param  \Laravel\Passport\Client  $client
	 * @return \Laravel\Passport\Token|null
	 */
	public function getValidToken($user, Client $client)
	{
		return $client->tokens()
					->whereUserId($user->getKey())
					->whereRevoked(0)
					->where('expires_at', '>', Carbon::now())
					->first();
	}

	public function store(array $data)
	{
		return DB::transaction(function() use ($data) {
			$token = Token::create($data);
			return $token;
		});
	}

	public function update(Model $token, array $data)
	{
		return DB::transaction(function() use ($token, $data){
			$token->update($data);
			return $token;
		});
	}

	public function destroy(array $ids)
	{
		DB::transaction(function() use ($ids) {
			Token::destroy($ids);
		});
	}

	public function data(Request $request)
	{
		$token = new Token;
		$builder = $token->newQuery();

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数

		return $data;
	}

	public function export(Request $request)
	{
		$token = new Token;
		$builder = $token->newQuery();
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder);

		return $data;
	}

	/**
	 * Revoke an access token.
	 *
	 * @param  string  $id
	 * @return mixed
	 */
	public function revokeAccessToken($id)
	{
		return Token::where('id', $id)->update(['revoked' => true]);
	}

	/**
	 * Check if the access token has been revoked.
	 *
	 * @param  string  $id
	 *
	 * @return bool Return true if this token has been revoked
	 */
	public function isAccessTokenRevoked($id)
	{
		if ($token = $this->find($id)) {
			return $token->revoked;
		}

		return true;
	}

	/**
	 * Find a valid token for the given user and client.
	 *
	 * @param  \Illuminate\Database\Eloquent\Model  $user
	 * @param  \Laravel\Passport\Client  $client
	 * @return \Laravel\Passport\Token|null
	 */
	public function findValidToken($user, Client $client)
	{
		return $client->tokens()
					  ->whereUserId($user->getKey())
					  ->whereRevoked(0)
					  ->where('expires_at', '>', Carbon::now())
					  ->latest('expires_at')
					  ->first();
	}
}
