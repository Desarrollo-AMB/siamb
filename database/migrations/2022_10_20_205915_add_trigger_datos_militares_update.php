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
        DB::unprepared('CREATE TRIGGER `trigger_datos_militares_update` AFTER UPDATE on `datos_militares` FOR EACH ROW
        BEGIN
            INSERT INTO data_tracking (`action`, `table`, `data_id`, `old_value`, `new_value`, `modified`, `username` )
               VALUES ("update","datos_militares", NEW.id,
               JSON_OBJECT(
                    "codigo_empleado", OLD.codigo_empleado,
                    "codigo_categoria", OLD.codigo_categoria,
                    "codigo_promocion", OLD.codigo_promocion,
                    "orden_merito", OLD.orden_merito,
                    "total_orden_merito", OLD.total_orden_merito,
                    "cursos", OLD.cursos,
                    "codigo_pais", OLD.codigo_pais,
                    "fecha_ultimo_ascenso", OLD.fecha_ultimo_ascenso,
                    "fecha_retiro", OLD.fecha_retiro,
                    "codigo_especialidad1", OLD.codigo_especialidad1,
                    "codigo_especialidad2", OLD.codigo_especialidad2,
                    "fecha_graduacion", OLD.fecha_graduacion,
                    "codigo_condicion", OLD.codigo_condicion,
                    "ano_cursados", OLD.ano_cursados,
                    "contingente", OLD.contingente,
                    "observaciones", OLD.observaciones,
                    "fecha_tentativa", OLD.fecha_tentativa,
                    "codigo_discracate", OLD.codigo_discracate
                ),
                JSON_OBJECT(
                    "codigo_empleado", NEW.codigo_empleado,
                    "codigo_categoria", NEW.codigo_categoria,
                    "codigo_promocion", NEW.codigo_promocion,
                    "orden_merito", NEW.orden_merito,
                    "total_orden_merito", NEW.total_orden_merito,
                    "cursos", NEW.cursos,
                    "codigo_pais", NEW.codigo_pais,
                    "fecha_ultimo_ascenso", NEW.fecha_ultimo_ascenso,
                    "fecha_retiro", NEW.fecha_retiro,
                    "codigo_especialidad1", NEW.codigo_especialidad1,
                    "codigo_especialidad2", NEW.codigo_especialidad2,
                    "fecha_graduacion", NEW.fecha_graduacion,
                    "codigo_condicion", NEW.codigo_condicion,
                    "ano_cursados", NEW.ano_cursados,
                    "contingente", NEW.contingente,
                    "observaciones", NEW.observaciones,
                    "fecha_tentativa", NEW.fecha_tentativa,
                    "codigo_discracate", NEW.codigo_discracate
                ),
                NOW(),
                NEW.user_updated
            );
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `trigger_datos_militares_update`');
    }
};
