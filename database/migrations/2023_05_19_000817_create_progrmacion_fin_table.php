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
        Schema::create('progrmacion_fin', function (Blueprint $table) {
            $table->id();
            $table->string('sistema',255)->nullable();
            $table->string('unidad',255)->nullable();
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
        Schema::dropIfExists('progrmacion_fin');
    }
};
