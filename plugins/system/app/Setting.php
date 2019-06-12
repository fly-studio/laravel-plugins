<?php

namespace Plugins\System\App;

use Cache;
use App\Model;
use Illuminate\Support\Arr;

class Setting extends Model {

	protected $guarded = ['id'];
	protected $casts = [
		'value' => 'array',
	];
	protected $fire_caches = ['table-settings'];

	public static function getAllSettings()
	{
		return Cache::remember('table-settings', config('cache.ttl'), function(){
			$settings = Setting::orderBy('key')->get();
			return $settings->pluck('value', 'key');
		});
	}

	public static function set(string $key, $value, string $subKeys = null)
	{
		$setting = Setting::firstOrCreate(['key' => $key], ['value' => []]);
		$v = $setting['value'];
		Arr::set($v, $subKeys, $value);
		$setting->setAttribute('value', $v);
		$setting->save();
		return $setting->value;
	}

	public static function get(string $key, $default = null, string $subKeys = null)
	{
		$settings = static::getAllSettings();
		$r = $settings->has($key) ? $settings[$key] : $default;
		return !is_null($subKeys) ? Arr::get($r, $subKeys, $default) : $r;
	}

}
