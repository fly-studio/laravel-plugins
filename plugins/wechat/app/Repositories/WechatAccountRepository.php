<?php

namespace Plugins\Wechat\App\Repositories;

use DB;
use Illuminate\Http\Request;
use Addons\Core\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;

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

	public function prePage()
	{
		return config('size.models.'.(new WechatAccount)->getTable(), config('size.common'));
	}

	public function find($id)
	{
		return WechatAccount::find($id);
	}

	public function findOrCreate($waid, $openid)
	{
		return WechatAccount::firstOrCreate(compact('openid', 'waid'));
	}

	public function findDuplicates($unionid)
	{
		return WechatAccount::where('unionid', $unionid)->get();
	}

	public function store(array $data)
	{
		return DB::transaction(function() use ($data) {
			$WechatAccount = WechatAccount::create($data);
			return $WechatAccount;
		});
	}

	public function update(Model $WechatAccount, array $data)
	{
		return DB::transaction(function() use ($WechatAccount, $data){
			$WechatAccount->update($data);
			return $WechatAccount;
		});
	}

	public function destroy(array $ids)
	{
		DB::transaction(function() use ($ids) {
			WechatAccount::destroy($ids);
		});
	}

	public function data(Request $request)
	{
		$WechatAccount = new WechatAccount;
		$builder = $WechatAccount->newQuery();

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数

		return $data;
	}

	public function export(Request $request)
	{
		$WechatAccount = new WechatAccount;
		$builder = $WechatAccount->newQuery();
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder);

		return $data;
	}
}
