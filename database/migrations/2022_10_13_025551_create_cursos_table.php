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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_curso',6)->nullable();
            $table->string('descripcion_curso',80)->nullable();
            $table->string('dirigido_a',30)->nullable();
            $table->string('nivel',25)->nullable();
            $table->string('tipo_curso',1)->nullable();
            $table->string('dictado_por_el_ince',1)->nullable();
            $table->string('codigo_ince',7)->nullable();
            $table->integer('costo_ince')->nullable();
            $table->integer('total_horas')->nullable();
            $table->integer('cupo')->nullable();
            $table->string('es_idioma',1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos');
    }
};
