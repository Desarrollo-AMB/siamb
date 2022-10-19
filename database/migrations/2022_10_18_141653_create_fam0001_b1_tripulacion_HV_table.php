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
        Schema::create('fam0001_b1_tripulacion_HV', function (Blueprint $table) {
            $table->id();
            $table->string('ov_ota_om')->nullable();
            $table->foreignId('fam0001_id')->constrained('fam0001');
            $table->foreignId('fam0001_a1_mision_id')->constrained('fam0001_a1_mision');

            $table->string('COD')->nullable();
            $table->string('HV')->nullable();
            $table->string('TIP_ATERRIZAJE')->nullable();
            $table->string('CANTIDAD')->nullable();

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
        Schema::dropIfExists('fam0001_b1_tripulacion_HV');
    }
};
