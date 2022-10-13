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
        Schema::create('fam0001_a1_mision_totales', function (Blueprint $table) {
            $table->id();
            $table->string('ov_ota_om')->nullable();
            $table->foreignId('fam0001_id')->constrained('fam0001');
            $table->foreignId('fam0001_a1_mision_id')->constrained('fam0001_a1_mision');

            $table->string('total_registro_manual')->nullable();
            $table->string('total_ind_vuelo')->nullable();
            $table->string('total_toque_desp')->nullable();
            $table->string('total_low_go')->nullable();
            $table->string('total_aterriz')->nullable();
            $table->string('total_ciclos_tren')->nullable();
            $table->string('total_consumibles')->nullable();

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
        Schema::dropIfExists('fam0001_a1_mision_totales');
    }
};
