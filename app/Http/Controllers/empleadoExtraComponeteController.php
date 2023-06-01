<?php

namespace App\Http\Controllers;

use App\Models\Cargos;
use App\Models\Estados;
use App\Models\Nivel;
use App\Models\Profesion;
use App\Models\TiposEmpleado;
use App\Models\UbicacionDetallada;
use App\Models\Ubicaciones;
use App\Models\Universidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class empleadoExtraComponeteController extends Controller
{
    public function ingresoPersonal()
    {
        $user_auth=auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $nacionalidades = Config::get('constants.nacionalidad');
        $generos = Config::get('constants.sexo');
        $edos_civil = Config::get('constants.edo_civil');
        $estados = Estados::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $niveles = Nivel::all();
        $cargos = Cargos::all();
        $universidades = Universidades::all();
        $profesiones = Profesion::all();

        return view('extra_component.ingreso',
            compact(
                'user_auth', 'tipos_emp', 'generos', 'edos_civil',
                'estados', 'ubicaciones', 'ubicaciones_det', 'niveles',
                'cargos', 'nacionalidades', 'universidades', 'profesiones'
            )
        );
    }
}
