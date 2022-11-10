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
        Schema::create('datos_laborales', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_empleado')->nullable();
            $table->string('situacion',1)->nullable();
            $table->string('codigo_ubicacion',12)->nullable();
            $table->string('codigo_ubicacion_detallada',12)->nullable();
            $table->string('codigo_cargo',7)->nullable();
            $table->string('tipo_emp',3)->nullable();
            $table->string('grado_militar',3)->nullable();
            $table->string('nro_resolucion_cargo',15)->nullable();
            $table->string('nro_resolucion_ubicacion',15)->nullable();
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
        Schema::dropIfExists('datos_laborales');
    }
};
