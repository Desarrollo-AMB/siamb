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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_empleado')->unique()->nullable();
            $table->integer('cedula')->nullable();
            $table->string('nombre1',50)->nullable();
            $table->string('nombre2',50)->nullable();
            $table->string('apellido1',50)->nullable();
            $table->string('apellido2',50)->nullable();
            $table->string('situacion',1)->nullable();
            $table->date('fecha_nacim')->nullable();
            $table->string('sexo',1)->nullable();
            $table->string('edo_civil',2)->nullable();
            $table->string('telefono',25)->nullable();
            $table->string('nivel_instruccion',1)->nullable();
            $table->string('estudia',1)->nullable();
            $table->string('profesion',4)->nullable();
            $table->string('nacionalidad',1)->nullable();
            $table->string('direccion',180)->nullable();
            $table->string('ciudad',20)->nullable();
            $table->string('estado',2)->nullable();
            $table->string('cod_postal',6)->nullable();
            $table->integer('peso')->nullable();
            $table->integer('talla_pant')->nullable();
            $table->string('talla_chaqueta',2)->nullable();
            $table->string('talla_camisa',2)->nullable();
            $table->integer('talla_falda')->nullable();
            $table->integer('numero_calzado')->nullable();
            $table->string('zur_der_amb',1)->nullable();
            $table->string('act_culturales',70)->nullable();
            $table->string('cta_ahorro_hab',15)->nullable();
            $table->string('otro_telefono',15)->nullable();
            $table->float('estatura',5,2)->nullable();
            $table->string('color',8)->nullable();
            $table->string('cabellos',8)->nullable();
            $table->string('ojos',8)->nullable();
            $table->string('grupo_sanguineo',6)->nullable();
            $table->string('cara',8)->nullable();
            $table->string('frente',8)->nullable();
            $table->string('cejas',8)->nullable();
            $table->string('nariz',8)->nullable();
            $table->string('boca',8)->nullable();
            $table->string('labios',8)->nullable();
            $table->string('barba',8)->nullable();
            $table->string('contextura',8)->nullable();
            $table->string('religion',12)->nullable();
            $table->string('correo',50)->nullable();
            $table->string('telefono_cel',15)->nullable();
            $table->string('telefono_ofi',15)->nullable();
            $table->string('persona_contacto',60)->nullable();
            $table->string('talla_gorra',3)->nullable();
            $table->string('ubicacion_admpub',20)->nullable();
            $table->string('discapacidad',100)->nullable();
            $table->string('tipo_discapacidad',100)->nullable();
            $table->string('alergias',100)->nullable();
            $table->string('seid_foto_militar',255)->nullable();
            $table->string('seid_grado_militar',4)->nullable();
            $table->string('seid_especialidad',255)->nullable();
            $table->string('seid_categoria1',255)->nullable();
            $table->date('seid_ultimo_ascenso')->nullable();
            $table->date('seid_fecha_presentacion')->nullable();
            $table->string('seid_comandante_unidad',255)->nullable();
            $table->string('seid_evaluado',4)->nullable();
            $table->string('seid_motivo_evaluacion',255)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('empleados');
    }
};
