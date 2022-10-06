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
        DB::unprepared('CREATE TRIGGER `trigger_datos_boleta_update` AFTER UPDATE ON `datos_boleta`  FOR EACH ROW
        BEGIN
            INSERT INTO data_tracking (`action`, `table`, `data_id`, `old_value`, `new_value`, `modified`,`username` ) 
                VALUES ("update","datos_boleta", NEW.id, 
                    JSON_OBJECT(
                        "status", OLD.status,
                        "fecha_revision", OLD.fecha_revision,
                        "grado_revision", OLD.grado_revision,
                        "nombre_revision", OLD.nombre_revision,
                        "cedula_revision", OLD.cedula_revision,
                        "observacion", OLD.observacion,
                        "demerito", OLD.demerito,
                        "fecha", OLD.fecha,
                        "falta_real", OLD.falta_real,
                        "desde", OLD.desde,
                        "hasta", OLD.hasta
                    ),
                    JSON_OBJECT(
                        "status", NEW.status,
                        "fecha_revision", NEW.fecha_revision,
                        "grado_revision", NEW.grado_revision,
                        "nombre_revision", NEW.nombre_revision,
                        "cedula_revision", NEW.cedula_revision,
                        "observacion", NEW.observacion,
                        "demerito", NEW.demerito,
                        "fecha", NEW.fecha,
                        "falta_real", NEW.falta_real,
                        "desde", NEW.desde,
                        "hasta", NEW.hasta
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
        DB::unprepared('DROP TRIGGER `trigger_datos_boleta_update`');
    }
};
