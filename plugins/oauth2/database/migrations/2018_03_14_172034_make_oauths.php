<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MakeOauths extends Migration
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

			];

			\App\Catalog::import($fields, \App\Catalog::findByName('fields'));

			//添加权限
			\App\Permission::import([
				'oauth-client' => 'OAuth客户端',
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
