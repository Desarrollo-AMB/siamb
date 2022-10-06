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
        DB::unprepared('CREATE TRIGGER trigger_datos_boleta_insert AFTER INSERT ON `datos_boleta` FOR EACH ROW
        BEGIN
            INSERT INTO data_tracking (`action`, `table`,`data_id` , `old_value` , `new_value` , `modified` ) 
                VALUES ("insert","datos_boleta", NEW.id, null, 
                    JSON_OBJECT(
                        "cedula", NEW.cedula,
                        "grado", NEW.grado,
                        "cargo", NEW.cargo,
                        "hora_registro", NEW.hora_registro,
                        "naturaleza", NEW.naturaleza,
                        "articulo1", NEW.articulo1,
                        "aparte1", NEW.aparte1,
                        "atenuantes", NEW.atenuantes,
                        "atenuantes2", NEW.atenuantes2,
                        "agravantes", NEW.agravantes,
                        "agravantes2", NEW.agravantes2,
                        "dias", NEW.dias,
                        "horas", NEW.horas,
                        "grado_solicitud", NEW.grado_solicitud,
                        "nombre_solicitud", NEW.nombre_solicitud,
                        "cedula_solicitud", NEW.cedula_solicitud,
                        "cargo_solicitud", NEW.cargo_solicitud,
                        "cod_unidad", NEW.cod_unidad,
                        "unidad", NEW.unidad,
                        "localidad", NEW.localidad,
                        "img_afectado1", NEW.img_afectado1,
                        "img_afectado2", NEW.img_afectado2,
                        "img_afectado3", NEW.img_afectado3,
                        "img_comando1", NEW.img_comando1,
                        "img_comando2", NEW.img_comando2,
                        "img_comando3", NEW.img_comando3,
                        "img_otros1", NEW.img_otros1,
                        "img_otros2", NEW.img_otros2,
                        "img_otros3", NEW.img_otros3,	
                        "user", NEW.user,
                        "status", NEW.status,
                        "fecha_revision", NEW.fecha_revision,
                        "grado_revision", NEW.grado_revision,
                        "nombre_revision", NEW.nombre_revision,
                        "cedula_revision", NEW.cedula_revision,
                        "observacion", NEW.observacion,
                        "demerito", NEW.demerito,
                        "fecha", NEW.fecha,
                        "falta_real", NEW.falta_real,
                        "desde", NEW.desde,
                        "hasta", NEW.hasta
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
        DB::unprepared('DROP TRIGGER `trigger_datos_boleta_insert`');
    }
};
