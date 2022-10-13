<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ciudades;

class ApiController extends Controller
{
    public function getListCiudades($estado_id){
        $ciudades = Ciudades::where('id_estado',$estado_id)->get();
        return response()->json($ciudades);
    }
}
