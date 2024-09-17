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
        Schema::create('personaldres', function (Blueprint $table) {
            $table->id();
            $table->string('n_reporte')->nullable();
            $table->string('especialidad')->nullable();
            $table->string('sexo')->nullable();
            $table->string('grado')->nullable();
            $table->string('categoria')->nullable();
            $table->string('nombre1')->nullable();
            $table->string('nombre2')->nullable();
            $table->string('apellido1')->nullable();
            $table->string('apellido2')->nullable();
            $table->string('cedula')->nullable();
            $table->string('relacion')->nullable();
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
        Schema::dropIfExists('personaldres');
    }
};
