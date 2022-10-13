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
        Schema::create('cursos_realizados', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_empleado',6)->nullable();
            $table->integer('codigo_curso')->nullable();
            $table->date('desde')->nullable();
            $table->date('hasta')->nullable();
            $table->float('costo',11,2)->nullable();
            $table->integer('duracion')->nullable();
            $table->integer('numero_transacion')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->integer('orden_merito_curso')->nullable();
            $table->integer('total_orden_merito_curso')->nullable();
            $table->float('promedio_curso',9,4)->nullable();
            $table->string('pais_curso',4)->nullable();
            $table->string('observacion',180)->nullable();
            $table->string('usuario',30)->nullable();
            $table->string('tipo_curso',1)->nullable();
            $table->string('stastus',12)->nullable();
            $table->string('unidad',12)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos_realizados');
    }
};
