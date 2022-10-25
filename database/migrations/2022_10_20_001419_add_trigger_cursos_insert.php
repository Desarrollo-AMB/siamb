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
        DB::unprepared('CREATE TRIGGER `trigger_cursos_insert` AFTER INSERT ON `cursos` FOR EACH ROW
         BEGIN
            INSERT INTO data_tracking (`action`, `table`,`data_id` , `old_value` , `new_value` , `modified`, `username` )
                VALUES ("insert","cursos", NEW.id, null,
                    JSON_OBJECT(
                        "codigo_curso",NEW.codigo_curso,
                        "descripcion_curso",NEW.descripcion_curso,
                        "dirigido_a",NEW.dirigido_a,
                        "nivel",NEW.nivel,
                        "tipo_curso",NEW.tipo_curso
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
        DB::unprepared('DROP TRIGGER `trigger_cursos_insert`');
    }
};
