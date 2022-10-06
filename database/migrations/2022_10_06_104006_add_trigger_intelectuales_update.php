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
        DB::unprepared('CREATE TRIGGER `trigger_intelectuales_update` AFTER UPDATE on `intelectuales` FOR EACH ROW
        BEGIN
            INSERT INTO data_tracking (`action`, `table`, `data_id`, `old_value`, `new_value`, `modified` ) 
                VALUES ("update","intelectuales", NEW.id, 
                    JSON_OBJECT(
                        "cedula", OLD.cedula,
                        "grado_militar", OLD.grado_militar,
                        "ubicacion_detallada", OLD.ubicacion_detallada,
                        "cargo", OLD.cargo,
                        "caracter", OLD.caracter,
                        "espirutud", OLD.espirutud,
                        "apego", OLD.apego,
                        "discrecion", OLD.discrecion,
                        "comportamiento", OLD.comportamiento,
                        "analistica", OLD.analistica,
                        "actualizacion", OLD.actualizacion,
                        "iniciativa", OLD.iniciativa,
                        "ensenanza", OLD.ensenanza,
                        "servicio", OLD.servicio,
                        "liderazgo", OLD.liderazgo,
                        "planificacion", OLD.planificacion,
                        "administracion", OLD.administracion,
                        "recursor", OLD.recursor,
                        "trabajo", OLD.trabajo,
                        "cantidad_trabajo", OLD.cantidad_trabajo,
                        "decisiones", OLD.decisiones,
                        "seguridad", OLD.seguridad,
                        "rendimiento", OLD.rendimiento,
                        "cultura_p", OLD.cultura_p,
                        "cultura_g", OLD.cultura_g,
                        "expresion", OLD.expresion,
                        "economico", OLD.economico,
                        "total_nota", OLD.total_nota,
                        "notatotal", OLD.notatotal,
                        "fechaI", OLD.fechaI,
                        "fechaF", OLD.fechaF,
                        "cedula_e", OLD.cedula_e,            
                        "grado_e", OLD.grado_e,
                        "nombre_e", OLD.nombre_e,
                        "apellido_e", OLD.apellido_e,            
                        "cargo_e", OLD.cargo_e,
                        "cedula_s", OLD.cedula_s,
                        "grado_s", OLD.grado_s,
                        "nombre_s", OLD.nombre_s,
                        "apellido_s", OLD.apellido_s,
                        "cargo_s", OLD.cargo_s,
                        "fechaE", OLD.fechaE,
                        "is_deleted", OLD.is_deleted
                    ),
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
        DB::unprepared('DROP TRIGGER `trigger_intelectuales_update`');
    }
};
