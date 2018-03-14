<?php

namespace Plugins\OAuth2\App\Repositories;

use DB;
use Illuminate\Http\Request;
use Addons\Core\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;

use Plugins\OAuth2\App\Client;

class ClientRepository extends Repository {

	public function prePage()
	{
		return config('size.models.'.(new Client)->getTable(), config('size.common'));
	}

	public function find($id)
	{
		return Client::find($id);
	}

	/**
	 * Get an active client by the given ID.
	 *
	 * @param  int  $id
	 * @return \Laravel\Passport\Client|null
	 */
	public function findActive($id)
	{
		$client = $this->find($id);

		return $client && ! $client->revoked ? $client : null;
	}

	/**
	 * Get a client instance for the given ID and user ID.
	 *
	 * @param  int  $clientId
	 * @param  mixed  $userId
	 * @return \Laravel\Passport\Client|null
	 */
	public function findForUser($clientId, $userId)
	{
		return Client::where('id', $clientId)
					 ->where('user_id', $userId)
					 ->first();
	}

	/**
	 * Get the client instances for the given user ID.
	 *
	 * @param  mixed  $userId
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function forUser($userId)
	{
		return Client::where('user_id', $userId)
						->orderBy('name', 'asc')->get();
	}

	/**
	 * Get the active client instances for the given user ID.
	 *
	 * @param  mixed  $userId
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function activeForUser($userId)
	{
		return $this->forUser($userId)->reject(function ($client) {
			return $client->revoked;
		})->values();
	}

	/**
	 * Get the personal access token client for the application.
	 *
	 * @return \Laravel\Passport\Client
	 */
	public function personalAccessClient()
	{
		if (Passport::$personalAccessClient) {
			return $this->find(Passport::$personalAccessClient);
		}

		return PersonalAccessClient::orderBy('id', 'desc')->first()->client;
	}

	public function store(array $data)
	{
		$data['secret'] = str_random(40);
		return DB::transaction(function() use ($data) {
			$client = Client::create($data);
			return $client;
		});
	}

	/**
	 * Store a new personal access token client.
	 *
	 * @param  int  $user_id
	 * @param  string  $name
	 * @param  string  $redirect
	 * @return \Laravel\Passport\Client
	 */
	public function createPersonalAccessClient($user_id, $name, $redirect, $callback)
	{
		return tap($this->store(compact('user_id', 'name', 'redirect', 'callback') + ['personal_access_client' => 1]), function ($client) {
			$accessClient = new PersonalAccessClient;
			$accessClient->client_id = $client->id;
			$accessClient->save();
		});
	}

	/**
	 * Store a new password grant client.
	 *
	 * @param  int  $user_id
	 * @param  string  $name
	 * @param  string  $redirect
	 * @return \Laravel\Passport\Client
	 */
	public function createPasswordGrantClient($user_id, $name, $redirect, $callback)
	{
		return $this->store(compact('user_id', 'name', 'redirect', 'callback') + ['password_client' => 1]);
	}

	public function update(Model $client, array $data)
	{
		return DB::transaction(function() use ($client, $data){
			$client->update($data);
			return $client;
		});
	}

	/**
	 * Regenerate the client secret.
	 *
	 * @param  \Laravel\Passport\Client  $client
	 * @return \Laravel\Passport\Client
	 */
	public function regenerateSecret(Client $client)
	{
		$client->forceFill([
			'secret' => str_random(40),
		])->save();

		return $client;
	}

	/**
	 * Determine if the given client is revoked.
	 *
	 * @param  int  $id
	 * @return bool
	 */
	public function revoked($id)
	{
		$client = $this->find($id);

		return is_null($client) || $client->revoked;
	}

	public function destroy(array $ids)
	{
		DB::transaction(function() use ($ids) {
			//Client::destroy($ids);
			foreach(Client::findMany($ids) as $client)
			{
				$client->tokens()->update(['revoked' => true]);
				$client->forceFill(['revoked' => true])->save();
			}
		});
	}

	public function data(Request $request)
	{
		$client = new Client;
		$builder = $client->newQuery();

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数

		return $data;
	}

	public function export(Request $request)
	{
		$client = new Client;
		$builder = $client->newQuery();
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder);

		return $data;
	}

}
