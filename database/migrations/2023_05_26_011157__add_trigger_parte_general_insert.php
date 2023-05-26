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

        DB::unprepared('CREATE TRIGGER `trigger_parte_general_insert` AFTER INSERT ON `parte_general` FOR EACH ROW
        BEGIN
           INSERT INTO data_tracking (`action`, `table`,`data_id` , `old_value` , `new_value` , `modified`, `username` )
               VALUES ("insert","parte_general", NEW.id, null,
                   JSON_OBJECT(
                    "codigo_empleado",NEW.codigo_empleado,
                    "fecha",NEW.fecha,
                    "codigo_categoria",NEW.codigo_categoria,
                    "grado_militar",NEW.grado_militar,
                    "codigo_ubicacion",NEW.codigo_ubicacion,
                    "situacion",NEW.situacion,
                    "observacion",NEW.observacion
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
        DB::unprepared('DROP TRIGGER `trigger_parte_general_insert`');
    }
};
