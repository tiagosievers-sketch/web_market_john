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
            $table->tinyInteger('change_income_or_household_size')->default(0)->comment('Has the household Income or household size changed since Jesse was told coverage was ending?');
            $table->date('last_date_coverage')->nullable()->comment('What\'s the last day of Jesse\'s coverage?');
            $table->date('date_dented_coverage')->nullable()->comment('dented coverage through Florida Medicaid or Florida KidCare (CHIP)? Use the date listed on the letter from your state');
            $table->tinyInteger('coverage_between')->default(0)->comment('Did any of these people have coverage between dates...?');
            $table->tinyInteger('apply_marketplace_qualifying_life_event')->default(0)->comment('Did any of these people apply through the Marketplace after a qualifying life event');

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
            $table->dropColumn('change_income_or_household_size');
            $table->dropColumn('last_date_coverage');
            $table->dropColumn('date_dented_coverage');
            $table->dropColumn('coverage_between');
            $table->dropColumn('apply_marketplace_qualifying_life_event');
        });
    }
};
