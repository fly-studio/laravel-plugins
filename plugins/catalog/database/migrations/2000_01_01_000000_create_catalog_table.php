<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('catalogs', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 150)->index()->comment = '英文名称';
			$table->string('title', 150)->comment = '名称';
			$table->string('description', 250)->nullable()->comment = '';
			$table->json('extra')->nullable()->comment = '扩展数据';
			$table->unsignedInteger('pid')->index()->default(0)->comment = '父ID';
			$table->unsignedInteger('level')->index()->default(0)->comment = 'tree level';
			$table->text('path')->nullable()->comment = 'tree path';
			$table->unsignedInteger('order_index')->default(0)->index()->comment = 'tree order';
			$table->timestamps();
			$table->softDeletes();

			$table->unique(['pid', 'name']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('catalogs');
	}
}
