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
use App\Models\DatosMilitares;
use App\Models\Movimientos;
use App\Models\HistoricoAscensos;

class GraduacionController extends Controller
{
    public function index()
    {
        return view('sireh.personal.militar_noprof.graduacion.index');
    }

    public function graduar(Request $request)
    {
        switch ($request->input('categoria')) {
            case 'comando':
                try{
                    $fecha_registro =date('Y-m-d H:i:s');
                    $codigos_empleados=explode(",",$request->ids);
                    foreach($codigos_empleados as $key=>$codigo_empleado){
                        $nomina = Nomina::where('codigo_empleado',$codigo_empleado)->first();
                        $nomina->tipo_emp='MIL';
                        $nomina->codigo_ubicacion='8593';
                        $nomina->grado_militar='090';
                        $nomina->update();

                        $datos_militares = DatosMilitares::where('codigo_empleado',$codigo_empleado)->first();
                        if ($datos_militares){
                            $datos_militares->codigo_categoria='01';
                            $datos_militares->update();

                            $movimiento = new Movimientos();
                            $movimiento->codigo_empleado = $codigo_empleado;
                            $movimiento->fecha_movimiento = $fecha_registro;
                            $movimiento->tipo_movimiento = 'TRAN';
                            $movimiento->codigo_ubicacion = '8593';
                            $movimiento->codigo_cargo=0;
                            $movimiento->fecha_efectividad=$request->fecha_ascenso;
                            $movimiento->observaciones='GRADUADO';
                            $movimiento->fecha_promocion= $request->fecha_ascenso;
                            $movimiento->situacion ='A';
                            $movimiento->tipo_emp_anterior='MEF';
                            $movimiento->tipo_emp_nuevo = 'MIL';
                            $movimiento->codigo_grado ='090';
                            $movimiento->fecha_ubicacion=$request->fecha_ascenso;
                            $movimiento->fecha_cargo=$request->fecha_ascenso;
                            $movimiento->save();

                            HistoricoAscensos::create(
                                [
                                    'codigo_empleado'=> $codigo_empleado,
                                    'codigo_grado'=>'090',
                                    'fecha_ascenso' => $request->fecha_ascenso,
                                    'resolucion'=> $request->numero_resuelto,
                                    'username' => auth()->user()->username,
                                    'fecha_registro' => $fecha_registro,
                                ]
                            );
                        }
                    }
                } catch (Exception $e) {
                    Log::error("************************* ERROR ************************* \n" . $e);
                    return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
                }
                break;
            case 'tecnico':
                $fecha_registro =date('Y-m-d H:i:s');
                $codigos_empleados=explode(",",$request->ids);
                foreach($codigos_empleados as $key=>$codigo_empleado){
                    $nomina = Nomina::where('codigo_empleado',$codigo_empleado)->first();
                    $nomina->tipo_emp='MIL';
                    $nomina->codigo_ubicacion='8593';
                    $nomina->grado_militar='090';
                    $nomina->update();

                    $datos_militares = DatosMilitares::where('codigo_empleado',$codigo_empleado)->first();
                    if ($datos_militares){
                        $datos_militares->codigo_categoria='05';
                        $datos_militares->update();

                        $movimiento = new Movimientos();
                        $movimiento->codigo_empleado = $codigo_empleado;
                        $movimiento->fecha_movimiento = $fecha_registro;
                        $movimiento->tipo_movimiento = 'TRAN';
                        $movimiento->codigo_ubicacion = '8593';
                        $movimiento->codigo_cargo=0;
                        $movimiento->fecha_efectividad=$request->fecha_ascenso;
                        $movimiento->observaciones='GRADUADO';
                        $movimiento->fecha_promocion= $request->fecha_ascenso;
                        $movimiento->situacion ='A';
                        $movimiento->tipo_emp_anterior='MEF';
                        $movimiento->tipo_emp_nuevo = 'MIL';
                        $movimiento->codigo_grado ='090';
                        $movimiento->fecha_ubicacion=$request->fecha_ascenso;
                        $movimiento->fecha_cargo=$request->fecha_ascenso;
                        $movimiento->save();

                        HistoricoAscensos::create(
                            [
                                'codigo_empleado'=> $codigo_empleado,
                                'codigo_grado'=>'090',
                                'fecha_ascenso' => $request->fecha_ascenso,
                                'resolucion'=> $request->numero_resuelto,
                                'username' => auth()->user()->username,
                                'fecha_registro' => $fecha_registro,
                            ]
                        );
                    }
                }
                break;
            case 'tropa':
                $fecha_registro =date('Y-m-d H:i:s');
                $codigos_empleados=explode(",",$request->ids);
                foreach($codigos_empleados as $key=>$codigo_empleado){
                    $nomina = Nomina::where('codigo_empleado',$codigo_empleado)->first();
                    $nomina->tipo_emp='MIL';
                    $nomina->codigo_ubicacion='8593';
                    $nomina->grado_militar='090';
                    $nomina->update();

                    $datos_militares = DatosMilitares::where('codigo_empleado',$codigo_empleado)->first();
                    if ($datos_militares){
                        $datos_militares->codigo_categoria='07';
                        $datos_militares->update();

                        $movimiento = new Movimientos();
                        $movimiento->codigo_empleado = $codigo_empleado;
                        $movimiento->fecha_movimiento = $fecha_registro;
                        $movimiento->tipo_movimiento = 'TRAN';
                        $movimiento->codigo_ubicacion = '8593';
                        $movimiento->codigo_cargo=0;
                        $movimiento->fecha_efectividad=$request->fecha_ascenso;
                        $movimiento->observaciones='GRADUADO';
                        $movimiento->fecha_promocion= $request->fecha_ascenso;
                        $movimiento->situacion ='A';
                        $movimiento->tipo_emp_anterior='MEF';
                        $movimiento->tipo_emp_nuevo = 'MIL';
                        $movimiento->codigo_grado ='090';
                        $movimiento->fecha_ubicacion=$request->fecha_ascenso;
                        $movimiento->fecha_cargo=$request->fecha_ascenso;
                        $movimiento->save();

                        HistoricoAscensos::create(
                            [
                                'codigo_empleado'=> $codigo_empleado,
                                'codigo_grado'=>'090',
                                'fecha_ascenso' => $request->fecha_ascenso,
                                'resolucion'=> $request->numero_resuelto,
                                'username' => auth()->user()->username,
                                'fecha_registro' => $fecha_registro,
                            ]
                        );
                    }
                }
                break;
            case 'asimilado':
                $fecha_registro =date('Y-m-d H:i:s');
                $codigos_empleados=explode(",",$request->ids);
                foreach($codigos_empleados as $key=>$codigo_empleado){
                    $nomina = Nomina::where('codigo_empleado',$codigo_empleado)->first();
                    $nomina->tipo_emp='MIL';
                    $nomina->codigo_ubicacion='8593';
                    $nomina->grado_militar='090';
                    $nomina->update();

                    $datos_militares = DatosMilitares::where('codigo_empleado',$codigo_empleado)->first();
                    if ($datos_militares){
                        $datos_militares->codigo_categoria='02';
                        $datos_militares->update();

                        $movimiento = new Movimientos();
                        $movimiento->codigo_empleado = $codigo_empleado;
                        $movimiento->fecha_movimiento = $fecha_registro;
                        $movimiento->tipo_movimiento = 'TRAN';
                        $movimiento->codigo_ubicacion = '8593';
                        $movimiento->codigo_cargo=0;
                        $movimiento->fecha_efectividad=$request->fecha_ascenso;
                        $movimiento->observaciones='GRADUADO';
                        $movimiento->fecha_promocion= $request->fecha_ascenso;
                        $movimiento->situacion ='A';
                        $movimiento->tipo_emp_anterior='MEF';
                        $movimiento->tipo_emp_nuevo = 'MIL';
                        $movimiento->codigo_grado ='090';
                        $movimiento->fecha_ubicacion=$request->fecha_ascenso;
                        $movimiento->fecha_cargo=$request->fecha_ascenso;
                        $movimiento->save();

                        HistoricoAscensos::create(
                            [
                                'codigo_empleado'=> $codigo_empleado,
                                'codigo_grado'=>'090',
                                'fecha_ascenso' => $request->fecha_ascenso,
                                'resolucion'=> $request->numero_resuelto,
                                'username' => auth()->user()->username,
                                'fecha_registro' => $fecha_registro,
                            ]
                        );
                    }
                }
                break;
            case 'trop_prof':
                $fecha_registro =date('Y-m-d H:i:s');
                $codigos_empleados=explode(",",$request->ids);
                foreach($codigos_empleados as $key=>$codigo_empleado){

                    $nomina = Nomina::where('codigo_empleado',$codigo_empleado)->first();
                    $nomina->tipo_emp='TRP';
                    $nomina->codigo_ubicacion='8593';
                    $nomina->grado_militar='470';
                    $nomina->update();

                    $datos_militares = DatosMilitares::where('codigo_empleado',$codigo_empleado)->first();
                    if ($datos_militares){
                        $datos_militares->codigo_categoria='08';
                        $datos_militares->fecha_graduacion= $request->fecha_ascenso;
                        $datos_militares->update();

                        $movimiento = new Movimientos();
                        $movimiento->codigo_empleado = $codigo_empleado;
                        $movimiento->fecha_movimiento = $fecha_registro;
                        $movimiento->tipo_movimiento = 'TRAN';
                        $movimiento->codigo_ubicacion = '8593';
                        $movimiento->codigo_cargo=0;
                        $movimiento->fecha_efectividad=$request->fecha_ascenso;
                        $movimiento->observaciones='GRADUADO';
                        $movimiento->fecha_promocion= $request->fecha_ascenso;
                        $movimiento->situacion ='A';
                        $movimiento->tipo_emp_anterior='MEF';
                        $movimiento->tipo_emp_nuevo = 'TRP';
                        $movimiento->codigo_grado ='470';
                        $movimiento->fecha_ubicacion=$request->fecha_ascenso;
                        $movimiento->fecha_cargo=$request->fecha_ascenso;
                        $movimiento->save();

                        HistoricoAscensos::create(
                            [
                                'codigo_empleado'=> $codigo_empleado,
                                'codigo_grado'=>'470',
                                'fecha_ascenso' => $request->fecha_ascenso,
                                'resolucion'=> $request->numero_resuelto,
                                'username' => auth()->user()->username,
                                'fecha_registro' => $fecha_registro,
                            ]
                        );
                    }
                }
                break;
            default:
                # code...
                break;
        }
        return response()->json(['success' => true]);
        
    }

