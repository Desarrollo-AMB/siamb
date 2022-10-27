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
        DB::unprepared('CREATE TRIGGER `trigger_universidades_update` AFTER UPDATE on `universidades` FOR EACH ROW
        BEGIN
           INSERT INTO data_tracking (`action`, `table`,`data_id` , `old_value` , `new_value` , `modified`, `username` )
               VALUES ("update","universidades", NEW.id,
                   JSON_OBJECT(
                        "codigo_universidad",OLD.codigo_universidad,
                        "nombre",OLD.nombre,
                        "tipo_universidad",OLD.tipo_universidad,
                        "adscrita_aviacion",OLD.adscrita_aviacion,
                        "is_deleted",OLD.is_deleted
                    ),
                    JSON_OBJECT(
                        "codigo_universidad",NEW.codigo_universidad,
                        "nombre",NEW.nombre,
                        "tipo_universidad",NEW.tipo_universidad,
                        "adscrita_aviacion",NEW.adscrita_aviacion,
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
        DB::unprepared('DROP TRIGGER `trigger_universidades_update`');
    }
};
