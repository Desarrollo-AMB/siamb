<?php

namespace App\Http\Controllers;

use App\Models\Ciudades;
use App\Models\GradosMilitares;
use App\Models\CategoriasMilitares;
use App\Models\PromocionesMilitares;
use App\Models\UbicacionDetallada;

class ApiController extends Controller
{
    public function getListCiudades($estado_id){
        $ciudades = Ciudades::where('id_estado',$estado_id)->get();
        return response()->json($ciudades);
    }

    public function getCategoriasMilitares($tipo_emp){
        if ($tipo_emp == 'MIL' || $tipo_emp =='MEX') {
            $categoria = CategoriasMilitares::where('tipo_emp','MIL')->get();
        }
        else {
            $categoria = CategoriasMilitares::where('tipo_emp','TRP')->get();
        }
        return response()->json($categoria);
    }

    public function getGradosMilitares($tipo_emp){
        if  ($tipo_emp == 'MIL' || $tipo_emp =='MEX'){
            $grados = GradosMilitares::where('tipo_emp','MIL')->orderBy('codigo_grado','asc')->get();
        }else{
            $grados = GradosMilitares::where('tipo_emp','TRP')->orderBy('codigo_grado','asc')->get();
        }
        
        return response()->json($grados);
    }

    public function getPromocionesMilitares($categoria){
        $promociones = PromocionesMilitares::where('codigo_categoria',$categoria)->orderBy('codigo_promocion','asc')->get();
        return response()->json($promociones);
    }

    public function getUbicacionesDetalladas($ubicacion){
        $ubicaciones_detalladas = UbicacionDetallada::where('codigo_ubic_nomina',$ubicacion)->orderBy('codigo_ubicacion','asc')->get();
        return response()->json($ubicaciones_detalladas);
    }
}
