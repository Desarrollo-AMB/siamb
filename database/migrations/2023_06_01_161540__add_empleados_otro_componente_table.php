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
        Schema::table('empleados_otro_componente', function (Blueprint $table) {
           $table->string('codigo_empleado',255)->nullable();
           $table->string('tipo_emp')->nullable();
           $table->string('nacionalidad')->nullable();
           $table->string('direccion',255)->nullable();
           $table->string('ciudad',255)->nullable();
           $table->string('estado')->nullable();
           $table->string('zurd_der_amb')->nullable();
           $table->date('fecha_nacim')->nullable();
           $table->string('sexo')->nullable();
           $table->string('estado_civil',2)->nullable();
           $table->string('telefono',255)->nullable();
           $table->string('telefono_casa',100)->nullable();
           $table->string('correo',255)->nullable();
           $table->string('codigo_grado',3)->nullable();
           $table->string('contacto_emergencia',255)->nullable();
           $table->string('telefono_emergencia')->nullable();
           $table->date('fecha_ingreso')->nullable();
           $table->string('componente',2)->nullable();
           $table->string('foto',255)->nullable();
            $table->string('user_created',100);
            $table->string('user_updated',100);
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
        //
    }
};
