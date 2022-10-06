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
        DB::unprepared('CREATE TRIGGER `trigger_intelectuales_insert` AFTER INSERT ON `intelectuales` FOR EACH ROW
        BEGIN
            INSERT INTO data_tracking (`action`, `table`,`data_id` , `old_value` , `new_value` , `modified` ) 
                VALUES ("insert","intelectuales", NEW.id, null, 
                    JSON_OBJECT(
                        "cedula", NEW.cedula,
                        "grado_militar", NEW.grado_militar,
                        "ubicacion_detallada", NEW.ubicacion_detallada,
                        "cargo", NEW.cargo,
                        "caracter", NEW.caracter,
                        "espirutud", NEW.espirutud,
                        "apego", NEW.apego,
                        "discrecion", NEW.discrecion,
                        "comportamiento", NEW.comportamiento,
                        "analistica", NEW.analistica,
                        "actualizacion", NEW.actualizacion,
                        "iniciativa", NEW.iniciativa,
                        "ensenanza", NEW.ensenanza,
                        "servicio", NEW.servicio,
                        "liderazgo", NEW.liderazgo,
                        "planificacion", NEW.planificacion,
                        "administracion", NEW.administracion,
                        "recursor", NEW.recursor,
                        "trabajo", NEW.trabajo,
                        "cantidad_trabajo", NEW.cantidad_trabajo,
                        "decisiones", NEW.decisiones,
                        "seguridad", NEW.seguridad,
                        "rendimiento", NEW.rendimiento,
                        "cultura_p", NEW.cultura_p,
                        "cultura_g", NEW.cultura_g,
                        "expresion", NEW.expresion,
                        "economico", NEW.economico,
                        "total_nota", NEW.total_nota,
                        "notatotal", NEW.notatotal,
                        "fechaI", NEW.fechaI,
                        "fechaF", NEW.fechaF,
                        "cedula_e", NEW.cedula_e,            
                        "grado_e", NEW.grado_e,
                        "nombre_e", NEW.nombre_e,
                        "apellido_e", NEW.apellido_e,            
                        "cargo_e", NEW.cargo_e,
                        "cedula_s", NEW.cedula_s,
                        "grado_s", NEW.grado_s,
                        "nombre_s", NEW.nombre_s,
                        "apellido_s", NEW.apellido_s,
                        "cargo_s", NEW.cargo_s,
                        "fechaE", NEW.fechaE,
                        "is_deleted", NEW.is_deleted
                    ),
                    NOW()
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
        DB::unprepared('DROP TRIGGER `trigger_intelectuales_insert`');
    }
};
