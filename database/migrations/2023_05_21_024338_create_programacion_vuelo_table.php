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
        Schema::create('programacion_vuelo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fam0001_id')->constrained('fam0001');
            $table->foreignId('fam0001_a1_mision_id')->constrained('fam0001_a1_mision');
            $table->date('fecha')->nullable();
            $table->string('unidad')->nullable();
            $table->string('sistema_matricula')->nullable();
            $table->string('matriculas_alternas');
            $table->string('ordenada_por')->nullable();
            $table->string('mision_ruta')->nullable();
            $table->string('salida')->nullable();
            $table->string('retorno')->nullable();
            $table->string('militar')->nullable();
            $table->string('civil')->nullable();
            $table->string('carga')->nullable();
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
        Schema::dropIfExists('programacion_vuelo');
    }
};
