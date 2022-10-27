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
        DB::unprepared('CREATE TRIGGER `trigger_nivel_insert` AFTER INSERT ON `nivel` FOR EACH ROW
        BEGIN
           INSERT INTO data_tracking (`action`, `table`,`data_id` , `old_value` , `new_value` , `modified`, `username` )
               VALUES ("insert","nivel", NEW.id, null,
                   JSON_OBJECT(
                        "codigo",NEW.codigo,
                        "descripcion",NEW.descripcion,
                        "nivel_instruccion",NEW.nivel_instruccion
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
        DB::unprepared('DROP TRIGGER `trigger_nivel_insert`');
    }
};
