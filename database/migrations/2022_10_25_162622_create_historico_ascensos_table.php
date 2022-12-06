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
        Schema::create('historico_ascensos', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_empleado')->nullable();
            $table->string('codigo_grado',3)->nullable();
            $table->date('fecha_ascenso')->nullable();
            $table->integer('orden_merito_ascenso')->nullable();
            $table->integer('total_orden_merito_ascenso')->nullable();
            $table->integer('orden_merito_junta')->nullable();
            $table->integer('total_orden_merito_junta')->nullable();
            $table->string('resolucion',12)->nullable();
            $table->string('años_reconocidos',2)->nullable();
            $table->string('resol_años_reconoc',25)->nullable();
            $table->date('fec_resol_años_reconc')->nullable();
            $table->string('justificacion',200)->nullable();
            $table->string('grado_reconocido',3)->nullable();
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
        Schema::dropIfExists('historico_ascensos');
    }
};
