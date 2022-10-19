<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ciudades;
use App\Models\GradosMilitares;

class ApiController extends Controller
{
    public function getListCiudades($estado_id){
        $ciudades = Ciudades::where('id_estado',$estado_id)->get();
        return response()->json($ciudades);
    }

    public function getGradosMilitares($tipo_emp){
        $ciudades = GradosMilitares::where('tipo_emp',$tipo_emp)->get();
        return response()->json($ciudades);
    }
}
