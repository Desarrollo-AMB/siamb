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
        Schema::create('parte_aeronave', function (Blueprint $table) {
            $table->id();
            $table->string('unidad', 255)->nullable();
            $table->string('sistema', 255)->nullable();
            $table->string('serial', 255)->nullable();
            $table->string('matricula', 255)->nullable();
            $table->string('situacion', 255)->nullable();
            $table->string('observacion', 255)->nullable();
            $table->date('fecha')->nullable();
            $table->string('codigo_ubicacion')->nullable();
            $table->string('user_created',100)->nullable();
            $table->string('user_updated',100)->nullable();
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
        Schema::dropIfExists('parte_aeronave');
    }
};
