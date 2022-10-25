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
        DB::unprepared('CREATE TRIGGER `trigger_cursos_realizados_insert` AFTER INSERT ON `cursos_realizados` FOR EACH ROW
        BEGIN
            INSERT INTO data_tracking (`action`, `table`,`data_id` , `old_value` , `new_value` , `modified`, `username` )
                VALUES ("insert","cursos_realizados", NEW.id, null,
                    JSON_OBJECT(
                        "codigo_empleado", NEW.codigo_empleado,
                        "codigo_curso", NEW.codigo_curso,
                        "desde", NEW.desde,
                        "hasta", NEW.hasta,
                        "fecha_registro", NEW.fecha_registro,
                        "orden_merito_curso", NEW.orden_merito_curso,
                        "total_orden_merito_curso", NEW.total_orden_merito_curso,
                        "usuario", NEW.usuario,
                        "unidad", NEW.unidad,
                        "pais_curso", NEW.pais_curso,
                        "tipo_curso", NEW.tipo_curso
                    ),
                    NOW(),
                    NEW.user_created
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
        DB::unprepared('DROP TRIGGER `trigger_cursos_realizados_insert`');
    }
};
