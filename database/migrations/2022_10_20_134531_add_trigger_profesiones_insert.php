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
        DB::unprepared('CREATE TRIGGER `trigger_profesiones_insert` AFTER INSERT ON `profesiones` FOR EACH ROW
        BEGIN
           INSERT INTO data_tracking (`action`, `table`,`data_id` , `old_value` , `new_value` , `modified`, `username` )
               VALUES ("insert","profesiones", NEW.id, null,
                   JSON_OBJECT(
                    "codigo_profesion",NEW.codigo_profesion,
                    "descripcion",NEW.descripcion
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
        DB::unprepared('DROP TRIGGER `trigger_profesiones_insert`');
    }
};
