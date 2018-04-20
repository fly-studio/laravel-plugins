<?php
namespace Plugins\Catalog;

use Validator;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

	}
	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		//添加验证规则
		Validator::extend('catalog', function($attribute, $value, $parameters, $validator) {
			foreach ((array)$value as $v) {
				 $catalogs = catalog_search($v);
				if(empty($catalogs)) return false;
			}
			return true;
		});

		Validator::replacer('catalog', function($message, $attribute, $rule, $parameters) {
			return str_replace([':name'], $parameters[0], $message);
		});

		Validator::extend('catalog_name', function($attribute, $value, $parameters, $validator) {
			foreach ((array)$value as $v) {
				$catalogs = catalog_search((!empty($parameters[0]) ? $parameters[0] : '').'.'.$v);
				if(empty($catalogs)) return false;
			}
			return true;
		});

		Validator::replacer('catalog_name', function($message, $attribute, $rule, $parameters) {
			return str_replace([':name'], $parameters[0], $message);
		});

		Validator::extendImplicit('required_if_catalog', function($attribute, $value, $parameters, $validator) {
			for ($i = 1; $i < count($parameters); $i++) {
				$catalog = catalog_search($parameters[$i]);
				$parameters[$i] = !empty($catalog) ? strval($catalog['id']) : $parameters[$i];
			}
			return $validator->validateRequiredIf($attribute, $value, $parameters);
		});

		Validator::replacer('required_if_catalog', function($message, $attribute, $rule, $parameters, $validator) {
			for ($i = 1; $i < count($parameters); $i++) {
				$catalog = catalog_search($parameters[$i]);
				$parameters[$i] = !empty($catalog) ? $catalog['title'].'('.$catalog['id'].')' : $parameters[$i];
			}
			$parameters[0] = $validator->getAttribute($parameters[0]);
			return str_replace([':other', ':value'], $parameters, $message);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}
}
