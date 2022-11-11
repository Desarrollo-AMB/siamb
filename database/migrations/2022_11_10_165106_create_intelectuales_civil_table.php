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
        Schema::create('intelectuales_civil', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_empleado',255)->nullable();
            $table->date('fecha_evaluacion',255)->nullable();
            $table->string('cedula_evaluador',255)->nullable();
            $table->string('nombre_evaluador',255)->nullable();
            $table->string('nota',255)->nullable();
            $table->string('rango_actuacion',255)->nullable();
            $table->string('obervaciones',255)->nullable();
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
        Schema::dropIfExists('intelectuales_civil');
    }
};
