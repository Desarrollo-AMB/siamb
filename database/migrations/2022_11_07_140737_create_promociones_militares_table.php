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
        Schema::create('promociones_militares', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_promocion');
            $table->string('descripcion',255);
            $table->integer('codigo_categoria');
            $table->string('ano_promocion',4);
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
        Schema::dropIfExists('promociones_militares');
    }
};
