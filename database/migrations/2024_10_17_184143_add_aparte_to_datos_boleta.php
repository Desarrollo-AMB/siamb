<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *2024
     * @return void
     */
    public function up()
    {
        Schema::table('datos_boleta', function (Blueprint $table) {
            $table->integer('aparte2',)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datos_boleta', function (Blueprint $table) {
            //
        });
    }
};