    //Obtiene el personal militar no profesional, exclusivo por api para el Datatable 
    public function getOficialesComando(Request $request){
        $empleados = Empleado::whereNotIn('empleados.situacion',['E','I']); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MEF']);
        $empleados->where('nomina.codigo_ubicacion','0086');
        $empleados->whereIn('nomina.grado_militar',['400','200','201','202']);
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
    public function getOficialesTecnicosMedicina(Request $request){
        $empleados = Empleado::whereNotIn('empleados.situacion',['E','I']); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MEF']);
        $empleados->where('nomina.codigo_ubicacion','0087');
        $empleados->whereIn('nomina.grado_militar',['311']);
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
    public function getOficialesTecnicosSalud(Request $request){
        $empleados = Empleado::whereNotIn('empleados.situacion',['E','I']); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MEF']);
        $empleados->where('nomina.codigo_ubicacion','0092');
        $empleados->whereIn('nomina.grado_militar',['401']);
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
    public function getOficialesTecnicos(Request $request){
        $empleados = Empleado::whereNotIn('empleados.situacion',['E','I']); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MEF']);
        $empleados->whereIn('nomina.codigo_ubicacion',['0090','0091']);
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
    public function getOficialesTropa(Request $request){
        $empleados = Empleado::whereNotIn('empleados.situacion',['E','I']); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MEF']);
        $empleados->whereIn('nomina.codigo_ubicacion',['8643']);
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
    public function getOficialesAsimilados(Request $request){
        $empleados = Empleado::whereNotIn('empleados.situacion',['E','I']); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MEF']);
        $empleados->whereIn('nomina.codigo_ubicacion',['0086','0378']);
        $empleados->whereIn('nomina.grado_militar',['549']);
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
    public function getOficialesTropaProfesional(Request $request){
        $empleados = Empleado::whereNotIn('empleados.situacion',['E','I']); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MEF']);
        $empleados->whereIn('nomina.codigo_ubicacion',['0378']);
        $empleados->whereIn('nomina.grado_militar',['330']);
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