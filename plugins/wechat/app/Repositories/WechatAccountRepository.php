<?php

namespace Plugins\Wechat\App\Repositories;

use Plugins\Wechat\App\Tools;
use Plugins\Wechat\App\WechatAccount;

class WecharAccountRepository {

	public function toConfig($id)
	{
		$account = WechatAccount::findOrFail($id);
		$config = [];
		$config['official_account'] = Tools\extendsConfig('official_account', [
			'app_id'  => $account->appid,
			'secret'  => $account->appsecret,
			'token'   => $account->apptoken,
			'secret'  => $account->appsecret,
			'aes_key' => $account->encodingaeskey,
		]);
		$config['payment'] = Tools\extendsConfig('payment', [
			'merchant_id'        => $account->mchid,
			'key'                => $account->mchkey,
			'cert_path'          => app_path('certs/'.$account->appid.'/'),
			'key_path'           => app_path('certs/'.$account->appid.'/'),
			'sub_merchant_id'    => $account->sub_mch_id,
			'device_info'        => $account->device_info,
			'sub_app_id'         => $account->sub_app_id,
		]);
		return $config;
	}
}
