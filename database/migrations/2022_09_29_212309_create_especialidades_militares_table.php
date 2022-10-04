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
        Schema::create('especialidades_militares', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_especialidad',6)->unique()->nullable();
            $table->string('descripcion',80)->nullable();
            $table->string('area_desempeno',2)->nullable();
            $table->string('sub_especialidad',3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('especialidades_militares');
    }
};
