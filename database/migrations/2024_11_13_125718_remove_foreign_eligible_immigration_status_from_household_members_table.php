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
            $table->dropForeign(['eligible_immigration_status']); // Remove a foreign key constraint
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
            $table->foreign('eligible_immigration_status')
                  ->references('id')
                  ->on('domain_values');
        });

    }
};
