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
        Schema::create('empleados_otro_componente', function (Blueprint $table) {
            $table->id();
            $table->integer('cedula')->nullable();
            $table->string('nombre1',50)->nullable();
            $table->string('nombre2',50)->nullable();
            $table->string('apellido1',50)->nullable();
            $table->string('apellido2',50)->nullable();
            $table->enum('situacion',['ACTIVO','INACTIVO'])->default('ACTIVO');
            $table->string('codigo_ubicacion',12)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados_otro_componente');
    }
};
