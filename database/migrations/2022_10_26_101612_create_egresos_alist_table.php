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
        Schema::create('egresos_alist', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_empleado')->nullable();
            $table->string('contingente',255)->nullable();
            $table->date('fecha_egreso')->nullable();
            $table->string('resolucion',255)->nullable();
            $table->string('username',255)->nullable();
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
        Schema::dropIfExists('egresos_alist');
    }
};
