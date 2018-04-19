<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MakeSocialites extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		\DB::transaction(function() {
			\Illuminate\Database\Eloquent\Model::unguard(true);

			$fields = [
				'socialite|社交平台' => [
					'type|社交平台类型' => [
						'qq|QQ' => [],
						'weixin|微信公众号' => [],
						'weixin-web|微信网页授权(二维码)' => [],
						'weibo|新浪微博' => [],
						'douban|豆瓣网' => [],
						'github|Github' => [],
						'google|谷歌 Google' => [],
						'twitter|推特 Twitter' => [],
						'facebook|脸书 Facebook' => [],
						'linked-in|Linked-in' => [],
					],
				],
			];

			\App\Catalog::import($fields, \App\Catalog::findByName('fields'));

			//添加权限
			\App\Permission::import([
				'socialite' => '社交平台',
			]);
			\App\Role::findByName('super')->permissions()->sync(\App\Permission::all());

			\Illuminate\Database\Eloquent\Model::unguard(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{

	}
}
