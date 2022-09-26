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
        Schema::create('nomina', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_empleado')->nullable();
            $table->integer('cedula')->nullable();
            $table->string('nombre1',50)->nullable();
            $table->string('nombre2',50)->nullable();
            $table->string('apellido1',50)->nullable();
            $table->string('apellido2',50)->nullable();
            $table->string('codigo_cia',2)->nullable();
            $table->string('codigo_ubicacion',12)->nullable();
            $table->string('codigo_cargo',7)->nullable();
            $table->string('cargo_real',255)->nullable();
            $table->string('tipo_emp',3)->nullable();
            $table->integer('horas_diarias')->nullable();
            $table->string('tipo_ingreso',4)->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->string('forma_pago',2)->nullable();
            $table->string('codigo_banco',3)->nullable();
            $table->string('tipo_cuenta',1)->nullable();
            $table->string('nro_cuenta',20)->nullable();
            $table->string('situacion',1)->nullable();
            $table->float('porcentaje_retencion_islr',7,4)->nullable();
            $table->float('sueldo',11,2)->nullable();
            $table->string('pool',1)->nullable();
            $table->float('apartado_intereses',12,2)->nullable();
            $table->float('apartado_prestaciones',12,2)->nullable();
            $table->integer('supervisor')->nullable();
            $table->string('tiene_beca',1)->nullable();
            $table->float('monto_bono_salario',11,2)->nullable();
            $table->string('justificacion',70)->nullable();
            $table->integer('autorizado_por')->nullable();
            $table->float('porcentaje_ahorro',5,4)->nullable();
            $table->string('paga_sso',1)->nullable();
            $table->string('cargo_tabulador',7)->nullable();
            $table->string('unidad_horas_diarias',3)->nullable();
            $table->date('fecha_ingreso_anterior')->nullable();
            $table->integer('anos_servicio')->nullable();
            $table->integer('mes_servicio')->nullable();
            $table->integer('dias_servicio')->nullable();
            $table->integer('anos_banco')->nullable();
            $table->string('mes_banco',2)->nullable();
            $table->integer('dias_banco')->nullable();
            $table->date('fecha_disfrute')->nullable();
            $table->string('turno',3)->nullable();
            $table->string('tipo_refa',1)->nullable();
            $table->string('intereses_prestac',1)->nullable();
            $table->string('intereses_ahorros',1)->nullable();
            $table->string('montepio',1)->nullable();
            $table->float('subsidio_empresarial',11,2)->nullable();
            $table->string('pago_retroactivo',1)->nullable();
            $table->string('codigo_localidad',12)->nullable();
            $table->integer('codigo_nomina')->nullable();
            $table->string('codigo_caja',2)->nullable();
            $table->string('codigo_sindicato',3)->nullable();
            $table->string('codigo_pptrio',6)->nullable();
            $table->date('fecha_ingreso_caja')->nullable();
            $table->string('fecha_egreso_caja',40)->nullable();
            $table->string('codigo_programa',2)->nullable();
            $table->string('ano_alterno',2)->nullable();
            $table->string('mes_alterno',2)->nullable();
            $table->string('dia_alterno',2)->nullable();
            $table->date('fecha_ingreso_adm')->nullable();
            $table->float('nuevo_sueldo',11,2)->nullable();
            $table->float('nueva_compensacion',11,2)->nullable();
            $table->string('certificado_carrera',8)->nullable();
            $table->date('fecha_solic_certif')->nullable();
            $table->string('grado_militar',3)->nullable();
            $table->string('cambio_dollar',1)->nullable();
            $table->string('sin_desc_alimentacion',1)->nullable();
            $table->string('cod_clasifaereo',3)->nullable();
            $table->integer('cod_rac')->nullable();
            $table->string('cod_ubicacion_detallada',12)->nullable();
            $table->string('nro_resolucion_cargo',15)->nullable();
            $table->string('nro_resolucion_ubicacion',15)->nullable();
            $table->date('fecha_inic_cargo')->nullable();
            $table->date('fecha_inic_ubicacion')->nullable();
            $table->string('observacion_cargo',180)->nullable();
            $table->date('fecha_reincorporacion')->nullable();
            $table->string('codigo_reincorporacion',2)->nullable();
            $table->string('grado_tentativo',3)->nullable();
            $table->string('codigo_clase',3)->nullable();
            $table->string('categoria_clas',14)->nullable();
            $table->string('nivel_escala',4)->nullable();
            $table->string('codigo_clase1',3)->nullable();
            $table->string('observaciones',255)->nullable();
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
        Schema::dropIfExists('nomina');
    }
};
