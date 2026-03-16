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
        Schema::table('income_deductions', function (Blueprint $table) {
            $table->decimal('non_educational_amount', 14, 2)->nullable()->after('educational_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('income_deductions', function (Blueprint $table) {
            $table->dropColumn('non_educational_amount');
        });
    }
};
