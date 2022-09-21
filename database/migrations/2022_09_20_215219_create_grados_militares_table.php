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
        Schema::create('grados_militares', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_grado',3)->nullable();
            $table->string('siglas',4)->nullable();
            $table->string('descripcion',70)->nullable();
            $table->integer('años_grado')->nullable();
            $table->string('grado_a_ascender',3)->nullable();
            $table->string('tipo_emp',3)->nullable();
            $table->string('grado_tentativo',3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grados_militares');
    }
};
