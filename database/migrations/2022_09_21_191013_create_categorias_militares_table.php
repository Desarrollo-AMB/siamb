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
        Schema::create('categorias_militares', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('codigo_categoria')->default('00')->nullable();
            $table->string('descripcion',20)->nullable();
            $table->string('tipo_emp',3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorias_militares');
    }
};
