<?php

namespace App\Http\Controllers;
use App\Models\AeronaveUnidades;
use App\Models\AeronaveModelo;
use App\Models\AeronaveMatricula;
use App\Models\ComponenteOrganismo;
use App\Models\Base;
use App\Models\EmpleadoFuncion;
use App\Models\Empleado;
use App\Models\Fam0001;


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

        // $empleados = Empleado::select('empleados.id','empleados.nombre1','empleados.cedula')
        // ->join('empleado_funcion','empleados.codigo_empleado','=','empleados.codigo_empleado')
        // ->distinct()
        // ->get();

        $jefeMaquina = EmpleadoFuncion::with('empleado')->get();

        //dd($jefeMaquina);
        return view('forms.index', compact('jefeMaquina', 'aeronaveModelos','matriculas','unidad','componentes', 'bases'));
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

    public function steps()
    {
        $pasosCompletados = Fam0001::get();
        return response()->json($pasosCompletados);
    }

    public function store(Request $request)
    {
        $fam0001 = new Fam0001;
        $fam0001->fecha = $request->fecha;
        $fam0001->ov_ota_om = $request->ov_ota_om;
        $fam0001->componente_organismo = $request->componente_organismo;
        $fam0001->unidad = $request->unidad;
        $fam0001->aeronave_modelo = $request->aeronave_modelo;
        $fam0001->serial = $request->serial;
        $fam0001->matricula = $request->matricula;
        $fam0001->base_estacion = $request->base_estacion;
        $fam0001->jefe_maquina = $request->jefe_maquina;
        $fam0001->completado = $request->completado;
        $fam0001->save();

        $fecha = $request->ov_ota_om;

        //return response()->json($request);
        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'data' => $fecha
            ]
        );
    }

    
}
