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
        Schema::create('datos_boleta', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_empleado')->unique()->nullable();
            $table->integer('cedula')->nullable();
            $table->string('grado')->nullable();
            $table->string('cargo',300)->nullable();
            $table->date('fecha')->nullable();
            $table->integer('hora_registro')->nullable();
            $table->unsignedInteger('naturaleza')->nullable();
            $table->unsignedInteger('articulo1')->nullable();
            $table->unsignedInteger('aparte1')->nullable();
            $table->string('falta_real')->nullable();
            $table->string('atenuantes')->nullable();
            $table->string('atenuantes2',50)->nullable();
            $table->string('agravantes')->nullable();
            $table->string('agravantes2',50)->nullable();
            $table->integer('demerito')->nullable();
            $table->date('desde')->nullable();
            $table->date('hasta')->nullable();
            $table->integer('dias')->nullable();
            $table->integer('horas')->nullable();
            $table->string('grado_solicitud',30)->nullable();
            $table->string('nombre_solicitud',60)->nullable();
            $table->integer('cedula_solicitud')->nullable();
            $table->string('cargo_solicitud',30)->nullable();
            $table->string('cod_unidad')->nullable();
            $table->string('unidad')->nullable();
            $table->string('localidad',100)->nullable();
            $table->string('img_afectado1',300)->nullable();
            $table->string('img_afectado2',300)->nullable();
            $table->string('img_afectado3',300)->nullable();
            $table->string('img_comando1',300)->nullable();
            $table->string('img_comando2',300)->nullable();
            $table->string('img_comando3',300)->nullable();
            $table->string('img_otros1',300)->nullable();
            $table->string('img_otros2',300)->nullable();
            $table->string('img_otros3',300)->nullable();
            $table->integer('status')->nullable();
            $table->date('fecha_revision')->nullable();
            $table->string('grado_revision',50)->nullable();
            $table->string('nombre_revision',360)->nullable();
            $table->integer('cedula_revision')->nullable();
            $table->string('observacion',360)->nullable();
            $table->string('user',100)->nullable();
            $table->string('user_created',100)->nullable();
            $table->string('user_updated',100)->nullable();
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
        Schema::dropIfExists('datos_boleta');
    }
};
