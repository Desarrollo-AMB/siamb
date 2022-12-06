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
        Schema::create('condecoraciones_militares', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_condecoracion',4);
            $table->text('descripcion')->nullable();
            $table->string('codigo_pais',4)->nullable();
            $table->string('tipo_emp',3)->nullable();
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
        Schema::dropIfExists('condecoraciones_militares');
    }
};
