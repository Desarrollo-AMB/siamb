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
        DB::unprepared('CREATE TRIGGER `trigger_paf_insert` AFTER INSERT ON `paf` FOR EACH ROW
        BEGIN
            INSERT INTO data_tracking (`action`, `table`,`data_id` , `old_value` , `new_value` , `modified` ) 
                VALUES ("insert","paf", NEW.id, null, 
                    JSON_OBJECT(
                        "cedula", NEW.cedula,
                        "grado", NEW.grado,
                        "nombre1", NEW.nombre1,
                        "nombre2", NEW.nombre2,
                        "apellido1", NEW.apellido1,
                        "apellido2", NEW.apellido2,
                        "sexo", NEW.sexo,
                        "edad", NEW.edad,
                        "categoria", NEW.categoria,
                        "unidad", NEW.unidad,
                        "tipo_prueba", NEW.tipo_prueba,
                        "tipo_caso", NEW.tipo_caso,
                        "presenta_prueba", NEW.presenta_prueba,
                        "fecha_pres", NEW.fecha_pres,
                        "trote", NEW.trote,
                        "nota_trote", NEW.nota_trote,
                        "flexiones", NEW.flexiones,
                        "nota_flexiones", NEW.nota_flexiones,
                        "abdominales", NEW.abdominales,
                        "nota_abdominales", NEW.nota_abdominales,
                        "natacion", NEW.natacion,
                        "nota_natacion", NEW.nota_natacion,
                        "total", NEW.total,
                        "apro_repro", NEW.apro_repro,
                        "casos_especiales", NEW.casos_especiales,
                        "observaciones", NEW.observaciones,
                        "nombre1_ev", NEW.nombre1_ev,
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
        DB::unprepared('DROP TRIGGER `trigger_paf_insert`');
    }
};
