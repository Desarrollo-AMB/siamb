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
        Schema::create('conceptos_pagados', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_empleado',255)->nullable();
            $table->string('codigo_concepto',255)->nullable();
            $table->date('fecha_pago')->nullable();
            $table->string('tipo_pago',255)->nullable();
            $table->float('monto',11,2)->nullable();
            $table->integer('total_horas_jornadas')->nullable();
            $table->float('aporte_patronal',11,2)->nullable();
            $table->date('fecha_pago_efectiva')->nullable();
            $table->string('codigo_cia',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conceptos_pagados');
    }
};
