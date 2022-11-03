<?php

namespace App\Http\Controllers;

use App\Models\Ciudades;
use App\Models\GradosMilitares;

class ApiController extends Controller
{
    public function getListCiudades($estado_id){
        $ciudades = Ciudades::where('id_estado',$estado_id)->get();
        return response()->json($ciudades);
    }

    public function getGradosMilitares($tipo_emp=null){
        if  ($tipo_emp){
            $grados = GradosMilitares::where('tipo_emp',$tipo_emp)->get();
        }else{
            $grados = GradosMilitares::all();
        }
        
        return response()->json($grados);
    }
}
