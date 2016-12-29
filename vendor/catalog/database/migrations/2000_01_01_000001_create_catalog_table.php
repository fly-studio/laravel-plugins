<?php

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
			$table->text('extra')->nullable()->comment = '扩展数据';
			$table->unsignedInteger('pid')->default(0)->comment = '父ID';
			$table->unsignedInteger('order_index')->default(0)->index()->comment = '排序序号';
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
