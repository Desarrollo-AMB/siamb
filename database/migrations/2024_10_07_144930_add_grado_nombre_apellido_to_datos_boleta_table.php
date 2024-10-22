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
        Schema::table('datos_boleta', function (Blueprint $table) {
            $table->string('grado_r')->nullable();
            $table->string('nombre_r')->nullable();
            $table->string('apellido_r')->nullable();
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
        });
    }
};