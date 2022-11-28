<?php

namespace App\Http\Controllers\Civil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

use App\Models\Empleado;
use App\Models\Nomina;
use App\Models\Jubilados;
use App\Models\Movimientos;
use App\Exports\JubiladosExport;

class JubiladosController extends Controller
{

    public function indexJubilablesCivil()
    {
        return view('sireh.personal.civil.jubilados.index');
    }

    //Obtiene el personal Civil, exclusivo por api para el Datatable 
    public function jubilablesPersonalCivil(Request $request){
        $empleados = Empleado::join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado')
            ->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp')
            ->leftJoin('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
            ->leftJoin('cargos','cargos.codigo_cargo','=','nomina.codigo_cargo')
            //->whereIn('nomina.tipo_emp',['OBR','EMP','DOC'])
            ->select(
                'empleados.id',
                'empleados.codigo_empleado',
                'empleados.cedula',
                'empleados.nombre1',
                'empleados.nombre2',
                'empleados.apellido1',
                'empleados.apellido2',
                'tipos_empleados.descripcion as tipo_empleado',
                'nomina.fecha_ingreso',
                'empleados.fecha_nacim',
                DB::raw("TIMESTAMPDIFF(YEAR,empleados.fecha_nacim,CURDATE()) as edad"),
                DB::raw("TIMESTAMPDIFF(YEAR,nomina.fecha_ingreso,CURDATE()) as antiguedad"),
            );
        $empleados->where(function($query) {
            return $query
                ->where('empleados.situacion','!=','E')
                ->where('empleados.sexo', 'F')
                ->where('nomina.tipo_emp', 'EMP')
                ->where(DB::raw("TIMESTAMPDIFF(YEAR,empleados.fecha_nacim,CURDATE())"), '>', 54)
                ->where(DB::raw("TIMESTAMPDIFF(YEAR,nomina.fecha_ingreso,CURDATE())"), '>=', 30)
                ;
        });
        $empleados->orWhere(function($query) {
            return $query
                ->where('empleados.situacion','!=','E')
                ->where('empleados.sexo', 'F')
                ->where('nomina.tipo_emp', 'OBR')
                ->where(DB::raw("TIMESTAMPDIFF(YEAR,empleados.fecha_nacim,CURDATE())"), '>', 54)
                ->where(DB::raw("TIMESTAMPDIFF(YEAR,nomina.fecha_ingreso,CURDATE())"), '>=', 25)
                ;
        });
        $empleados->orWhere(function($query) {
            return $query
                ->where('empleados.situacion','!=','E')
                ->where('empleados.sexo', 'M')
                ->whereIn('nomina.tipo_emp', ['EMP','DOC'])
                ->where(DB::raw("TIMESTAMPDIFF(YEAR,empleados.fecha_nacim,CURDATE())"), '>', 59)
                ->where(DB::raw("TIMESTAMPDIFF(YEAR,nomina.fecha_ingreso,CURDATE())"), '>=', 30)
                ;
        });
        $empleados->orWhere(function($query) {
            return $query
                ->where('empleados.situacion','!=','E')
                ->where('empleados.sexo', 'M')
                ->where('nomina.tipo_emp', 'OBR')
                ->where(DB::raw("TIMESTAMPDIFF(YEAR,empleados.fecha_nacim,CURDATE())"), '>', 59)
                ->where(DB::raw("TIMESTAMPDIFF(YEAR,nomina.fecha_ingreso,CURDATE())"), '>=', 25)
                ;
        });
        $empleados->orderBy('antiguedad', 'DESC');
        $datatable= Datatables::of($empleados)
            ->addColumn('actions', 'sireh.personal.civil.jubilados._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function showJubiladoPersonalCivil(Request $request)
    {
        $jubilado = Empleado::with(['nomina'])
            ->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado')
            ->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp')
            ->where('empleados.codigo_empleado', $request->id)
            ->select(
                'empleados.id',
                'empleados.codigo_empleado',
                'empleados.cedula',
                'empleados.nombre1',
                'empleados.nombre2',
                'empleados.apellido1',
                'empleados.apellido2',
                'tipos_empleados.descripcion as tipo_empleado',
                'nomina.fecha_ingreso',
                'empleados.fecha_nacim',
                DB::raw("TIMESTAMPDIFF(YEAR,empleados.fecha_nacim,CURDATE()) as edad"),
                DB::raw("TIMESTAMPDIFF(YEAR,nomina.fecha_ingreso,CURDATE()) as antiguedad"),
            )
            ->get();
        return response()->json([
                'success' => true,
                'message' => 'Data',
                'data' => $jubilado,
            ]
        );
    }

    public function storeJubiladoPersonalCivil(Request $request)
    {
        try{
            $empleado=Empleado::where('codigo_empleado', $request->codigo_empleado)->first();
            $empleado->situacion = 'E';
            $empleado->update();
            $nomina=Nomina::where('codigo_empleado', $request->codigo_empleado)->first();
            $nomina->situacion = 'E';
            $nomina->update();

            $movimiento = new Movimientos;
            $movimiento->fecha_movimiento = $request->fecha_jubilacion;
            $movimiento->tipo_movimiento = 'JUBILACIÓN';
            $movimiento->situacion = 'E';
            $movimiento->observaciones = $request->observaciones;
            $movimiento->codigo_empleado = $request->codigo_empleado;
            $movimiento->save();

            $jubilar = new Jubilados;
            $jubilar->codigo_empleado = $request->codigo_empleado;
            $jubilar->tipo_emp = $nomina->tipo_emp;
            $jubilar->nombre1 = $empleado->nombre1;
            $jubilar->nombre2 = $empleado->nombre2;
            $jubilar->apellido1 = $empleado->apellido1;
            $jubilar->apellido2 = $empleado->apellido2;
            $jubilar->cedula = $empleado->cedula;
            $jubilar->fecha_ingreso = $nomina->fecha_ingreso;
            $jubilar->fecha_jubilacion = $request->fecha_jubilacion;
            $jubilar->observaciones = $request->observaciones;
            $jubilar->usuario = auth()->user()->username;
            $jubilar->save();
            
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data inserted successfully',
                    //'situacion' => $updateSituacion,
                ]
            );
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }

    public function jubiladosFecha() {
        return view('sireh.personal.civil.jubilados.fecha-jubilados');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function jubiladosReportExcel(Request $request)
    {
        $this->validate($request, 
            [
                'desde' => 'required',
                'hasta' => 'required',
            ],
            [
                'desde.required' => 'La Fecha Desde es requerida',
                'hasta.required' => 'La Fecha Hasta es requerida'
            ]
        );
        $titulo = 'REPORTE DE JUBILADOS';
        $jubilados = Jubilados::whereBetween('fecha_jubilacion',[$request->desde,$request->hasta])->with(['tipo_empleado'])
        ->get();
        $nombre_archivo = sprintf('reporte de jubilados %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
        $data = compact('titulo', 'jubilados');
        return Excel::download(new JubiladosExport($data), $nombre_archivo);
    }
}
