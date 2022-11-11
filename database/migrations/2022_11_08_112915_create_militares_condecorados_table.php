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
        Schema::create('militares_condecorados', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('codigo_empleado');
            $table->string('codigo_condecoracion',4)->nullable();
            $table->string('resuelto',255)->nullable();
            $table->date('fecha_condecoracion')->nullable();
            $table->string('codigo_grado',4)->nullable();
            $table->string('usuario',255)->nullable();
            $table->date('fecha_registro')->nullable();
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
        Schema::dropIfExists('militares_condecorados');
    }
};
