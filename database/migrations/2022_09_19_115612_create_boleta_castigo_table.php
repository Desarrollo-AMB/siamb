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
        Schema::create('boleta_castigo', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_empleado')->nullable();
            $table->string('codigo_cia',2)->nullable();
            $table->integer('numero_boleta')->nullable();
            $table->date('fecha_boleta')->nullable();
            $table->string('codigo_ubicacion',12)->nullable();
            $table->string('dsc_ubicaciones',180)->nullable(); //No deberia utilizarse por la relacion con Ubicacion
            $table->string('codigo_grado',6)->nullable();
            $table->integer('codigo_naturaleza')->nullable();
            $table->string('articulo',4)->nullable();
            $table->string('aparte',4)->nullable();
            $table->string('fue_informado',1)->nullable();
            $table->text('falta_real')->nullable();
            $table->date('desde')->nullable();
            $table->date('hasta')->nullable();
            $table->integer('codigo_empleado_impuesto')->nullable();
            $table->string('apellido_nombre_impuesto',240)->nullable(); //No deberia utilizarse por la relacion con Empleado Impone Boleta
            $table->string('status',4)->nullable();
            $table->string('user_registro',20)->nullable();
            $table->string('codigo_grado_impuesto',3)->nullable(); //No deberia utilizarse por la relacion con Empleado Impone Boleta
            $table->integer('cedula_impuesto')->nullable(); //No deberia utilizarse por la relacion con Empleado Impone Boleta
            $table->integer('numero_boleta_seid')->nullable();
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
        Schema::dropIfExists('boleta_castigo');
    }
};
