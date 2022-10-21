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
        DB::unprepared('CREATE TRIGGER `trigger_estudios_realizados_update` AFTER UPDATE on `estudios_realizados` FOR EACH ROW
        BEGIN
            INSERT INTO data_tracking (`action`, `table`, `data_id`, `old_value`, `new_value`, `modified`, `username` )
               VALUES ("update","estudios_realizados", NEW.id,
               JSON_OBJECT(
                    "codigo_empleado", OLD.codigo_empleado,
                    "profesion", OLD.profesion,
                    "ultimo_año_cursado", OLD.ultimo_año_cursado,
                    "resultado", OLD.resultado,
                    "universidad", OLD.universidad,
                    "desde", OLD.desde,
                    "hasta", OLD.hasta,
                    "nivel", OLD.nivel,
                    "numero_transaccion", OLD.numero_transaccion,
                    "fecha_registro", OLD.fecha_registro,
                    "usuario", OLD.usuario,
                    "codigo_estado", OLD.codigo_estado,
                    "ciudad", OLD.ciudad,
                    "año_graduacion", OLD.año_graduacion,
                    "pais", OLD.pais,
                    "is_deleted", OLD.is_deleted
                ),
                JSON_OBJECT(
                    "codigo_empleado", NEW.codigo_empleado,
                    "profesion", NEW.profesion,
                    "ultimo_año_cursado", NEW.ultimo_año_cursado,
                    "resultado", NEW.resultado,
                    "universidad", NEW.universidad,
                    "desde", NEW.desde,
                    "hasta", NEW.hasta,
                    "nivel", NEW.nivel,
                    "numero_transaccion", NEW.numero_transaccion,
                    "fecha_registro", NEW.fecha_registro,
                    "usuario", NEW.usuario,
                    "codigo_estado", NEW.codigo_estado,
                    "ciudad", NEW.ciudad,
                    "año_graduacion", NEW.año_graduacion,
                    "pais", NEW.pais,
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
        DB::unprepared('DROP TRIGGER `trigger_estudios_realizados_update`');
    }
};
