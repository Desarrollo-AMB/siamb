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
        Schema::create('fam0001_a1_mision', function (Blueprint $table) {
            $table->id();

            $table->string('ov_ota_om')->nullable();
            $table->foreignId('fam0001_id')->constrained('fam0001');

            $table->integer('vuelo')->nullable();

            $table->string('ordenada_por')->nullable();
            $table->string('en_apoyo')->nullable();
            $table->string('codigo')->nullable();
            $table->string('ruta_desde')->nullable();
            $table->string('ruta_hasta')->nullable();
            $table->string('encend')->nullable();
            $table->string('despeg')->nullable();
            $table->string('aterriz')->nullable();
            $table->string('apag')->nullable();
            $table->string('registro_manual')->nullable();
            $table->string('horometro')->nullable();
            $table->string('ind_vuelo')->nullable();
            $table->string('toque_desp')->nullable();
            $table->string('low_go')->nullable();
            $table->string('ciclos_tren')->nullable();
            $table->string('en_apoyo_A2')->nullable();
            $table->string('descripcion_A2')->nullable();

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
        Schema::dropIfExists('fam0001_a1_mision');
    }
};
