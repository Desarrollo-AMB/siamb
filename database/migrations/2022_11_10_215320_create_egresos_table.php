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
        Schema::create('egresos', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_empleado');
            $table->date('fecha_salida')->nullable();
            $table->integer('causa_egreso');
            $table->integer('nro_resuelto')->nullable();
            $table->date('fecha_resuelto')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->string('usuario',255);
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
        Schema::dropIfExists('egresos');
    }
};
