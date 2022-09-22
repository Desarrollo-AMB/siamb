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
        Schema::create('empleados_grado', function (Blueprint $table) {
            $table->id();
            // $table->string('codigo_empleado')->nullable();
            // $table->foreignId('empleado_id')->constrained('empleados');
            // $table->foreignId('grado_id')->constrained('cargos');
            // $table->foreignId('ubicacion_id')->constrained('ubicacion');
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
        Schema::dropIfExists('empleados_grado');
    }
};
