<?php

namespace Plugins\System\App\Repositories;

use DB;
use Illuminate\Http\Request;
use Addons\Core\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;

use Plugins\System\App\Setting;

class SettingRepository extends Repository {

	public function prePage()
	{
		return config('size.models.'.(new Setting)->getTable(), config('size.common'));
	}

	public function find($id)
	{
		return Setting::with([])->find($id);
	}

	public function set(string $key, $value, string $subKeys = null)
	{
		return Setting::set($key, $value, $subKeys);
	}

	public function get(string $key, $default = null, string $subKeys = null)
	{
		return Setting::get($key, $default, $subKeys);
	}

	public function findOrFail($id)
	{
		return Setting::with([])->findOrFail($id);
	}

	public function store(array $data)
	{
		return DB::transaction(function() use ($data) {
			$model = Setting::create($data);
			return $model;
		});
	}

	public function update(Model $model, array $data)
	{
		return DB::transaction(function() use ($model, $data){
			$model->update($data);
			return $model;
		});
	}

	public function destroy(array $ids)
	{
		DB::transaction(function() use ($ids) {
			Setting::destroy($ids);
		});
	}

	public function data(Request $request)
	{
		$model = new Setting;
		$builder = $model->newQuery()->with([]);

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数

		return $data;
	}

	public function export(Request $request)
	{
		$model = new Setting;
		$builder = $model->newQuery()->with([]);
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder);

		return $data;
	}

}
