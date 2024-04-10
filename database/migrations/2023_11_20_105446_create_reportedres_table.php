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
        Schema::create('reportedres', function (Blueprint $table) {
            $table->id();
            $table->string('n_reporte')->nullable();
            $table->string('jres')->nullable();
            $table->date('fecha_reporte')->nullable();
            $table->string('grupo_fecha')->nullable();
            $table->string('persona_envia')->nullable();
            $table->string('unidad_involucrada')->nullable();
            $table->string('cmdt_unidad')->nullable();
            $table->string('clase_envento')->nullable();
            $table->string('tipo_evento')->nullable();
            $table->string('evento')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('documento')->nullable();
            $table->string('lugar_ocurrencia')->nullable();
            $table->string('fecha_ocurrencia')->nullable();
            $table->string('situacion')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('reportedres');
    }
};
