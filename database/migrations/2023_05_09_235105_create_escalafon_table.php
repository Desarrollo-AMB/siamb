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
        Schema::create('escalafon', function (Blueprint $table) {
            $table->id();
            $table->integer('cedula');
            $table->string('nombre1',50);
            $table->string('nombre2',50)->nullable();
            $table->string('apellido1',50);
            $table->string('apellido2',50)->nullable();
            $table->date('fecha_nacim')->nullable();
            $table->string('sexo')->nullable();
            $table->string('categoria')->nullable();
            $table->string('grado_militar')->nullable();
            $table->integer('orden_merito')->nullable();
            $table->integer('total_merito')->nullable();
            $table->date('graduacion')->nullable();
            $table->date('ultimo_ascenso')->nullable();
            $table->date('retiro')->nullable();
            $table->string('especialidad1',6)->nullable();
            $table->string('especialidad2',6)->nullable();
            $table->string('ubicacion',90)->nullable();
            $table->string('cargo',90)->nullable();
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
        Schema::dropIfExists('escalafon');
    }
};
