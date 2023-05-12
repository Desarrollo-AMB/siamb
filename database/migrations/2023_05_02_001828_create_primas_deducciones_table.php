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
        Schema::create('primas_deducciones', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_concepto')->nullable();
            $table->string('descripcion',255)->nullable();
            $table->string('tipo',255)->nullable();
            $table->float('porcentaje',3)->nullable();
            $table->timestamps();//created_at updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('primas_deducciones');
    }
};