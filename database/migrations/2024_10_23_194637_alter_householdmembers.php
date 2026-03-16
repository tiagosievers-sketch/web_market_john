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
            $table->boolean('is_incarcerated_pending')->default(false);
            $table->boolean('answer_member_information')->default(false);
            
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
            $table->dropColumn('is_incarcerated_pending');
            $table->dropColumn('answer_member_information');
        });
    }
};
