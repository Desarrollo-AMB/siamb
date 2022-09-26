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
        Schema::create('ubicacion_detallada', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_cia',2)->nullable();
            $table->string('codigo_ubicacion',12)->nullable();
            $table->string('descripcion',180)->nullable();
            $table->string('codigo_ubic_nomina',12)->nullable();
            $table->string('observacion',90)->nullable();
            $table->date('fecha_creacion')->nullable();
            $table->date('fecha_eliminacion')->nullable();
            $table->string('tipo_cambio',2)->nullable();
            $table->date('fecha_cambio')->nullable();
            $table->enum('situacion',['ACTIVO','INACTIVO'])->default('ACTIVO');
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
        Schema::dropIfExists('ubicacion_detallada');
    }
};
