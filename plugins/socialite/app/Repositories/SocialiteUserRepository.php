<?php

namespace Plugins\Socialite\App\Repositories;

use DB;
use Illuminate\Http\Request;
use Laravel\Socialite\AbstractUser;
use Addons\Core\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;
use Plugins\Attachment\App\Tools\Helpers;

use App\User;
use App\Role;
use Plugins\Socialite\App\Socialite;
use Plugins\Attachment\App\Attachment;
use Plugins\Socialite\App\SocialiteUser;

class SocialiteUserRepository extends Repository {

	public function prePage()
	{
		return config('size.models.'.(new SocialiteUser)->getTable(), config('size.common'));
	}

	public function find($id)
	{
		return SocialiteUser::find($id);
	}

	public function findOrFail($id)
	{
		return SocialiteUser::findOrFail($id);
	}

	public function store(array $data)
	{
		return DB::transaction(function() use ($data) {
			$socialiteUser = SocialiteUser::create($data);
			return $socialiteUser;
		});
	}

	public function storeFrom(Socialite $socialite, AbstractUser $user)
	{
		// try download avatar
		try {
			$attachment = Helpers::download($user->avatar, $user->id.'.jpg');
		} catch (\Exception $e) {

		}

		return SocialiteUser::updateOrCreate([
			'sid' => $socialite->getKey(),
			'openid' => $user->id,
		],
		[
			'nickname' => $user->nickname,
			'avatar' => $user->avatar,
			'avatar_aid' => !empty($attachment) ? $attachment->getKey() : 0,
			'name' => $user->name,
			'email' => $user->email,
			'profile' => $user->user,
		]);
	}

	public function attachToUser(SocialiteUser $socialiteUser, Role $role)
	{
		if (empty($socialiteUser->uid))
		{
			$username = $socialiteUser->getKey().'-'.$socialiteUser->openid;
			if (!($user = User::findByUsername($username)))
				$user = User::add(['username' => $username, 'nickname' => $socialiteUser->nickname, 'password' => '', 'avatar_aid' => Attachment::decode($socialiteUser->avatar_aid)], $role);

			$this->update($socialiteUser, ['uid' => $user->getKey()]);
			return $user;
		} else {
			return $socialiteUser->user;
		}
	}

	public function update(Model $socialiteUser, array $data)
	{
		return DB::transaction(function() use ($socialiteUser, $data){
			$socialiteUser->update($data);
			return $socialiteUser;
		});
	}

	public function destroy(array $ids)
	{
		DB::transaction(function() use ($ids) {
			SocialiteUser::destroy($ids);
		});
	}

	public function data(Request $request)
	{
		$socialiteUser = new Socialite;
		$builder = $socialiteUser->newQuery();

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数

		return $data;
	}

	public function export(Request $request)
	{
		$socialiteUser = new Socialite;
		$builder = $socialiteUser->newQuery();
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder);

		return $data;
	}

}
