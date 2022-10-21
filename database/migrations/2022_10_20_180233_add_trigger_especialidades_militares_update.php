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
        DB::unprepared('CREATE TRIGGER `trigger_especialidades_militares_update` AFTER UPDATE on `especialidades_militares` FOR EACH ROW
        BEGIN
           INSERT INTO data_tracking (`action`, `table`,`data_id` , `old_value` , `new_value` , `modified`, `username` )
               VALUES ("update","especialidades_militares", NEW.id,
                   JSON_OBJECT(
                    "codigo_especialidad",OLD.codigo_especialidad,
                        "descripcion",OLD.descripcion,
                        "area_desempeno",OLD.area_desempeno,
                        "sub_especialidad",OLD.sub_especialidad,
                        "is_deleted", OLD.is_deleted
                    ),
                    JSON_OBJECT(
                        "codigo_especialidad",NEW.codigo_especialidad,
                        "descripcion",NEW.descripcion,
                        "area_desempeno",NEW.area_desempeno,
                        "sub_especialidad",NEW.sub_especialidad,
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
        DB::unprepared('DROP TRIGGER `trigger_especialidades_militares_update`');
    }
};
