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
        Schema::create('fam0001_a3_carga', function (Blueprint $table) {
            $table->id();

            $table->string('ov_ota_om')->nullable();
            $table->foreignId('fam0001_id')->constrained('fam0001');
            $table->foreignId('fam0001_a1_mision_id')->constrained('fam0001_a1_mision');
            
            $table->string('n_vuelo')->nullable();
            $table->string('apoyo_carga')->nullable();

            $table->integer('pesocargaTotal')->nullable();
            $table->integer('volCargaTotal')->nullable();

            $table->integer('seca')->nullable();
            $table->integer('liquida')->nullable();
            $table->integer('comb')->nullable();
            $table->integer('ammto')->nullable();
            $table->integer('tox_pel')->nullable();

            $table->integer('mil')->nullable();
            $table->integer('gob')->nullable();
            $table->integer('no_gob')->nullable();
            $table->integer('civil')->nullable();

            $table->integer('cant_animales')->nullable();
            $table->integer('carga')->nullable();
            $table->integer('pers')->nullable();

            $table->string('completado')->nullable();

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
        Schema::dropIfExists('fam0001_a3_carga');
    }
};
