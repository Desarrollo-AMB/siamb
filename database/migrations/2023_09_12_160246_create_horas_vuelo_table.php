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
        Schema::create('horas_vuelo', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_empleado')->unique()->nullable();
            $table->integer('cedula')->nullable();
            $table->integer('horas_diurna')->nullable();
            $table->integer('horas_nocturna')->nullable();
            $table->integer('total_horas')->nullable();
            $table->integer('aeronave')->nullable();
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
        Schema::dropIfExists('horas_vuelo');
    }
};
