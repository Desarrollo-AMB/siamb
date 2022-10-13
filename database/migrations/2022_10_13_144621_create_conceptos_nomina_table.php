<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function PHPSTORM_META\map;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptos_nomina', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_concepto',3)->nullable();
            $table->string('descripcion',37)->nullable();
            $table->string('tipo',1)->nullable();
            $table->string('califica_arc',1)->nullable();
            $table->integer('orden_impresion')->nullable();
            $table->string('estado',1)->nullable();
            $table->string('formato_pago',1)->nullable();
            $table->string('factor',1)->nullable();
            $table->string('afecta_fide',1)->nullable();
            $table->string('solo_calculo',1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conceptos_nomina');
    }
};
