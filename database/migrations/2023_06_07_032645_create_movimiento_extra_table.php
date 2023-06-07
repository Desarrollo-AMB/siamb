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
        Schema::create('movimiento_extra', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_empleado')->nullable();
            $table->date('fecha_movimiento')->nullable();
            $table->string('tipo_movimiento')->nullable();
            $table->string('situacion')->nullable();
            $table->string('observaciones',255)->nullable();
            $table->string('codigo_ubiacion')->nullable();
            $table->string('codigo_grado')->nullable();
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
        Schema::dropIfExists('movimiento_extra');
    }
};
