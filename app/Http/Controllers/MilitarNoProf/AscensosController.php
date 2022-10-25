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

class AscensosController extends Controller
{
    public function index()
    {
        return view('sireh.personal.militar_noprof.ascensos.index');
    }

    public function ascender(Request $request)
    {
        switch ($request->input('ascenso')) {
            case 'A6':
                try{
                    $fecha_registro =date('Y-m-d H:i:s');
                    $codigos_empleados=explode(",",$request->ids);
                    foreach($codigos_empleados as $key=>$codigo_empleado){
                        $nomina = Nomina::where('codigo_empleado',$codigo_empleado)->first();
                        $nomina->grado_militar='311';
                        $nomina->update();
                    }
                } catch (Exception $e) {
                    Log::error("************************* ERROR ************************* \n" . $e);
                    return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
                }
                break;
            case 'A5':
                $fecha_registro =date('Y-m-d H:i:s');
                $codigos_empleados=explode(",",$request->ids);
                foreach($codigos_empleados as $key=>$codigo_empleado){
                    $nomina = Nomina::where('codigo_empleado',$codigo_empleado)->first();
                    $nomina->grado_militar='310';
                    $nomina->update();
                }
                break;
            case '5T':
                $fecha_registro =date('Y-m-d H:i:s');
                $codigos_empleados=explode(",",$request->ids);
                foreach($codigos_empleados as $key=>$codigo_empleado){
                    $nomina = Nomina::where('codigo_empleado',$codigo_empleado)->first();
                    $nomina->grado_militar='401';
                    $nomina->update();
                }
                break;
            case 'AL':
                $fecha_registro =date('Y-m-d H:i:s');
                $codigos_empleados=explode(",",$request->ids);
                foreach($codigos_empleados as $key=>$codigo_empleado){
                    $nomina = Nomina::where('codigo_empleado',$codigo_empleado)->first();
                    $nomina->grado_militar='202';
                    $nomina->update();
                }
                break;
            case 'C3':
                $fecha_registro =date('Y-m-d H:i:s');
                $codigos_empleados=explode(",",$request->ids);
                foreach($codigos_empleados as $key=>$codigo_empleado){
                    $nomina = Nomina::where('codigo_empleado',$codigo_empleado)->first();
                    $nomina->grado_militar='214';
                    $nomina->update();
                }
                break;
            case 'C2':
                $fecha_registro =date('Y-m-d H:i:s');
                $codigos_empleados=explode(",",$request->ids);
                foreach($codigos_empleados as $key=>$codigo_empleado){
                    $nomina = Nomina::where('codigo_empleado',$codigo_empleado)->first();
                    $nomina->grado_militar='221';
                    $nomina->update();
                }
                break;
            default:
                # code...
                break;
        }
        return response()->json(['success' => true]);
        
    }

    //Obtiene el personal militar no profesional, exclusivo por api para el Datatable 
    public function getAlferez6toMedicina(Request $request){
        $empleados = Empleado::whereNotIn('empleados.situacion',['E','I']); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MEF']);
        $empleados->whereIn('nomina.codigo_ubicacion',['8594']);
        $empleados->whereIn('nomina.grado_militar',['310']);
        $empleados->select(
            'empleados.cedula',
            'empleados.id',
            'empleados.codigo_empleado',
            'empleados.nombre1',
            'empleados.nombre2',
            'empleados.apellido1',
            'empleados.apellido2',
            'grados_militares.descripcion as grado_militar',
            'ubicaciones.descripcion as ubicacion'
        );
        $empleados->orderBy('empleados.cedula');
        $datatable= Datatables::of($empleados);
        return $datatable->make(true);
    }

