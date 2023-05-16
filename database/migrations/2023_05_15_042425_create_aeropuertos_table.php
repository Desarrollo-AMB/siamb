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
        Schema::create('aeropuertos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_icao', 10);
            $table->string('tipo', 15);
            $table->string('nombre', 100);
            $table->double('latitude_deg');
            $table->double('longitude_deg');
            $table->integer('elevacion_ft');
            $table->string('continente', 10);
            $table->string('iso_pais', 10);
            $table->string('iso_region', 10);
            $table->string('municipio', 50);
            $table->string('servicio_programado', 50);
            $table->string('codigo_gps', 6);
            $table->string('codigo_iata', 6);
            $table->string('codigo_local', 6);
            $table->string('home_link', 100);
            $table->string('wikipedia_link', 100);
            $table->string('keywords', 50);
            $table->timestamps();
            
            $table->index('codigo_icao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aeropuertos');
    }
};
