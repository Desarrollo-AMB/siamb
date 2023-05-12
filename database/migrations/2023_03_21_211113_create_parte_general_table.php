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
        Schema::create('parte_general', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_empleado',255)->nullable();
            $table->date('fecha')->nullable();
            $table->string('codigo_categoria')->nullable();
            $table->string('codigo_grado')->nullable();
            $table->string('codigo_ubicacion',255)->nullable();
            $table->string('situacion',255)->nullable();
            $table->string('observacion',255)->nullable();
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
        Schema::dropIfExists('parte_general');
    }
};
