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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street_address');
            $table->string('apte_ste')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zipcode');
            $table->string('county');
            $table->boolean('mailing');
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
        Schema::dropIfExists('addresses');
    }
};
