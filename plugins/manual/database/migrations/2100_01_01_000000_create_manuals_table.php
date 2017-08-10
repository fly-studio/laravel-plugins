<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManualsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manuals', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedInteger('pid')->default(0)->index()->comment = '父ID';
			$table->string('title', '250')->comment = '标题';
			$table->text('content')->nullable()->comment = '内容';
			$table->integer('order')->default(0)->index()->comment = 'TREE排序';
			$table->unsignedInteger('level')->default(0)->index()->comment = 'TREE等级';
			$table->string('path', 250)->index()->comment = 'TREE路径';
			$table->timestamps();
		});
		Schema::create('manual_histories', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('mid')->index()->comment = '手册ID';
			$table->string('title', '250')->comment = '标题';
			$table->text('content')->nullable()->comment = '内容';
			//$table->unsignedInteger('uid')->default(0);
			$table->timestamps();
			$table->foreign('mid')->references('id')->on('manuals');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('jobs');
		Schema::drop('failed_jobs');
	}
}