    //Obtiene el personal militar no profesional, exclusivo por api para el Datatable 
    public function getAlferez5toMedicina(Request $request){
        $empleados = Empleado::whereNotIn('empleados.situacion',['E','I']); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MEF']);
        $empleados->whereIn('nomina.codigo_ubicacion',['8594']);
        $empleados->whereIn('nomina.grado_militar',['200','201','202']);
        $empleados->select(
            'empleados.cedula',
            'empleados.id',
            'empleados.codigo_empleado',
            'empleados.nombre1',
            'empleados.nombre2',
            'empleados.apellido1',
            'empleados.apellido2',
            'grados_militares.descripcion as grado_militar',
            'ubicaciones.descripcion as ubicacion'
        );
        $empleados->orderBy('empleados.cedula');
        $datatable= Datatables::of($empleados);
        return $datatable->make(true);
    }

    //Obtiene el personal militar no profesional, exclusivo por api para el Datatable 
    public function getAlferez5toSalud(Request $request){
        $empleados = Empleado::whereNotIn('empleados.situacion',['E','I']); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MEF']);
        $empleados->whereIn('nomina.codigo_ubicacion',['8260']);
        $empleados->whereIn('nomina.grado_militar',['200','201','202']);
        $empleados->select(
            'empleados.cedula',
            'empleados.id',
            'empleados.codigo_empleado',
            'empleados.nombre1',
            'empleados.nombre2',
            'empleados.apellido1',
            'empleados.apellido2',
            'grados_militares.descripcion as grado_militar',
            'ubicaciones.descripcion as ubicacion'
        );
        $empleados->orderBy('empleados.cedula');
        $datatable= Datatables::of($empleados);
        return $datatable->make(true);
    }

    //Obtiene el personal militar no profesional, exclusivo por api para el Datatable 
    public function getAlferez(Request $request){
        $empleados = Empleado::whereNotIn('empleados.situacion',['E','I']); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MEF']);
        $empleados->whereIn('nomina.codigo_ubicacion',['4020','8260','8285','8594']);
        $empleados->whereIn('nomina.grado_militar',['210','211','212','213','214']);
        $empleados->select(
            'empleados.cedula',
            'empleados.id',
            'empleados.codigo_empleado',
            'empleados.nombre1',
            'empleados.nombre2',
            'empleados.apellido1',
            'empleados.apellido2',
            'grados_militares.descripcion as grado_militar',
            'ubicaciones.descripcion as ubicacion'
        );
        $empleados->orderBy('empleados.cedula');
        $datatable= Datatables::of($empleados);
        return $datatable->make(true);
    }

    //Obtiene el personal militar no profesional, exclusivo por api para el Datatable 
    public function getCadete3er(Request $request){
        $empleados = Empleado::whereNotIn('empleados.situacion',['E','I']); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MEF']);
        $empleados->whereIn('nomina.codigo_ubicacion',['4020','8260','8285','8594']);
        $empleados->whereIn('nomina.grado_militar',['220','221']);
        $empleados->select(
            'empleados.cedula',
            'empleados.id',
            'empleados.codigo_empleado',
            'empleados.nombre1',
            'empleados.nombre2',
            'empleados.apellido1',
            'empleados.apellido2',
            'grados_militares.descripcion as grado_militar',
            'ubicaciones.descripcion as ubicacion'
        );
        $empleados->orderBy('empleados.cedula');
        $datatable= Datatables::of($empleados);
        return $datatable->make(true);
    }

    //Obtiene el personal militar no profesional, exclusivo por api para el Datatable 
    public function getCadete2do(Request $request){
        $empleados = Empleado::whereNotIn('empleados.situacion',['E','I']); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MEF']);
        $empleados->whereIn('nomina.codigo_ubicacion',['4020','8260','8285','8594']);
        $empleados->whereIn('nomina.grado_militar',['240','241']);
        $empleados->select(
            'empleados.cedula',
            'empleados.id',
            'empleados.codigo_empleado',
            'empleados.nombre1',
            'empleados.nombre2',
            'empleados.apellido1',
            'empleados.apellido2',
            'grados_militares.descripcion as grado_militar',
            'ubicaciones.descripcion as ubicacion'
        );
        $empleados->orderBy('empleados.cedula');
        $datatable= Datatables::of($empleados);
        return $datatable->make(true);
    }

}