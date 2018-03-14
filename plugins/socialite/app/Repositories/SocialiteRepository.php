<?php

namespace Plugins\Socialite\App\Repositories;

use DB;
use Illuminate\Http\Request;
use Addons\Core\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;

use App\Catalog;
use Plugins\Socialite\App\Socialite;

class SocialiteRepository extends Repository {

	public function prePage()
	{
		return config('size.models.'.(new Socialite)->getTable(), config('size.common'));
	}

	public function find($id)
	{
		return Socialite::find($id);
	}

	public function findEnableDrivers($is_wechat_client = false)
	{
		$enable_drivers = array_diff(config('socialite.enable_drivers'), $is_wechat_client ? ['weixin-web'] : ['weixin']);

		$types = array_map(function($v) {
			return $v['id'];
		}, array_only(Catalog::getCatalogsByName('fields.socialite.type.children'), $enable_drivers));

		return Socialite::whereIn('socialite_type', array_values($types))->get();
	}

	public function settings($id)
	{
		$socialite = Socialite::findOrFail($id);
		$name = $socialite->socialite_type->name;
		return [
			$name,
			array_merge(
				config('socialite.drivers.'.$name),
				[
					'client_id' => $socialite->client_id,
					'client_secrect' => $socialite->client_secrect,
				],
				$socialite->client_extra
			),
		];
	}

	public function store(array $data)
	{
		return DB::transaction(function() use ($data) {
			$socialite = Socialite::create($data);
			return $socialite;
		});
	}

	public function update(Model $socialite, array $data)
	{
		return DB::transaction(function() use ($socialite, $data){
			$socialite->update($data);
			return $socialite;
		});
	}

	public function destroy(array $ids)
	{
		DB::transaction(function() use ($ids) {
			Socialite::destroy($ids);
		});
	}

	public function data(Request $request)
	{
		$socialite = new Socialite;
		$builder = $socialite->newQuery();

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数

		return $data;
	}

	public function export(Request $request)
	{
		$socialite = new Socialite;
		$builder = $socialite->newQuery();
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder);

		return $data;
	}

}
