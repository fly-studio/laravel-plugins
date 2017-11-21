<?php

namespace Plugins\Wechat\App\Tools\Methods;

use Cache;
use Carbon\Carbon;
use Plugins\Wechat\App\WechatUser;
use EasyWeChat\OfficialAccount\Application;
use Overtrue\Socialite\User as SocialiteUser;
use Plugins\Wechat\App\Tools\Methods\Attachment;

class User {

	private $app;
	static $ttl = 3600; //1 hour

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
	 * 更新微信资料(如果没有则添加用户资料)
	 *
	 * @param  string $openid      	OPENID
	 * @param  string $access_token     如果是通过OAuth2授权，则需要传递此参数
	 * @param  string $role_name        组名，只在添加用户时有效
	 * @param  integer $update_expire 	多少分钟更新一次?
	 * @return integer                  返回UID
	 */
	public function updateWechatUser(SocialiteUser $user)
	{
		$waid = $this->app['config']->get('id');
		$app_id = $this->app['config']->get('app_id');
		$wechat = $user->getOriginal();

		$wechatUser = WechatUser::firstOrCreate([
			'openid' => $user['id'],
			'waid' => $waid,
		]);

		//update the unionid
		!empty($wechat['unionid']) && $wechatUser->update(['unionid' => $wechat['unionid']]);

		// break in 1hr
		$delta = $wechatUser->updated_at->diffInSeconds();
		if ($delta < static::$ttl && $delta > 5) return $wechatUser;

		if (isset($wechat['nickname'])) //有详细资料
		{
			$avatar_aid = Attachment::downloadAvatar($user->getAvatar())->getKey();

			//将所有唯一ID匹配的资料都更新
			foreach(!empty($wechat['unionid']) ? WechatUser::where('unionid', $wechat['unionid'])->get() : [$wechatUser] as $v)
			{
				$v->update([
					'nickname' => $wechat['nickname'],
					'gender' => $wechat['sex'],
					'is_subscribed' => !empty($wechat['subscribe']) , //没有打开开发者模式 无此字段
					'subscribed_at' => !empty($wechat['subscribe_time']) ? Carbon::createFromTimestamp($wechat['subscribe_time']) : null,
					'country' => $wechat['country'],
					'province' => $wechat['province'],
					'city' => $wechat['city'],
					'language' => $wechat['language'],
					'remark' => !empty($wechat['remark']) ? $wechat['remark'] : null,//没有打开开发者模式 无此字段
					'groupid' => !empty($wechat['groupid']) ? $wechat['groupid'] : null,//没有打开开发者模式 无此字段
					'avatar_aid' => $avatar_aid,
				]);
			}
		}

		return $wechatUser->getKey();
	}

	public function bindToUser(WechatUser $wechatUser, $role_name = null, $cache = true)
	{
		$userModel = config('auth.providers.users.model');
		$user = !empty($wechatUser->uid) ? $userModel::find($wechatUser->uid) : $userModel::findByName($wechatUser->unionid);
		empty($user) && $user = $userModel::add([
			'username' => $wechatUser->unionid,
			'password' => '',
		], $role_name);

		$wechatUser->update(['uid' => $user->getKey()]);

		$hashkey = 'update-user-from-wechat-'.$user->getKey();
		if (!$cache || is_null(Cache::get($hashkey, null)))
		{
			$user->update([
				'nickname' => $wechatUser->nickname,
				'gender' => $wechatUser->gender,
				'avatar_aid' => $wechatUser->avatar_aid,
			]);
			Cache::put($hashkey, time(), config('cache.ttl'));
		}
		return $user;
	}

}
