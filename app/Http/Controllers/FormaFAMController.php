<?php

namespace App\Http\Controllers;
use App\Models\AeronaveUnidades;
use App\Models\AeronaveModelo;
use App\Models\AeronaveMatricula;
use App\Models\ComponenteOrganismo;
use App\Models\Base;
use App\Models\EmpleadoFuncion;
use App\Models\Empleado;


use Illuminate\Http\Request;

class FormaFAMController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $aeronaveModelos = AeronaveModelo::get();
        $matriculas = AeronaveMatricula::get();
        $unidad = AeronaveUnidades::get();
        $componentes = ComponenteOrganismo::get();
        $bases = Base::get();

        $empleados = Empleado::select('empleados.id','empleados.nombre1','empleados.cedula')
        ->join('empleado_funcion','empleados.codigo_empleado','=','empleados.codigo_empleado')
        ->distinct()
        ->get();

        //dd($empleados);
        return view('forms.index', compact('empleados', 'aeronaveModelos','matriculas','unidad','componentes', 'bases'));
    }

    public function aeronaves_grupos(Request $request)
    {
        $aeronaves = AeronaveModelo::where('codigo_unidad', $request->unidad)->get();
        return response()->json($aeronaves);
    }

    public function seriales(Request $request)
    {
        $selectedUnidad = AeronaveMatricula::where('aeronave_id', $request->id)->whereNotNull('serial')->get();
        return response()->json($selectedUnidad);
    }

    public function matriculas(Request $request)
    {
        $selectedMatricula = AeronaveMatricula::where('aeronave_id', $request->id)->get();
        return response()->json($selectedMatricula);
    }

    
}
