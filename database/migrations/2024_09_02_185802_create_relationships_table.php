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
        Schema::create('relationships', function (Blueprint $table) {
            $table->id();
            //
            $table->unsignedBigInteger('member_from_id');
            $table->foreign('member_from_id')->references('id')->on('household_members');
            $table->unsignedBigInteger('relationship');
            $table->foreign('relationship')->references('id')->on('domain_values');
            $table->unsignedBigInteger('relationship_detail')->nullable();
            $table->foreign('relationship_detail')->references('id')->on('domain_values');
            $table->unsignedBigInteger('member_to_id');
            $table->foreign('member_to_id')->references('id')->on('household_members');
            //
            $table->unsignedBigInteger('application_id');
            $table->foreign('application_id')->references('id')->on('applications');
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
        Schema::dropIfExists('relationships');
    }
};
