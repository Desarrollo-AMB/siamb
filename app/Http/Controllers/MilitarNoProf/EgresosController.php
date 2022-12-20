<?php

namespace App\Http\Controllers\MilitarNoProf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\Log;

use App\Models\DatosMilitares;
use App\Models\Empleado;
use App\Models\EgresosAlist;
use App\Models\Nomina;

class EgresosController extends Controller
{
    public function indexAlistados()
    {
        $contingentes = DatosMilitares::join('nomina', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
        ->join('empleados','nomina.codigo_empleado','=','empleados.codigo_empleado')
        ->where('nomina.situacion','!=','E')
        ->where('nomina.tipo_emp','=','ALI')
        ->whereNotIn('contingente',['','S/C','NULL'])
        ->select('contingente', DB::raw('count(*) as total'))
        ->groupBy('contingente')
        ->get();
        
        return view('sireh.personal.militar_noprof.egresos_alistados.index',compact('contingentes'));
    }


    //Obtiene el personal militar no profesional, exclusivo por api para el Datatable 
    public function dataEgresoAlistadosContingente(Request $request){
        $empleados = Empleado::where('nomina.situacion','!=','E'); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->leftJoin('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->leftJoin('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->join('datos_militares','datos_militares.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->whereIn('nomina.tipo_emp',['ALI']);
        $empleados->where('datos_militares.contingente',$request->contingente);
        $empleados->select(
            'empleados.id',
            'empleados.codigo_empleado',
            'empleados.cedula',
            'empleados.nombre1',
            'empleados.nombre2',
            'empleados.apellido1',
            'empleados.apellido2',
            'grados_militares.descripcion as grado_militar',
            'ubicaciones.descripcion as ubicacion',
        );
        $datatable= Datatables::of($empleados);       
        return $datatable->make(true);
    }


    public function egresarAlistados(Request $request)
    {
        try{
            $fecha_registro =date('Y-m-d H:i:s');
            $contingente=explode(",",$request->contingente);
            $nominas = Nomina::join('datos_militares','datos_militares.codigo_empleado','=','nomina.codigo_empleado')
                ->where('situacion','!=','E')
                ->where('nomina.tipo_emp','=','ALI')
                ->whereIn('datos_militares.contingente',$contingente)
                ->get();
                
            foreach($nominas as $nomina){
                DB::transaction(function() use ($nomina, $fecha_registro, $request)
                {
                    $egreso = new EgresosAlist();
                    $egreso->codigo_empleado = $nomina->codigo_empleado;
                    $egreso->contingente = $nomina->contingente;
                    $egreso->fecha_egreso = $request->fecha_egreso;
                    $egreso->resolucion = $request->resolucion;
                    $egreso->username = auth()->user()->username;
                    $egreso->fecha_registro = $fecha_registro;
                    $egreso->save();
                    Empleado::where('codigo_empleado',$nomina->codigo_empleado)->update(['situacion'=>'E']);
                    Nomina::where('codigo_empleado',$nomina->codigo_empleado)->update(['situacion'=>'E']);
                    
                });
            }
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }
}
