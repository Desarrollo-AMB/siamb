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
        Schema::create('fam0001', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->nullable();
            $table->string('ov_ota_om')->nullable();
            $table->string('componente_organismo')->nullable();
            $table->string('unidad')->nullable();
            $table->string('aeronave_modelo')->nullable();
            $table->string('serial')->nullable();
            $table->string('matricula')->nullable();
            $table->string('base_estacion')->nullable();
            $table->string('jefe_maquina')->nullable();

            $table->integer('total_registro_manual')->nullable();
            $table->integer('total_ind_vuelo')->nullable();
            $table->integer('total_toque_desp')->nullable();
            $table->integer('total_low_go')->nullable();
            $table->integer('total_aterriz')->nullable();
            $table->integer('total_ciclos_tren')->nullable();
            $table->integer('total_consumibles')->nullable();

            $table->string('completado')->nullable();
            
            $table->integer('user_id')->unsigned()->nullable();
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
        Schema::dropIfExists('fam0001');
    }
};
