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
        DB::unprepared('CREATE TRIGGER `trigger_profesiones_update` AFTER UPDATE on `profesiones` FOR EACH ROW
        BEGIN
           INSERT INTO data_tracking (`action`, `table`,`data_id` , `old_value` , `new_value` , `modified`, `username` )
               VALUES ("update","profesiones", NEW.id,
                   JSON_OBJECT(
                        "codigo_profesion",OLD.codigo_profesion,
                        "descripcion",OLD.descripcion,
                        "is_deleted",OLD.is_deleted
                    ),
                    JSON_OBJECT(
                        "codigo_profesion",NEW.codigo_profesion,
                        "descripcion",NEW.descripcion,
                        "is_deleted",NEW.is_deleted
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
        DB::unprepared('DROP TRIGGER `trigger_profesiones_update`');
    }
};
