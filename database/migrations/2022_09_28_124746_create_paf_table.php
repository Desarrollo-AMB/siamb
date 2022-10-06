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
        Schema::create('paf', function (Blueprint $table) {
            $table->id();
            $table->integer('cedula')->nullable();
            $table->string('grado')->nullable();
            $table->string('nombre1')->nullable();
            $table->string('nombre2')->nullable();
            $table->string('apellido1')->nullable();
            $table->string('apellido2')->nullable();
            $table->string('sexo')->nullable();
            $table->integer('edad')->nullable();
            $table->string('categoria')->nullable();
            $table->string('unidad')->nullable();
            $table->string('tipo_prueba')->nullable();
            $table->string('tipo_caso')->nullable();
            $table->string('presenta_prueba')->nullable();
            $table->string('fecha_pres')->nullable();
            $table->integer('trote')->nullable();
            $table->integer('nota_trote')->nullable();
            $table->integer('flexiones')->nullable();
            $table->integer('nota_flexiones')->nullable();
            $table->integer('abdominales')->nullable();
            $table->integer('nota_abdominales')->nullable();
            $table->integer('natacion')->nullable();
            $table->integer('nota_natacion')->nullable();
            $table->integer('total')->nullable();
            $table->string('apro_repro')->nullable();
            $table->string('casos_especiales')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('nombre1_ev')->nullable();
            $table->integer('is_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paf');
    }
};
