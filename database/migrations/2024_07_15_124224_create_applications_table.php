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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
//            $table->string('firstname');
//            $table->string('middlename')->nullable();
//            $table->string('lastname');
//            $table->unsignedBigInteger('suffix')->nullable();
//            $table->foreign('suffix')->references('id')->on('domain_values');
//            $table->date('birthdate');
//            $table->unsignedBigInteger('sex');
//            $table->foreign('sex')->references('id')->on('domain_values');
//            $table->boolean('has_ssn');
//            $table->string('ssn')->nullable();
            $table->boolean('notices_mail_or_email');
            $table->boolean('send_email')->nullable();
            $table->boolean('send_text')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('users');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('users');
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
        Schema::dropIfExists('applications');
    }
};
