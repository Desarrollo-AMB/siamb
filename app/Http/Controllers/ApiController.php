<?php

namespace App\Http\Controllers;

use App\Models\Ciudades;
use App\Models\GradosMilitares;
use App\Models\CategoriasMilitares;
use App\Models\PromocionesMilitares;

class ApiController extends Controller
{
    public function getListCiudades($estado_id){
        $ciudades = Ciudades::where('id_estado',$estado_id)->get();
        return response()->json($ciudades);
    }

    public function getCategoriasMilitares($tipo_emp){
        if ($tipo_emp == 'MEX') {
            $categoria = CategoriasMilitares::where('tipo_emp','MIL')->get();
        }
        else {
            $categoria = CategoriasMilitares::where('tipo_emp',$tipo_emp)->get();
        }
        return response()->json($categoria);
    }

    public function getGradosMilitares($tipo_emp){
        if  ($tipo_emp == 'MEX'){
            $grados = GradosMilitares::where('tipo_emp','MIL')->orderBy('codigo_grado','asc')->get();
        }else{
            $grados = GradosMilitares::where('tipo_emp',$tipo_emp)->orderBy('codigo_grado','asc')->get();
        }
        
        return response()->json($grados);
    }

    public function getPromocionesMilitares($categoria){
        $promociones = PromocionesMilitares::where('codigo_categoria',$categoria)->orderBy('codigo_promocion','asc')->get();
        return response()->json($promociones);
    }
}
