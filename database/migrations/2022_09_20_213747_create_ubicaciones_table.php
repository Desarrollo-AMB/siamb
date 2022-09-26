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
        Schema::create('ubicaciones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_cia',2)->nullable();
            $table->string('codigo_ubicacion',12)->unique()->nullable();
            $table->string('descripcion',90)->nullable();
            $table->string('tipo_unidad_organizacional',30)->nullable();
            $table->string('ubicacion_contable',10)->nullable();
            $table->string('adscrita_a',12)->nullable();
            $table->date('fecha_creacion')->nullable();
            $table->date('fecha_eliminacion')->nullable();
            $table->string('regimen',1)->nullable();
            $table->string('codigo_contrato',2)->nullable();
            $table->string('ubicacion_fisica',50)->nullable();
            $table->string('ruta',4)->nullable();
            $table->string('estacion',8)->nullable();
            $table->string('sso',12)->nullable();
            $table->string('codigo_estado',2)->nullable();
            $table->string('ubicaciones_de_nomina',1)->nullable();
            $table->string('cod_programa',2)->nullable();
            $table->string('subprg_activ',4)->nullable();
            $table->string('tipo_unidad',1)->nullable();
            $table->string('tipo_unidad_md',1)->nullable();
            $table->string('guarnicion',2)->nullable();
            $table->string('base',1)->nullable();
            $table->string('municipio',40)->nullable();
            $table->string('ciudad',40)->nullable();
            $table->string('redi',40)->nullable();
            $table->string('zodi',40)->nullable();
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
        Schema::dropIfExists('ubicaciones');
    }
};
