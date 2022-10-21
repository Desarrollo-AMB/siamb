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
        DB::unprepared('CREATE TRIGGER `trigger_universidades_insert` AFTER INSERT ON `universidades` FOR EACH ROW
        BEGIN
           INSERT INTO data_tracking (`action`, `table`,`data_id` , `old_value` , `new_value` , `modified`, `username` )
               VALUES ("insert","universidades", NEW.id, null,
                   JSON_OBJECT(
                    "codigo_universidad",NEW.codigo_universidad,
                    "nombre",NEW.nombre,
                    "tipo_universidad",NEW.tipo_universidad,
                    "adscrita_aviacion",NEW.adscrita_aviacion
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
        DB::unprepared('DROP TRIGGER `trigger_universidades_insert`');
    }
};
