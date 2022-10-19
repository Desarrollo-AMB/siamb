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
        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('codigo_cargo')->unique()->nullable();
            $table->string('tipo_cargo',1)->nullable();
            $table->string('nombre_cargo',70)->nullable();
            $table->enum('situacion',['ACTIVO','INACTIVO'])->default('ACTIVO');
            $table->string('codigo_ince',7)->nullable();
            $table->string('codigo_cia',2)->nullable();
            $table->string('codigo_nivel',2)->nullable();
            $table->string('grado',3)->nullable();
            $table->date('fecha_vigen')->nullable();
            $table->integer('puntos')->nullable();
            $table->string('carro',1)->nullable();
            $table->string('estacionamiento',1)->nullable();
            $table->integer('requisitos_cargo')->nullable();
            $table->string('cargos_de_nomina',1)->nullable();
            $table->string('clase_escala',2)->nullable();
            $table->integer('codigo_ocp')->nullable();
            $table->string('codigo_clase1',6)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cargos');
    }
};
