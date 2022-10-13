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
        Schema::create('estudios_realizados', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_empleado')->nullable();
            $table->string('profresion',4)->nullable();
            $table->integer('ultimo_año_cursado')->nullable();
            $table->string('resultado',2)->nullable();
            $table->string('universidad',4)->nullable();
            $table->date('desde')->nullable();
            $table->date('hasta')->nullable();
            $table->string('nivel',2)->nullable();
            $table->integer('numero_transaccion')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->string('usuario',30)->nullable();
            $table->string('codigo_estado',2)->nullable();
            $table->string('ciudad',20)->nullable();
            $table->integer('año_graduacion')->nullable();
            $table->string('pais',4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudios_realizados');
    }
};
