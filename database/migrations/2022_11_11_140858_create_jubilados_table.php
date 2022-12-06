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
            $table->integer('cedula')->nullable();
            $table->string('nombre1',50)->nullable();
            $table->string('nombre2',50)->nullable();
            $table->string('apellido1',50)->nullable();
            $table->string('apellido2',50)->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_vigencia')->nullable();
            $table->date('fecha_jubilacion')->nullable();
            $table->string('tipo_emp',4)->nullable();
            $table->string('observaciones',255)->nullable();
            $table->string('usuario',255)->nullable();
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