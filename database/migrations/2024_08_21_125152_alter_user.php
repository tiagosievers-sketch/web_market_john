<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('idm_access_token','255')->nullable();
            $table->string('idm_refresh_token','255')->nullable();
            $table->string('preferred_language','2')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('idm_access_token');
            $table->dropColumn('idm_refresh_token');
            $table->dropColumn('preferred_language');
        });
    }
};
