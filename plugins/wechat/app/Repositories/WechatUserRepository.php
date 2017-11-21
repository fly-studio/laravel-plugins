<?php

namespace Plugins\Wechat\App\Repositories;

use DB;
use Illuminate\Http\Request;
use Addons\Core\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;

use Plugins\Wechat\App\WechatUser;

class WechatUserRepository extends Repository {

	public function prePage()
	{
		return config('size.models.'.(new WechatUser)->getTable(), config('size.common'));
	}

	public function find($id)
	{
		return WechatUser::find($id);
	}

	public function findOrCreate($waid, $openid)
	{
		return WechatUser::firstOrCreate(compact('openid', 'waid'));
	}

	public function findDuplicates($unionid)
	{
		return WechatUser::where('unionid', $unionid)->get();
	}

	public function store(array $data)
	{
		return DB::transaction(function() use ($data) {
			$WechatUser = WechatUser::create($data);
			return $WechatUser;
		});
	}

	public function update(Model $WechatUser, array $data)
	{
		return DB::transaction(function() use ($WechatUser, $data){
			$WechatUser->update($data);
			return $WechatUser;
		});
	}

	public function destroy(array $ids)
	{
		DB::transaction(function() use ($ids) {
			WechatUser::destroy($ids);
		});
	}

	public function data(Request $request)
	{
		$WechatUser = new WechatUser;
		$builder = $WechatUser->newQuery();

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数

		return $data;
	}

	public function export(Request $request)
	{
		$WechatUser = new WechatUser;
		$builder = $WechatUser->newQuery();
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder);

		return $data;
	}

}
