<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::statement('ALTER TABLE addresses MODIFY street_address VARCHAR(255) NULL');
        DB::statement('ALTER TABLE addresses MODIFY city VARCHAR(255) NULL');
        DB::statement('ALTER TABLE addresses MODIFY county VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
