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
        DB::unprepared('CREATE TRIGGER `trigger_estudios_realizados_insert` AFTER INSERT ON `estudios_realizados` FOR EACH ROW
        BEGIN
            INSERT INTO data_tracking (`action`, `table`,`data_id` , `old_value` , `new_value` , `modified`, `username` )
                VALUES ("insert","estudios_realizados", NEW.id, null,
                    JSON_OBJECT(
                        "codigo_empleado", NEW.codigo_empleado,
                        "profesion", NEW.profesion,
                        "ultimo_año_cursado", NEW.ultimo_año_cursado,
                        "universidad", NEW.universidad,
                        "nivel", NEW.nivel,
                        "fecha_registro", NEW.fecha_registro,
                        "usuario", NEW.usuario,
                        "año_graduacion", NEW.año_graduacion,
                        "pais", NEW.pais
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
        DB::unprepared('DROP TRIGGER `trigger_estudios_realizados_insert`');
    }
};
