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
        DB::unprepared('CREATE TRIGGER `trigger_cursos_realizados_update` AFTER UPDATE on `cursos_realizados` FOR EACH ROW
        BEGIN
            INSERT INTO data_tracking (`action`, `table`, `data_id`, `old_value`, `new_value`, `modified`, `username` )
               VALUES ("update","cursos_realizados", NEW.id,
               JSON_OBJECT(
                    "codigo_empleado", OLD.codigo_empleado,
                    "codigo_curso", OLD.codigo_curso,
                    "desde", OLD.desde,
                    "hasta", OLD.hasta,
                    "costo", OLD.costo,
                    "duracion", OLD.duracion,
                    "numero_transacion", OLD.numero_transacion,
                    "fecha_registro", OLD.fecha_registro,
                    "orden_merito_curso", OLD.orden_merito_curso,
                    "total_orden_merito_curso", OLD.total_orden_merito_curso,
                    "promedio_curso", OLD.promedio_curso,
                    "pais_curso", OLD.pais_curso,
                    "observacion", OLD.observacion,
                    "usuario", OLD.usuario,
                    "tipo_curso", OLD.tipo_curso,
                    "stastus", OLD.stastus,
                    "unidad", OLD.unidad,
                    "is_deleted", OLD.is_deleted
                ),
                JSON_OBJECT(
                    "codigo_empleado", NEW.codigo_empleado,
                    "codigo_curso", NEW.codigo_curso,
                    "desde", NEW.desde,
                    "hasta", NEW.hasta,
                    "costo", NEW.costo,
                    "duracion", NEW.duracion,
                    "numero_transacion", NEW.numero_transacion,
                    "fecha_registro", NEW.fecha_registro,
                    "orden_merito_curso", NEW.orden_merito_curso,
                    "total_orden_merito_curso", NEW.total_orden_merito_curso,
                    "promedio_curso", NEW.promedio_curso,
                    "pais_curso", NEW.pais_curso,
                    "observacion", NEW.observacion,
                    "usuario", NEW.usuario,
                    "tipo_curso", NEW.tipo_curso,
                    "stastus", NEW.stastus,
                    "unidad", NEW.unidad,
                    "is_deleted", NEW.is_deleted
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
        DB::unprepared('DROP TRIGGER `trigger_cursos_realizados_update`');
    }
};
