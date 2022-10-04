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
        Schema::create('intelectuales', function (Blueprint $table) {
            $table->id();
            $table->integer('cedula')->nullable();
            $table->string('grado_militar',250)->nullable();
            $table->string('ubicacion_detallada')->nullable();
            $table->string('cargo')->nullable();
            $table->integer('caracter')->default(0);
            $table->integer('espirutud')->default(0);
            $table->integer('apego')->default(0);
            $table->integer('discrecion')->default(0);
            $table->integer('comportamiento')->default(0);
            $table->integer('analistica')->default(0);
            $table->integer('actualizacion')->default(0);
            $table->integer('iniciativa')->default(0);
            $table->integer('ensenanza')->default(0);
            $table->integer('servicio')->default(0);
            $table->integer('liderazgo')->default(0);
            $table->integer('planificacion')->default(0);
            $table->integer('administracion')->default(0);
            $table->integer('recursor')->default(0);
            $table->integer('trabajo')->default(0);
            $table->integer('cantidad_trabajo')->default(0);
            $table->integer('decisiones')->default(0);
            $table->integer('seguridad')->default(0);
            $table->integer('rendimiento')->default(0);
            $table->integer('cultura_p')->default(0);
            $table->integer('cultura_g')->default(0);
            $table->integer('expresion')->default(0);
            $table->integer('economico')->default(0);
            $table->string('total_nota',4)->nullable();
            $table->string('notatotal',16)->nullable();
            $table->date('fechaI')->nullable();
            $table->date('fechaF')->nullable();
            $table->string('cedula_e')->nullable();
            $table->string('grado_e')->nullable();
            $table->string('nombre_e')->nullable();
            $table->string('apellido_e')->nullable();
            $table->string('cargo_e')->nullable();
            $table->string('cedula_s')->nullable();
            $table->string('grado_s')->nullable();
            $table->string('nombre_s')->nullable();
            $table->string('apellido_s')->nullable();
            $table->string('cargo_s')->nullable();
            $table->date('fechaE')->nullable();
            $table->integer('is_delected')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intelectuales');
    }
};
