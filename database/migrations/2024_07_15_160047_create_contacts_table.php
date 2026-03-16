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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('extension')->nullable();
            $table->unsignedBigInteger('type');
            $table->foreign('type')->references('id')->on('domain_values');
            $table->string('second_phone')->nullable();
            $table->string('second_extension')->nullable();
            $table->unsignedBigInteger('second_type')->nullable();
            $table->foreign('second_type')->references('id')->on('domain_values');
            $table->unsignedBigInteger('written_lang');
            $table->foreign('written_lang')->references('id')->on('domain_values');
            $table->unsignedBigInteger('spoken_lang');
            $table->foreign('spoken_lang')->references('id')->on('domain_values');
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
        Schema::dropIfExists('contacts');
    }
};
