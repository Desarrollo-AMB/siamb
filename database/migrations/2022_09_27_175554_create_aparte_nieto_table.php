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
        Schema::create('aparte_nieto', function (Blueprint $table) {
            $table->id('id_aparte_nieto');
            $table->unsignedBigInteger('id_articulo_hijo');
            $table->string('aparte_nieto',600);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aparte_nieto');
    }
};
