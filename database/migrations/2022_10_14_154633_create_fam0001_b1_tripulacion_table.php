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
        Schema::create('fam0001_b1_tripulacion', function (Blueprint $table) {
            $table->id();
            $table->string('ov_ota_om')->nullable();
            $table->foreignId('fam0001_id')->constrained('fam0001');
            $table->foreignId('fam0001_a1_mision_id')->constrained('fam0001_a1_mision');
            
            $table->string('v_trip')->nullable();
            $table->string('grado_nombre_id')->nullable();
            $table->string('grado_nombre_data')->nullable();

            $table->string('cedula')->nullable();

            $table->string('funcion')->nullable();
            $table->string('codigo_funcion')->nullable();
            
            $table->string('tipo_despegue')->nullable();

            $table->string('COD')->nullable();
            $table->string('hv')->nullable();

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
        Schema::dropIfExists('fam0001_b1_tripulacion');
    }
};
