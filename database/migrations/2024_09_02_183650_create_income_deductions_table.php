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
        Schema::create('income_deductions', function (Blueprint $table) {
            $table->id();
            $table->boolean('type')->default(false);
            //
            $table->unsignedBigInteger('income_deduction_type')->nullable(); // Assuming domain_values table has an id column as primary key
            $table->foreign('income_deduction_type')->references('id')->on('domain_values');
            //
            $table->decimal('amount', 14, 2)->nullable();
            $table->decimal('educational_amount', 14, 2)->nullable();
            $table->unsignedBigInteger('frequency')->nullable(); // Assuming domain_values table has an id column as primary key
            $table->foreign('frequency')->references('id')->on('domain_values');
            $table->string('other_type', 200)->nullable();
            $table->string('employer_name', 200)->nullable();
            $table->string('employer_former_state', 200)->nullable();
            $table->string('employer_phone_number', 20)->nullable();
            $table->date('unemployment_date')->nullable();
            //
            $table->unsignedBigInteger('household_member_id');
            $table->foreign('household_member_id')->references('id')->on('household_members');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('income_deductions');
    }
};
