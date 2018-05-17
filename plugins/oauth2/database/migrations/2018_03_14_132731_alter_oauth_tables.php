<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOauthTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->string('lang', 20)->nullable()->after('redirect');
            $table->string('callback', 250)->nullable()->after('lang');
            $table->json('extra')->nullable()->after('callback');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->dropColumn('lang');
            $table->dropColumn('callback');
            $table->dropColumn('extra');
        });
    }
}
