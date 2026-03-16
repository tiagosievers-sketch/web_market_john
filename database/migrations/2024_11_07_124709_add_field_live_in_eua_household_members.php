<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('household_members', function (Blueprint $table) {
            $table->bigInteger('live_in_eua')->default(0)->comment('Indica se a pessoa vive na EUA labels.moraNoEUA ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('household_members', function (Blueprint $table) {
            $table->dropColumn('live_in_eua');
        });
    }
};
