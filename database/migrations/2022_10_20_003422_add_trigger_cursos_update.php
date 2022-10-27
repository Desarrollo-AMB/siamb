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
        DB::unprepared('CREATE TRIGGER `trigger_cursos_update` AFTER UPDATE on `cursos` FOR EACH ROW
        BEGIN
           INSERT INTO data_tracking (`action`, `table`,`data_id` , `old_value` , `new_value` , `modified`, `username` )
               VALUES ("update","cursos", NEW.id,
                   JSON_OBJECT(
                       "codigo_curso",OLD.codigo_curso,
                       "descripcion_curso",OLD.descripcion_curso,
                       "dirigido_a",OLD.dirigido_a,
                       "nivel",OLD.nivel,
                       "tipo_curso",OLD.tipo_curso,
                       "is_deleted", OLD.is_deleted
                    ),
                    JSON_OBJECT(
                        "codigo_curso",NEW.codigo_curso,
                        "descripcion_curso",NEW.descripcion_curso,
                        "dirigido_a",NEW.dirigido_a,
                        "nivel",NEW.nivel,
                        "tipo_curso",NEW.tipo_curso,
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
        DB::unprepared('DROP TRIGGER `trigger_cursos_update`');
    }
};
