<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\AeronaveUnidades;
use App\Models\AeronaveModelo;
use App\Models\AeronaveMatricula;
use App\Models\ComponenteOrganismo;
use App\Models\Base;
use App\Models\EmpleadoFuncion;
use App\Models\Empleado;
use App\Models\Nomina;
use App\Models\Fam0001;
use App\Models\VueloOrdenadaPor;
use App\Models\VueloEnApoyo;
use App\Models\UnidadesConsumible;
use App\Models\UnidadesMedidas;
use App\Models\Fam0001A1Mision;
use App\Models\CodigoTipoMision;
use App\Models\Fam0001A1MisionConsumible;
use App\Models\Fam0001B1Tripulacion;
use App\Models\FuncionTripulante;
use App\Models\CodigoDespegue;
use App\Models\CodigoTipoMisionSiglas;
use App\Models\CodigoAterrizaje;
use App\Models\Fam0001A3CargaPasajeros;
use App\Models\Fam0001B1TripulacionAterrizajes;
use App\Models\GradosMilitares;
use App\Models\Ubicaciones;
use DataTables;

use Illuminate\Http\Request;

class FormaFAMController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    public function fam0001() 
    {
        $user_id = auth()->id();
        $empleado = Empleado::where('user_id',$user_id)->with('data_empleado')->get();
        if(count($empleado)>0){
            $codigo_ubicacion = $empleado[0]['data_empleado']['codigo_ubicacion'];        
            $ubicacion = AeronaveUnidades::where('codigo_ubicacion',$codigo_ubicacion)->get();
            if(count($ubicacion)>0){
                $fam0001 = Fam0001::where('unidad', $ubicacion[0]['codigos'])->where('user_id',$user_id)->with('aeronaves')->get();
            }else{
                dd('este usuario no tiene ubicacion relacionada con las aeronaves en la BD');
            }
        }else{
            $fam0001 = Fam0001::with('aeronaves')->get();
        }

        return view('forms.FAM0001', compact('fam0001'));
    }
    public function FormaFAM_status($fam_id) 
    {
        //HEADER
        $aeronaveModelos = AeronaveModelo::get();
        $matriculas = AeronaveMatricula::get();
        $unidad = AeronaveUnidades::get();
        $componentes = ComponenteOrganismo::get();
        $bases = Base::get();
        $jefeMaquina = EmpleadoFuncion::with('empleado')->where('id_funcion', 16)->get();
    
        //A1-MISION
        $vueloOrdenadaPor = VueloOrdenadaPor::get();
        $enApoyo = VueloEnApoyo::get();
        $consumibles = UnidadesConsumible::get();
        $unidadesMedida = UnidadesMedidas::get();
        $codigoMision = CodigoTipoMision::orderBy('codigo', 'asc')->get();
        $codigoTipoMisionSiglas = CodigoTipoMisionSiglas::get();
        //B1-TRIPULACION
        $A1_mision = Fam0001A1Mision::get();
        $funcion = FuncionTripulante::get();
        $despegue = CodigoDespegue::get(); 

        $fam0001 = $fam_id;
        return view('forms.FAM0001_estatus', compact('fam0001','codigoTipoMisionSiglas','despegue','funcion','A1_mision','codigoMision','consumibles','unidadesMedida','enApoyo','vueloOrdenadaPor','jefeMaquina', 'aeronaveModelos','matriculas','unidad','componentes', 'bases'));
    
    }

    public function index()
    {
        //HEADER
        $aeronaveModelos = AeronaveModelo::get();
        $matriculas = AeronaveMatricula::get();
        $unidad = AeronaveUnidades::get();
        $componentes = ComponenteOrganismo::get();
        $bases = Base::get();
        $jefeMaquina = EmpleadoFuncion::with('empleado')->where('id_funcion', 16)->get();
        //A1-MISION
        $vueloOrdenadaPor = VueloOrdenadaPor::get();
        $enApoyo = VueloEnApoyo::get();
        $consumibles = UnidadesConsumible::get();
        $unidadesMedida = UnidadesMedidas::get();
        $codigoMision = CodigoTipoMision::orderBy('codigo', 'asc')->get();
        $codigoTipoMisionSiglas = CodigoTipoMisionSiglas::get();
        //B1-TRIPULACION
        $A1_mision = Fam0001A1Mision::get();
        $funcion = FuncionTripulante::get();
        $despegue = CodigoDespegue::get();

        //dd($jefeMaquina);
        return view('forms.index', compact('codigoTipoMisionSiglas','despegue','funcion','A1_mision','codigoMision','consumibles','unidadesMedida','enApoyo','vueloOrdenadaPor','jefeMaquina', 'aeronaveModelos','matriculas','unidad','componentes', 'bases'));
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

    public function steps(Request $request)
    {
        $headerData = Fam0001::where('id',$request->data_id)->get();
        $A1_data = Fam0001A1Mision::where('completado',"paso2")->where('fam0001_id',$request->data_id)->where('user_id',auth()->id())->get();
        $B1_data = Fam0001B1Tripulacion::with('funcionTrip')->where('completado',"paso3")->where('fam0001_id',$request->data_id)->where('user_id',auth()->id())->get();
        $A3_data = Fam0001A3CargaPasajeros::where('completado',"paso4")->where('fam0001_id',$request->data_id)->where('user_id',auth()->id())->get();
        return response()->json([
            "headerData"=>$headerData, 
            "A1_data"=>$A1_data,
            "B1_data"=>$B1_data,
            "A3_data"=>$A3_data,
        ]);
    }
    public function steps_status(Request $request)
    {
        $headerData = Fam0001::where('id',$request->data_id)->get();
        $A1_data = Fam0001A1Mision::where('fam0001_id',$request->data_id)->where('user_id',auth()->id())->get();
        $B1_data = Fam0001B1Tripulacion::with('funcionTrip')->where('fam0001_id',$request->data_id)->where('user_id',auth()->id())->get();
        $A3_data = Fam0001A3CargaPasajeros::where('fam0001_id',$request->data_id)->where('user_id',auth()->id())->get();
        return response()->json([
            "headerData"=>$headerData, 
            "A1_data"=>$A1_data,
            "B1_data"=>$B1_data,
            "A3_data"=>$A3_data,
        ]);
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
        
        $fam0001->user_id = auth()->id();

        $fam0001->save();

        $dataFam001 = [
            "id" => $fam0001->id,
            "ov_ota_om" => $request->ov_ota_om, 
        ];
            
        //return response()->json($request);
        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'data' => $dataFam001,
            ]
        );
    }

    public function editar_paso1(Request $request)
    {
        $editPaso1 = Fam0001::where('id', $request->id)->update($request->except('id'));

        return response()->json([
                'success' => true,
                'message' => 'Data',
                'editMision' => $editPaso1
            ]
        );
    } 

    public function store_a1(Request $request)
    {
        $checkVuelo = Fam0001A1Mision::select('vuelo')->where('fam0001_id',$request->fam0001_id)->get();
       
        $flyLoop = count($checkVuelo);

        $A1 = new Fam0001A1Mision;
        $A1->vuelo = $flyLoop < 1 ? $A1->vuelo = 1: $A1->vuelo = $flyLoop + 1;

        $A1->ordenada_por = $request->ordenada_por;
        $A1->en_apoyo = $request->en_apoyo;
        $A1->codigo = $request->codigo;
        $A1->ruta_desde = $request->ruta_desde;
        $A1->ruta_hasta = $request->ruta_hasta;
        $A1->encend = $request->encend;
        $A1->despeg = $request->despeg;
        $A1->aterriz = $request->aterriz;
        $A1->apag = $request->apag;
        $A1->registro_manual = $request->registro_manual;
        $A1->horometro = $request->horometro;
        $A1->ind_vuelo = $request->ind_vuelo;
        $A1->toque_desp = $request->toque_desp;
        $A1->low_go = $request->low_go;
        $A1->ciclos_tren = $request->ciclos_tren;
        $A1->ov_ota_om = $request->ov_ota_om;
        $A1->fam0001_id = $request->fam0001_id;

        $A1->en_apoyo_A2 = $request->en_apoyo_A2;
        $A1->descripcion_A2 = $request->descripcion_A2;
    
        $A1->completado = $request->completado;

        $A1->user_id = auth()->id();
        $A1->save();

        $A1_id = Fam0001A1Mision::select('id')->where('id',$A1->id)->get();
        $A1_data = Fam0001A1Mision::where('fam0001_id',$request->fam0001_id)->get();
   
        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'data' => $A1_data,
                'A1_id' => $A1_id
            ]
        );

    }

    public function consumibles()
    {
        $consumibles = UnidadesConsumible::get();
        $unidades = UnidadesMedidas::get();
        return response()->json(["consumibles"=>$consumibles, "unidades"=>$unidades]);
    }

    public function store_a1_consumibles(Request $request)
    {

        $loop = count($request->consumiblesDATA);

        for ($i=0; $i < $loop; $i++) { 
            $A1_cosumibles = new Fam0001A1MisionConsumible;
            $A1_cosumibles->ov_ota_om = $request->consumiblesDATA[$i]['ov_ota_om'];
            $A1_cosumibles->fam0001_id = $request->consumiblesDATA[$i]['fam0001_id'];
            $A1_cosumibles->fam0001_a1_mision_id = $request->consumiblesDATA[$i]['fam0001_a1_mision_id'];

            $A1_cosumibles->consumible = $request->consumiblesDATA[$i]['consumiblesArray'];
            $A1_cosumibles->unidad = $request->consumiblesDATA[$i]['unidadesArray'];
            $A1_cosumibles->cantidad = $request->consumiblesDATA[$i]['cantidad'];

            $A1_cosumibles->save();
        
        }
        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'data' => $loop
            ]
        );
    }

    public function delete_a1_mision(Request $request)
    {
        Fam0001A1MisionConsumible::where('fam0001_a1_mision_id',$request->id)->delete();
        Fam0001A1Mision::find($request->id)->delete();
        
        return response()->json([
                'success' => true,
                'message' => 'Data Eliminada'
            ]
        );
    } 

    public function editar_a1_mision(Request $request)
    {
        $consumibles = Fam0001A1MisionConsumible::where('fam0001_a1_mision_id', $request->id)->get();
        $editFam = Fam0001A1Mision::where('id', $request->id)->with('consumibles')->get();
        return response()->json([
                'success' => true,
                'message' => 'Data',
                'data' => $editFam,
                'consumibles' => $consumibles,
            ]
        );
    }

    public function actualizar_a1_mision(Request $request)
    {
        $editMision = Fam0001A1Mision::where('id', $request->id)->update($request->except('id'));

        // $loop = count($request->consumiblesDATA);
        // if($loop>0){
        //     for ($i=0; $i < $loop; $i++) { 
        //         $updateConsumibles = Fam0001A1MisionConsumible::where('id', $request->id_consumible)->update($request->except('id'));     
        //     }
        // }

        return response()->json([
                'success' => true,
                'message' => 'Data',
                'editMision' => $editMision
            ]
        );
    } 

    public function codigos_mision_json()
    {
        $codigoMision = CodigoTipoMision::orderBy('codigo', 'asc')->get();
        $codigoTipoMisionSiglas = CodigoTipoMisionSiglas::get();
        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'siglas'  => $codigoTipoMisionSiglas,
                'codigo'  => $codigoMision,
            ]
        );
    }

    public function tripulante_funcion(Request $request)
    {
        $empleadoCargo = EmpleadoFuncion::with('empleado')
            ->join('nomina','nomina.codigo_empleado','=','empleado_funcion.codigo_empleado')
            ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
            ->orderBy('nomina.grado_militar', 'asc')
            ->where('id_funcion', $request->id_funcion)
            ->select(
                'empleado_funcion.*',
                'grados_militares.siglas'
            )
            ->get();
        return response()->json($empleadoCargo);
    }

    public function data_vuelo(Request $request)
    {
        $data_vuelo = Fam0001A1Mision::where('id', $request->id)->where('completado','<>','completado')->where('user_id',auth()->id())->get();
        return response()->json($data_vuelo);
    }

    public function data_v_trip(Request $request)
    {
        $data_v_trip = Fam0001A1Mision::where('fam0001_id', $request->id)->get();
        return response()->json($data_v_trip);
    }

    public function codigos_aterrizaje_json()
    {
        $codigoAterrizaje = CodigoAterrizaje::get();
        return response()->json(
            [
                'success' => true,
                'message' => 'Data send successfully',
                'codigo'  => $codigoAterrizaje,
            ]
        );
    }

    public function datos_empleado_vuelo(Request $request)
    {
        $datosEmpleado = EmpleadoFuncion::with('empleado')->where('id', $request->id)->get();
        //$datosEmpleado = Nomina::with('empleado')->where('codigo_empleado', $request->id)->get();
        return response()->json(
            [
                'success' => true,
                'message' => 'Data send successfully',
                'data'  => $datosEmpleado,
            ]
        );
    }

    public function store_b1(Request $request)
    {
        
        $B1_funcion = Fam0001B1Tripulacion::select('codigo_funcion')
            ->where('v_trip',$request->v_trip)
            ->where('fam0001_id',$request->fam0001_id)
            ->where('fam0001_a1_mision_id',$request->fam0001_a1_mision_id)
            ->where('codigo_funcion','P')
            //->where('completado','<>','completado')
            ->where('user_id',auth()->id())
            ->get();

        if (count($B1_funcion)>0) {
            $B1_data = Fam0001B1Tripulacion::where('fam0001_id',$request->fam0001_id)->get();
            if($request->codigo_funcion == $B1_funcion[0]['codigo_funcion']){
                return response()->json(
                    [
                        'error' => true,
                        'data' => $B1_data,
                    ]
                );
            }else {
                $B1 = new Fam0001B1Tripulacion;

                $B1->ov_ota_om = $request->ov_ota_om;
                $B1->fam0001_id = $request->fam0001_id;
                $B1->fam0001_a1_mision_id = $request->fam0001_a1_mision_id;
                $B1->v_trip = $request->v_trip;

                $B1->grado_nombre_id = $request->grado_nombre_id;
                $B1->grado_nombre_data = $request->grado_nombre_data;
                
                $B1->cedula = $request->cedula;

                $B1->codigo_funcion = $request->codigo_funcion;
                $B1->funcion = $request->funcion;

                $B1->tipo_despegue = $request->tipo_despegue;

                $B1->COD = $request->COD;
                $B1->hv = $request->HV;
                
                $B1->completado = $request->completado;
                $B1->user_id = auth()->id();
                $B1->save();
                
                $B1_data = Fam0001B1Tripulacion::where('fam0001_id',$request->fam0001_id)->get();
                $B1_id = Fam0001B1Tripulacion::select('id')->where('id',$B1->id)->get();
    
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Data inserted successfully',
                        'data' => $B1_data,
                        'B1_id' => $B1_id
                    ]
                );
            }
        }else {
            $B1 = new Fam0001B1Tripulacion;

            $B1->ov_ota_om = $request->ov_ota_om;
            $B1->fam0001_id = $request->fam0001_id;
            $B1->fam0001_a1_mision_id = $request->fam0001_a1_mision_id;
            $B1->v_trip = $request->v_trip;

            $B1->grado_nombre_id = $request->grado_nombre_id;
            $B1->grado_nombre_data = $request->grado_nombre_data;
            
            $B1->cedula = $request->cedula;

            $B1->codigo_funcion = $request->codigo_funcion;
            $B1->funcion = $request->funcion;

            $B1->tipo_despegue = $request->tipo_despegue;

            $B1->COD = $request->COD;
            $B1->hv = $request->HV;
            
            $B1->completado = $request->completado;
            $B1->user_id = auth()->id();
            $B1->save();
            
            $B1_data = Fam0001B1Tripulacion::where('fam0001_id',$request->fam0001_id)->get();
            $B1_id = Fam0001B1Tripulacion::select('id')->where('id',$B1->id)->get();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data inserted successfully',
                    'data' => $B1_data,
                    'B1_id' => $B1_id
                ]
            );
        }

    }

    public function store_aterrizaje(Request $request)
    {

        $loop = count($request->aterrizajeData);

        for ($i=0; $i < $loop; $i++) { 
            $B1_aterrizajes = new Fam0001B1TripulacionAterrizajes;

            $B1_aterrizajes->ov_ota_om = $request->aterrizajeData[$i]['ov_ota_om'];
            $B1_aterrizajes->fam0001_id = $request->aterrizajeData[$i]['fam0001_id'];
            $B1_aterrizajes->fam0001_a1_mision_id = $request->aterrizajeData[$i]['fam0001_a1_mision_id'];

            $B1_aterrizajes->TIP_ATERRIZAJE = $request->aterrizajeData[$i]['TIP_ATERRIZAJE'];
            $B1_aterrizajes->CANTIDAD = $request->aterrizajeData[$i]['CANTIDAD'];

            $B1_aterrizajes->save();
        
        }
        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'data' => $loop
            ]
        );
    }

    public function editar_b1(Request $request)
    {
        $editTrip = Fam0001B1Tripulacion::where('id', $request->id)->get();
        return response()->json([
                'success' => true,
                'message' => 'Data',
                'data' => $editTrip,
            ]
        );
    }

    public function actualizar_b1(Request $request)
    {
        $editTrip = Fam0001B1Tripulacion::where('id', $request->id)->update($request->except('id'));

        return response()->json([
                'success' => true,
                'message' => 'Data',
                'editTrip' => $editTrip
            ]
        );
    } 

    public function delete_b1(Request $request)
    {
        //Fam0001A1MisionConsumible::where('fam0001_a1_mision_id',$request->id)->delete();
        Fam0001B1Tripulacion::find($request->id)->delete();
        
        return response()->json([
                'success' => true,
                'message' => 'Data Eliminada'
            ]
        );
    } 

    public function store_a3(Request $request)
    {

        $A3 = new Fam0001A3CargaPasajeros;

        $A3->ov_ota_om = $request->ov_ota_om;
        $A3->fam0001_id = $request->fam0001_id;
        $A3->fam0001_a1_mision_id = $request->fam0001_a1_mision_id;
        
        $A3->n_vuelo = $request->n_vuelo;
        $A3->apoyo_carga = $request->apoyo_carga;
       
        $A3->pesocargaTotal = $request->pesocargaTotal;
        $A3->volCargaTotal = $request->volCargaTotal;

        $A3->seca = $request->seca;
        $A3->liquida = $request->liquida;
        $A3->comb = $request->comb;
        $A3->ammto = $request->ammto;
        $A3->tox_pel = $request->tox_pel;

        $A3->mil = $request->mil;
        $A3->gob = $request->gob;
        $A3->no_gob = $request->no_gob;
        $A3->civil = $request->civil;

        $A3->cant_animales = $request->cant_animales;
        $A3->carga = $request->carga;
        $A3->pers = $request->pers;
        
        $A3->completado = $request->completado;
        $A3->user_id = auth()->id();

        $A3->save();
        
        $A3_data = Fam0001A3CargaPasajeros::where('fam0001_id',$request->fam0001_id)->get();
        // $A3_id = Fam0001B1Tripulacion::select('id')->where('id',$A3->id)->get();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'data' => $A3_data,
            ]
        );
    }

    public function delete_a3(Request $request)
    {
        Fam0001A3CargaPasajeros::find($request->id)->delete();
        return response()->json([
                'success' => true,
                'message' => 'Data Eliminada'
            ]
        );
    } 

    public function editar_a3(Request $request)
    {
        $editA3 = Fam0001A3CargaPasajeros::where('id', $request->id)->get();
        return response()->json([
                'success' => true,
                'message' => 'Data',
                'data' => $editA3,
            ]
        );
    }
    public function actualizar_a3(Request $request)
    {
        $updateA3 = Fam0001A3CargaPasajeros::where('id', $request->id)->update($request->except('id'));
        return response()->json([
                'success' => true,
                'message' => 'Data',
                'updateA3' => $updateA3
            ]
        );
    } 
    public function pasoFinal(Request $request)
    {
        $id_fam0001 = $request->id_fam0001;
        $get_data = Fam0001A1Mision::where('fam0001_id',$id_fam0001)->get();
        $count_date = count($get_data);
        $total_registro_manual = 0; 
        $total_ind_vuelo = 0; 
        $total_toque_desp = 0; 
        $total_low_go = 0; 
        $total_aterriz = 0; 
        $total_ciclos_tren = 0; 
        $total_consumibles = 0; 
        for ($i=0; $i < $count_date; $i++) { 
            $total_registro_manual += $get_data[$i]['registro_manual'];
            $total_ind_vuelo += $get_data[$i]['ind_vuelo'];
            $total_toque_desp += $get_data[$i]['toque_desp'];
            $total_low_go += $get_data[$i]['low_go'];
            //$total_aterriz += $get_data[$i]['total_aterriz'];
            $total_ciclos_tren += $get_data[$i]['ciclos_tren'];
            //$total_consumibles += $get_data[$i]['total_consumibles'];
        }
        $FAM0001 = Fam0001::where('completado',"paso1")->where('id',$id_fam0001)->where('user_id',auth()->id())->update([
            'total_registro_manual' => $total_registro_manual, 
            'total_ind_vuelo' => $total_ind_vuelo, 
            'total_toque_desp' => $total_toque_desp, 
            'total_low_go' => $total_low_go, 
            'total_aterriz' => $total_aterriz, 
            'total_ciclos_tren' => $total_ciclos_tren, 
            //'total_consumibles' => $total_consumibles, 
            'completado' => 'completado',
        ]);
        $A1_data = Fam0001A1Mision::where('completado',"paso2")->where('fam0001_id',$id_fam0001)->where('user_id',auth()->id())->update([
            'completado' => 'completado'
        ]);
        $B1_data = Fam0001B1Tripulacion::where('completado',"paso3")->where('fam0001_id',$id_fam0001)->where('user_id',auth()->id())->update(['completado' => 'completado']);
        $A3_data = Fam0001A3CargaPasajeros::where('completado',"paso4")->where('fam0001_id',$id_fam0001)->where('user_id',auth()->id())->update(['completado' => 'completado']);
        return response()->json([
                'success' => true,
                'message' => 'Data',
                'FAM0001' => $FAM0001,
                'A1_data' => $A1_data,
                'B1_data' => $B1_data,
                'A3_data' => $A3_data
            ]
        );
    }

    public function listado_pilotos(){
        return view('forms.listado_pilotos');
    }

    //DATA TABLE PARA LLAMAR A LOS PILOTOS QUE TIENEN VUELOS COMPLETADOS
    public function data_pilotos(){
        $pilotos = Empleado::where('empleados.situacion','A'); 
        $pilotos->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $pilotos->join('empleado_funcion','empleado_funcion.codigo_empleado','=','empleados.codigo_empleado');
        $pilotos->join('funcion_tripulante','funcion_tripulante.id','=','empleado_funcion.id_funcion');
        $pilotos->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $pilotos->where('funcion_tripulante.codigo','P');
        
        $pilotos->select(
            'empleados.id',
            'empleados.codigo_empleado',
            'empleados.cedula',
            'empleados.nombre1',
            'empleados.apellido1',
            'grados_militares.siglas as grado',
        );

        $datatable= DataTables::of($pilotos)
            ->addColumn('actions', 'forms._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function ver_listado_piloto($id){
        $user_auth=auth()->user();
      
        $funcion_tripulante = FuncionTripulante::all();
        $grados_militares = GradosMilitares::all();
        $ubicaciones = Ubicaciones::all();
        $datos = Empleado::with(['nomina'])->find($id);

        return view('forms.ver_listado_piloto', 
            compact(
                'datos','funcion_tripulante','grados_militares','ubicaciones'
            )
        );
    }

    //DATA TABLE PARA VER LOS VUELOS COMPLETADOS DEL PILOTO
    public function verListadoPilotoData($cedula){
        $piloto = Fam0001B1Tripulacion::where('fam0001_b1_tripulacion.cedula','=',$cedula)
        ->join('empleados','empleados.cedula','=','fam0001_b1_tripulacion.cedula')
        ->join('fam0001','fam0001.id','=','fam0001_b1_tripulacion.fam0001_id')
        ->join('bases','bases.id','=','fam0001.base_estacion')
        ->join('aeronave_modelo','aeronave_modelo.id','=','fam0001.aeronave_modelo')
        ->where('fam0001_b1_tripulacion.completado','completado')
        ->where('fam0001_b1_tripulacion.codigo_funcion','P')
        ->select(
            'fam0001_b1_tripulacion.cedula',
            'bases.descripcion as base',
            'fam0001.unidad',
            'aeronave_modelo.aeronave as aeronave',
            'fam0001.serial',
            'fam0001.matricula',
            'fam0001.fecha'
        );

        $datatable= DataTables::of($piloto);
        return $datatable->make(true);
    }

    public function reporte_vuelos($id) {
        $user_auth=auth()->user();

        $datos = Empleado::find($id);
        return view('forms.reporte_vuelos',
            compact(
                'datos'
            )
        );
    }

    public function imprimir_reporte(Request $request) {
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
        $piloto = Fam0001B1Tripulacion::where('fam0001_b1_tripulacion.cedula','=',$request->cedula)
        ->join('fam0001','fam0001.id','=','fam0001_b1_tripulacion.fam0001_id')
        ->leftjoin('aeronave_modelo','aeronave_modelo.id','=','fam0001.aeronave_modelo')
        ->join('empleados','empleados.cedula','=','fam0001_b1_tripulacion.cedula')
        ->join('empleado_funcion','empleado_funcion.codigo_empleado','=','empleados.codigo_empleado')
        ->join('funcion_tripulante','funcion_tripulante.id','=','empleado_funcion.id_funcion')
        ->join('datos_militares','datos_militares.codigo_empleado','=','empleados.codigo_empleado')
        ->leftjoin('especialidades_militares','especialidades_militares.codigo_especialidad','=','datos_militares.codigo_especialidad1')
        ->where('empleado_funcion.id_funcion','=',3)
        ->where('fam0001_b1_tripulacion.codigo_funcion','=','P')
        ->whereBetween('fam0001.fecha',[$request->desde,$request->hasta])
        ->select(
            'fam0001_b1_tripulacion.grado_nombre_data as nombre',
            'fam0001_b1_tripulacion.cedula as cedula',
            'funcion_tripulante.funcion as nombre_funcion',
            'especialidades_militares.descripcion as especialidad',
            'fam0001.componente_organismo as organismo',
            'fam0001.unidad as unidad',
            'fam0001.fecha as fecha',
            'aeronave_modelo.aeronave as aeronave',
            'aeronave_modelo.modelo as modelo',
            'fam0001_b1_tripulacion.COD as COD',
            'fam0001_b1_tripulacion.codigo_funcion as funcion',
            'fam0001_b1_tripulacion.hv as hv',
            'fam0001.total_aterriz as aterriz'
        )
        ->orderBy('fam0001.fecha','asc')
        ->get();
        //dd($piloto);
        
        $anteriores = Fam0001B1Tripulacion::where('fam0001_b1_tripulacion.cedula','=',$request->cedula)
        ->join('fam0001','fam0001.id','=','fam0001_b1_tripulacion.fam0001_id')
        ->where('fam0001_b1_tripulacion.codigo_funcion','=','P')
        ->whereNotBetween('fam0001.fecha',[$request->desde,$request->hasta])
        ->select(
            'fam0001_b1_tripulacion.hv as hv',
            'fam0001.total_aterriz as aterriz'
        )
        ->orderBy('fam0001.fecha','asc')
        ->get();
        //dd($anteriores);
        
        $pdf = \PDF::loadview('forms.imprimir_reporte', compact('piloto', 'anteriores'));

        return $pdf->stream('REPORTE.pdf');
        //return view('forms.imprimir_reporte', compact('piloto'));
    }
}
