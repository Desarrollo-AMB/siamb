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
        Schema::create('jubilados', function (Blueprint $table) {
            $table->id();

            $table->string('codigo_empleado',255)->nullable();
            $table->string('tipo_jubilar',255)->nullable();
            $table->string('nombre_jubi',255)->nullable();
            $table->string('cedula_jubi',255)->nullable();
            $table->date('fecha_ingreso_jubi',255)->nullable();
            $table->string('edad_jubi',255)->nullable();
            $table->date('fecha_jubi',255)->nullable();
            $table->string('observaciones_jubi',255)->nullable();

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
        Schema::dropIfExists('jubilados');
    }
};