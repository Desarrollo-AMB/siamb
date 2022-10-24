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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_empleado')->nullable();
            $table->date('fecha_movimiento')->nullable();
            $table->string('tipo_movimiento',255)->nullable();
            $table->string('ubicacion_anterior',12)->nullable();
            $table->bigInteger('cargo_anterior')->nullable(); 
            $table->string('codigo_ubicacion',12)->nullable();
            $table->bigInteger('codigo_cargo')->nullable(); 
            $table->date('fecha_efectividad')->nullable();
            $table->string('observaciones',255)->nullable();
            $table->date('fecha_promocion')->nullable();
            $table->string('situacion',2)->nullable();
            $table->string('tipo_emp_anterior',3)->nullable();
            $table->string('tipo_emp_nuevo',3)->nullable();
            $table->string('codigo_grado',3)->nullable();
            $table->string('codigo_grado_anterior',3)->nullable();
            $table->string('ubicacion_detallada',12)->nullable();
            $table->string('ubicacion_detallada_anterior',12)->nullable();
            $table->date('fecha_ubicacion')->nullable();
            $table->date('fecha_ubicacion_anterior')->nullable();
            $table->string('resol_ubicacion',255)->nullable();
            $table->string('resol_ubicacion_anterior',255)->nullable();
            $table->date('fecha_cargo')->nullable();
            $table->date('fecha_cargo_anterior')->nullable();
            $table->string('resol_cargo',255)->nullable();
            $table->string('resol_cargo_anterior',255)->nullable();
            $table->string('observaciones_cargo',255)->nullable();
            $table->string('observaciones_cargo_anterior',255)->nullable();
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
        Schema::dropIfExists('movimientos');
    }
};
