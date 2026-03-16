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
            $table->bigInteger('has_disability_or_mental_condition')->default(0)->comment('Indica se a pessoa possui alguma deficiência ou condição mental que afeta a vida diária');
            $table->bigInteger('needs_help_with_daily_activities')->default(0)->comment('Indica se a pessoa precisa de ajuda com atividades diárias ou vive em uma instituição médica');
            $table->bigInteger('chip_coverage_ends_between')->default(0)->comment('Indica se a cobertura termina entre as datas especificadas');
            $table->bigInteger('ineligible_for_medicaid_or_chip_last_90_days')->default(0)->comment('Indica se a pessoa foi considerada inelegível para Medicaid ou KidCare nos últimos 90 dias');
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
            $table->dropColumn('has_disability_or_mental_condition');
            $table->dropColumn('needs_help_with_daily_activities');
            $table->dropColumn('chip_coverage_ends_between');
            $table->dropColumn('ineligible_for_medicaid_or_chip_last_90_days');
        });
    }
};
