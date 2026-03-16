<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJudicialMessagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('judicial_messages', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('allow_marketplace_income_data')->default(false)->nullable();
            $table->unsignedBigInteger('years_renewal_of_eligibility');
            $table->boolean('attestation_statement')->default(false)->nullable();
            $table->boolean('marketplace_permission')->default(false)->nullable();
            $table->boolean('penalty_of_perjury_agreement')->default(false)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('full_name', 255)->nullable();
            $table->timestamps(); // Cria as colunas created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judicial_messages');
    }
}
