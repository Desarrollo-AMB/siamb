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
        DB::unprepared('CREATE TRIGGER `trigger_nivel_update` AFTER UPDATE on `nivel` FOR EACH ROW
        BEGIN
           INSERT INTO data_tracking (`action`, `table`,`data_id` , `old_value` , `new_value` , `modified`, `username` )
               VALUES ("update","nivel", NEW.id,
                   JSON_OBJECT(
                        "codigo",OLD.codigo,
                        "descripcion",OLD.descripcion,
                        "nivel_instruccion",OLD.nivel_instruccion,
                        "is_deleted", OLD.is_deleted
                    ),
                    JSON_OBJECT(
                        "codigo",NEW.codigo,
                        "descripcion",NEW.descripcion,
                        "nivel_instruccion",NEW.nivel_instruccion,
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
        DB::unprepared('DROP TRIGGER `trigger_nivel_update`');
    }
};
