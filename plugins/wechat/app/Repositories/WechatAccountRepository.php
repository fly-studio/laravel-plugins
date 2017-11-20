<?php

namespace Plugins\Wechat\App\Repositories;

use Plugins\Wechat\App\WechatAccount;

class WechatAccountRepository {

	public function options($id, $optionsName)
	{
		$account = WechatAccount::findOrFail($id);

		switch($optionsName)
		{
			case 'official_account':
				return [
					'app_id'  => $account->appid,
					'secret'  => $account->appsecret,
					'token'   => $account->apptoken,
					'secret'  => $account->appsecret,
					'aes_key' => $account->encodingaeskey,
				];
			case 'payment':
				return [
					'app_id'             => $account->appid,
					'merchant_id'        => $account->mchid,
					'key'                => $account->mchkey,
					'cert_path'          => app_path('certs/'.$account->appid.'/'),
					'key_path'           => app_path('certs/'.$account->appid.'/'),
					'sub_merchant_id'    => $account->sub_mch_id,
					'device_info'        => $account->device_info,
					'sub_app_id'         => $account->sub_app_id,
				];
		}
		return [];
	}
}
