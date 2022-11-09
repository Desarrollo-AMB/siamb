<?php

namespace App\Http\Controllers\MilitarNoProf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Facades\Log;

use App\Models\Empleado;
use App\Models\Nomina;


class ReingresosController extends Controller
{
    public function index()
    {
        return view('sireh.personal.militar_noprof.reingresos.index');
    }

    //Obtiene el personal militar no profesional, exclusivo por api para el Datatable 
    public function personalMilitarNoProfEgresado(Request $request){
        $empleados = Empleado::where('empleados.situacion','E'); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['ALI','MEF']);
        $empleados->select(
            'empleados.id',
            'empleados.codigo_empleado',
            'empleados.cedula',
            'empleados.nombre1',
            'empleados.nombre2',
            'empleados.apellido1',
            'empleados.apellido2',
            'grados_militares.descripcion as grado_militar',
            'nomina.observaciones as motivo_egreso',
            'nomina.fecha_egreso',
        );
        $datatable= Datatables::of($empleados)
            ->addColumn('actions', 'sireh.personal.militar_noprof.reingresos._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function reingresarMilitarNoProf(Request $request){
        
        $this->validate($request, 
            [           
                'observaciones' => 'required',
            ],
            [
                'fecha_egreso.required' => 'Fecha de Egreso es requerida',
                'observaciones.required' => 'Motivo de Egreso es requerido'
            ]
        );
        try {
            $empleado = Empleado::find($request->id_empleado);
            $nomina = Nomina::where('codigo_empleado',$empleado->codigo_empleado)->first();
            $empleado->situacion='A';
            $nomina->situacion='A';
            $nomina->fecha_egreso=null;
            $nomina->observaciones=$request->observaciones;
            $empleado->update();
            $nomina->update();
            return response()->json(['success' => true,'msg'=>'Reingreso Realizado con exito']);
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }
    

}