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
        Schema::create('familiares', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_empleado')->nullable();
            $table->integer('numero_familiar')->nullable();
            $table->string('cedula_familiar', 255)->nullable();
            $table->string('nombre1', 18)->nullable();
            $table->string('nombre2', 18)->nullable();
            $table->string('apellido1', 18)->nullable();
            $table->string('apellido2', 18)->nullable();
            $table->string('parentesco', 2)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('sexo', 1)->nullable();
            $table->string('edo_civil', 2)->nullable();
            $table->string('nivel_instruccion', 1)->nullable();
            $table->string('pendiente', 1)->nullable();
            $table->string('estudia', 1)->nullable();
            $table->string('tiene_beca', 1)->nullable();
            $table->string('status', 1)->nullable();
            $table->date('fecha_registro')->nullable();
            $table->string('especial', 255)->nullable();
            $table->string('hcm', 1)->nullable();
            $table->string('asistencia_medica', 1)->nullable();
            $table->date('fecha_fallecimiento')->nullable();
            $table->string('nacionalidad', 1)->nullable();
            $table->string('telefono_oficina', 18)->nullable();
            $table->string('telefono_movil', 18)->nullable();
            $table->string('correo_electronico', 40)->nullable();
            $table->string('profesion', 255)->nullable();
            $table->string('vive', 2)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('telefono_habitacion', 18)->nullable();
            $table->date('fecha_salida_f')->nullable();
            $table->date('fecha_boda')->nullable();
            $table->date('fecha_ingreso_f')->nullable();
            $table->string('discapacidad', 255)->nullable();
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
        Schema::dropIfExists('familiares');
    }
};
