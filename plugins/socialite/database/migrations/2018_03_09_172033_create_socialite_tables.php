<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialiteTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socialites', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->comment = '名称';
            $table->unsignedInteger('socialite_type')->index()->comment = '社交平台类型';
            $table->string('client_id', 100)->comment = '应用ID';
            $table->string('client_secret', 100)->comment = '应用密钥';
            $table->json('client_extra')->nullable()->comment = '其它配置';
            $table->unsignedInteger('default_role_id')->index()->comment = '默认用户组';
            $table->timestamps();

            $table->unique(['socialite_type', 'client_id']);
            $table->softDeletes(); //软删除
        });

        Schema::create('socialite_users', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sid')->comment = 'socialites ID';
            $table->string('openid', 100)->index();
            $table->string('nickname', 100)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('avatar', 250)->nullable()->comment = '头像Url';
            $table->unsignedInteger('avatar_aid')->nullable()->default(0)->comment = '头像AID'; //头像
            $table->json('profile')->nullable()->comment = '其它资料';

            $table->unsignedInteger('uid')->nullable()->default(0)->comment = '绑定的用户ID'; //绑定的用户ID
            $table->timestamps();
            $table->softDeletes(); //软删除

            $table->foreign('sid')->references('id')->on('socialites')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['sid', 'openid']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('');
    }
}
