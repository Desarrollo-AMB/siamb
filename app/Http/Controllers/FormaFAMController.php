<?php

namespace App\Http\Controllers;

use App\Exports\ProgramacionFinExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use App\Models\AeronaveUnidades;
use App\Models\AeronaveModelo;
use App\Models\AeronaveMatricula;
use App\Models\ComponenteOrganismo;
use App\Models\Base;
use App\Models\Aeropuerto;
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
use App\Models\ProgramacionVuelo;
use App\Models\Fam0001A3CargaPasajeros;
use App\Models\Fam0001B1TripulacionAterrizajes;
use App\Models\GradosMilitares;
use App\Models\Ubicaciones;
use DataTables;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProgramacionVueloExport;
use App\Exports\ProgramacionVueloVExport;
use App\Models\Parroquias;
use App\Models\ProgramacionFin;
use App\Models\ParteAeronave;
use Illuminate\Http\Request;

class FormaFAMController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    public function daoIndex()
    {

        date_default_timezone_set('America/Caracas');

        $fecha = date('Y-m-d'); //Obtienes la fecha actual
        $user_id = auth()->id();
        $empleado = Empleado::where('user_id',$user_id)->with('data_empleado', 'user.rolesUser')->get();

        if(count($empleado)>0){
            $rol_user = $empleado[0]['user']['rolesUser'][0]['name'];
            $codigo_ubicacion = $empleado[0]['data_empleado']['codigo_ubicacion'];
            $ubicacion = AeronaveUnidades::where('codigo_ubicacion',$codigo_ubicacion)->get();

            // ROLL DE LA DAO
            if ($rol_user == 'aviacion_dao'|| $rol_user == 'cmd_general') {
                $fam0001_unidad = Fam0001::whereIn('completado', ['paso1', 'completado'])
                ->whereDate('fecha', $fecha)
                ->with('aeronaves')
                ->with('misiones')
                ->orderBy('unidad', 'desc')
                ->orderBy('matricula', 'desc')
                ->get();

                # Ordenar por unidad
                $fam0001 = [];
                foreach ($fam0001_unidad as $key => $value) {
                    $fam0001[$value['unidad']][] = $value;
                }

            }

            // SI TIENE UBIACION ES GRUPO AEREO
            elseif(count($ubicacion)>0){
                $fam0001 = Fam0001::whereIn('completado', ['paso1', 'completado'])
                ->whereDate('fecha', $fecha)
                ->where('unidad', $ubicacion[0]['codigos'])
                ->where('user_id',$user_id)
                ->with('aeronaves')
                ->with('misiones')
                ->orderBy('matricula', 'asc')
                ->get();
            }else{
                dd('este usuario no tiene ubicacion relacionada con las aeronaves en la BD');
            }
        }else{

            // SI NO ES ADMINISTRADOR
            $fam0001_unidad = Fam0001::whereIn('completado', ['paso1', 'completado'])
            ->whereDate('fecha', $fecha)
            ->with('aeronaves')
            ->with('misiones')
            ->orderBy('unidad', 'desc')
            ->orderBy('matricula', 'desc')
            ->get();

            # Ordenar por unidad
            $fam0001 = [];
            foreach ($fam0001_unidad as $key => $value) {
                $fam0001[$value['unidad']][] = $value;
            }
        }

        return view('dao.operacionesAereas.index', compact('fam0001'));

    }

    public function daoMilitar()
    {
        $user_id = auth()->id();
        $empleado = Empleado::where('user_id',$user_id)->with('data_empleado', 'user.rolesUser')->get();

        if(count($empleado)>0){
            $rol_user = $empleado[0]['user']['rolesUser'][0]['name'];
            $codigo_ubicacion = $empleado[0]['data_empleado']['codigo_ubicacion'];
        } else {
            $rol_user = 'administrador';
            $codigo_ubicacion = 0;
        }

        $funcionEmpleado = FuncionTripulante::get();
        return view('dao.personal.militar.index',
            compact(
                'funcionEmpleado', 'rol_user', 'codigo_ubicacion'
            )
        );
    }

    public function daoAeronaves()
    {
        $user_id = auth()->id();
        $empleado = Empleado::where('user_id',$user_id)->with('data_empleado', 'user.rolesUser')->get();

        if(count($empleado)>0){
            $rol_user = $empleado[0]['user']['rolesUser'][0]['name'];
            $codigo_ubicacion = $empleado[0]['data_empleado']['codigo_ubicacion'];
            $ubicacion = AeronaveUnidades::where('codigo_ubicacion',$codigo_ubicacion)->get();

            if ($rol_user == 'aviacion_dao'|| $rol_user == 'cmd_general') {
                $aeronaves = DB::table('aeronave_matricula')
                ->join('aeronave_modelo', 'aeronave_matricula.aeronave_id', '=', 'aeronave_modelo.id')
                ->select(
                    'aeronave_matricula.id as id',
                    'aeronave_matricula.matricula as matricula',
                    'aeronave_matricula.serial as serial',
                    'aeronave_matricula.estatus as estatus',
                    'aeronave_matricula.porcentaje_disponibilidad as porcentaje',
                    'aeronave_matricula.observacion as observacion',
                    'aeronave_modelo.id as aeronave_id',
                    'aeronave_modelo.aeronave as aeronave',
                    'aeronave_modelo.codigo_unidad as codigo_unidad',
                    'aeronave_modelo.modelo as modelo')
                    ->orderByRaw("FIELD(aeronave_modelo.codigo_unidad, 'G-4', 'G-5', 'G-6', 'G-7', 'G-8', 'G-9', 'G-10', 'G-11', 'G-12', 'G-13', 'G-14', 'G-15', 'G-16', 'G-17', 'G-18', 'G-19')")

                ->get();
            }
            elseif(count($ubicacion)>0){
                $aeronaves = DB::table('aeronave_matricula')
                ->join('aeronave_modelo', 'aeronave_matricula.aeronave_id', '=', 'aeronave_modelo.id')
                ->where('codigo_unidad', $ubicacion[0]['codigos'])
                ->select(
                    'aeronave_matricula.id as id',
                    'aeronave_matricula.matricula as matricula',
                    'aeronave_matricula.serial as serial',
                    'aeronave_matricula.estatus as estatus',
                    'aeronave_matricula.porcentaje_disponibilidad as porcentaje',
                    'aeronave_matricula.observacion as observacion',
                    'aeronave_modelo.id as aeronave_id',
                    'aeronave_modelo.aeronave as aeronave',
                    'aeronave_modelo.codigo_unidad as codigo_unidad',
                    'aeronave_modelo.modelo as modelo')


                ->get();
            }else{
                dd('este usuario no tiene ubicacion relacionada con las aeronaves en la BD');
            }

        }else{
            $aeronaves = DB::table('aeronave_matricula')
                ->join('aeronave_modelo', 'aeronave_matricula.aeronave_id', '=', 'aeronave_modelo.id')
                ->select(
                    'aeronave_matricula.id as id',
                    'aeronave_matricula.matricula as matricula',
                    'aeronave_matricula.serial as serial',
                    'aeronave_matricula.estatus as estatus',
                    'aeronave_matricula.porcentaje_disponibilidad as porcentaje',
                    'aeronave_matricula.observacion as observacion',
                    'aeronave_modelo.id as aeronave_id',
                    'aeronave_modelo.aeronave as aeronave',
                    'aeronave_modelo.codigo_unidad as codigo_unidad',
                    'aeronave_modelo.modelo as modelo')
                    ->orderByRaw("FIELD(aeronave_modelo.codigo_unidad, 'G-4', 'G-5', 'G-6', 'G-7', 'G-8', 'G-9', 'G-10', 'G-11', 'G-12', 'G-13', 'G-14', 'G-15', 'G-16', 'G-17', 'G-18', 'G-19')")

                ->get();
        }

        return view('dao.aeronaves.index',
            compact(
                'aeronaves'
            )
        );
    }

    public function editDisponAeronaves($id)
    {
        $aeronave = DB::table('aeronave_matricula')
                ->where('aeronave_matricula.id', '=', $id)
                ->join('aeronave_modelo', 'aeronave_matricula.aeronave_id', '=', 'aeronave_modelo.id')
                ->select(
                    'aeronave_matricula.id as id',
                    'aeronave_matricula.matricula as matricula',
                    'aeronave_matricula.serial as serial',
                    'aeronave_matricula.estatus as estatus',
                    'aeronave_matricula.porcentaje_disponibilidad as porcentaje',
                    'aeronave_matricula.observacion as observacion',
                    'aeronave_modelo.aeronave as aeronave',
                    'aeronave_modelo.modelo as modelo')
                ->get();

        $aeronave = $aeronave[0];

        return view('dao.aeronaves.edit',
            compact(
                'aeronave'
            )
        );
    }


    //Obtiene el personal militar, exclusivo por api para el Datatable
    public function personalMilitarDao(Request $request){

        $rolUser = $request->input('rolUser');
        $codigoUbicacion = $request->input('codigoUbicacion');
        //$user_id = auth()->id();
        $numero= 1;
        //$empleado = Empleado::where('user_id',$user_id)->with('data_empleado', 'user.rolesUser')->get();

        $empleados = Empleado::where('empleados.situacion','A');
        $empleados->leftJoin('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->leftJoin('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->leftJoin('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->leftJoin('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MIL','MEX','TRP']);

        if($rolUser === 'aviacion_dao'|| $rolUser == 'cmd_general'){
            //$empleados->whereIn('ubicaciones.codigo_ubicacion',[2011, 2012, 2023, 4041, 1022, 2072, 2024, 2022, 2031, 2041, 7285, 4004, 2051, 2021, 7015, 8696, 8697, 2210, 8752]);

            // CON CODIGOS DE PRODUCCION
            $empleados->whereIn('ubicaciones.codigo_ubicacion', ['0010', '0408', '0409', '0410', '0411', '0412', '0413', '0414', '0415', '0416', '0417', '0418', '0419', '0420', '0421', '0428', '0429']);

        } elseif($rolUser === 'aviacion_grupo_aereo'){
            $empleados->where('ubicaciones.codigo_ubicacion',$codigoUbicacion);

        } elseif($rolUser === 'administrador'){
            //$empleados->whereIn('ubicaciones.codigo_ubicacion',[2011, 2012, 2023, 4041, 1022, 2072, 2024, 2022, 2031, 2041, 7285, 4004, 2051, 2021, 7015, 8696, 8697, 2210, 8752]);

            // CON CODIGOS DE PRODUCCION
            $empleados->whereIn('ubicaciones.codigo_ubicacion', ['0010', '0408', '0409', '0410', '0411', '0412', '0413', '0414', '0415', '0416', '0417', '0418', '0419', '0420', '0421', '0428', '0429']);
        }



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


        $datatable= Datatables::of($empleados)
            ->addColumn('actions', 'dao.personal.militar._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function nuevaProgramacion()
    {
        //HEADER
        // Se obtiene el id del usuario logueado para luego obtener el id del empleado y codigo de ubicacion
        // Con codigo de ubicacion se obtienen las aeronaves disponibles solo de ese grupo aereo
        $user_id = auth()->id();
        $empleado = Empleado::where('user_id',$user_id)->with('data_empleado', 'user.rolesUser')->get();
        if(count($empleado)>0){
            $codigo_ubicacion = $empleado[0]['data_empleado']['codigo_ubicacion'];
            $ubicacion = AeronaveUnidades::where('codigo_ubicacion',$codigo_ubicacion)->get();

            if(count($ubicacion)>0){
                $unidad = $ubicacion;
                $aeronaveModelos = AeronaveModelo::where('codigo_unidad',$unidad[0]->codigos)->get();
                $matriculas = AeronaveMatricula::whereIn('estatus',['DISPONIBLE', 'DISPONIBLE PARA EL COMBATE', 'INDISPONIBLE'])->get();
                $vinvuloGrupoAereo = Config::get('constants.vinvulo_grupo_aereo');

                if (isset($vinvuloGrupoAereo[$unidad[0]->codigos])) {
                    $nomenclaturaUnidad = $vinvuloGrupoAereo[$unidad[0]->codigos];
                } else {
                    $nomenclaturaUnidad = ''; // Manejar el caso en que no se encuentre la unidad en la constante
                }


            }else{
                dd('este usuario no tiene ubicacion relacionada con las aeronaves en la BD');
            }
        }else{
            dd('este usuario no tiene acceso a esta area');
        }

        $componentes = ComponenteOrganismo::get();
        $bases = Base::get();
        $parroquias = Parroquias::get();
        $aeropuertos = Aeropuerto::get();
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

        $clasificacion = Config::get('constants.clasificacion_cargo');

        return view('dao.operacionesAereas.programacionVuelo.create', compact('clasificacion','codigoTipoMisionSiglas','despegue','funcion','A1_mision','codigoMision','consumibles','unidadesMedida','enApoyo','vueloOrdenadaPor','jefeMaquina', 'aeronaveModelos','matriculas','unidad','componentes', 'bases', 'aeropuertos', 'nomenclaturaUnidad','parroquias'));
    }

    public function imprimirProgramacion($tipo) {

        Carbon::setLocale('es');
        $nombre_mes = Carbon::now()->format('M');
        $nombre_mes_mayusculas = mb_strtoupper($nombre_mes);
        $hoy = Carbon::now();
        $mañana_condicion = $hoy->addDay();
        $mañana_condicion = $mañana_condicion->format('Y-m-d'); /*DECLARACION DE LA FECHA*/

        if($tipo == 'ce'){
            $vuelo = Fam0001::join('fam0001_a1_mision','fam0001_a1_mision.fam0001_id','=','fam0001.id')
            ->join('aeronave_modelo','aeronave_modelo.id','=','fam0001.aeronave_modelo')
            ->join('aeronave_unidad','aeronave_unidad.codigos','=','fam0001.unidad')
            ->where(function ($query) {
                $query->where('fam0001.completado', '=', 'revisado')
                    ->orWhere('fam0001.completado', '=', 'sinProg');
            })
            ->whereIn('fam0001.unidad', ['G-11', 'G-12', 'G-13', 'G-14', 'G-15', 'G-16', 'G-18', 'G-19'])
            ->whereDate('fam0001.fecha', '=', $mañana_condicion)
            ->select(
                'fam0001.unidad AS unidad',
                'fam0001.fecha AS fecha',
                'fam0001.base_estacion AS base_estacion',
                'aeronave_modelo.modelo AS aeronave_modelo',
                'fam0001.matricula AS matricula',
                'fam0001.matriculas_alternas AS matriculas_alternas',
                'fam0001_a1_mision.ordenada_por AS ordenada_por',
                'fam0001_a1_mision.codigo AS codigo',
                'fam0001_a1_mision.ruta_desde AS ruta_desde',
                'fam0001_a1_mision.ruta_hasta AS ruta_hasta',
                'fam0001_a1_mision.encend AS encend',
                'fam0001_a1_mision.apag AS apag',
                'fam0001.completado AS completado'
            )
            ->orderByRaw('aeronave_unidad.id ASC, fam0001_a1_mision.id ASC')
            ->get();

            $nombre_archivo = sprintf('01) PROGRAMACIÓN DE VUELO %s.xlsx', Carbon::now()->format('d') . $nombre_mes_mayusculas . Carbon::now()->format('y'));

        }else {
            $vuelo = Fam0001::join('fam0001_a1_mision','fam0001_a1_mision.fam0001_id','=','fam0001.id')
            ->join('aeronave_modelo','aeronave_modelo.id','=','fam0001.aeronave_modelo')
            ->join('aeronave_unidad','aeronave_unidad.codigos','=','fam0001.unidad')
            ->where(function ($query) {
                $query->where('fam0001.completado', '=', 'revisado')
                    ->orWhere('fam0001.completado', '=', 'sinProg');
            })
            ->whereIn('fam0001.unidad', ['G-4', 'G-5', 'G-6', 'G-8', 'G-9', 'G-10', 'G-17'])
            ->whereDate('fam0001.fecha', '=', $mañana_condicion)
            ->select(
                'fam0001.unidad AS unidad',
                'fam0001.fecha AS fecha',
                'fam0001.base_estacion AS base_estacion',
                'aeronave_modelo.modelo AS aeronave_modelo',
                'fam0001.matricula AS matricula',
                'fam0001.matriculas_alternas AS matriculas_alternas',
                'fam0001_a1_mision.ordenada_por AS ordenada_por',
                'fam0001_a1_mision.codigo AS codigo',
                'fam0001_a1_mision.ruta_desde AS ruta_desde',
                'fam0001_a1_mision.ruta_hasta AS ruta_hasta',
                'fam0001_a1_mision.encend AS encend',
                'fam0001_a1_mision.apag AS apag',
                'fam0001.completado AS completado'
            )
            ->orderByRaw('aeronave_unidad.id ASC, fam0001_a1_mision.id ASC')
            ->get();

            $nombre_archivo = sprintf('05) PROGRAMACIÓN DE VUELO GRUPOS DE TRANSPORTE %s.xlsx', Carbon::now()->format('d') . $nombre_mes_mayusculas . Carbon::now()->format('y'));
        }
        /*$mision = Fam0001A1Mision::all();*/

        if(!$vuelo){
            return back()
            ->with('warning','No se puede generar el reporte, no existen registros');
        }

        $hoy_titulo = $hoy->format('d-m-Y H:i:s');
        $titulo = 'PROGRAMACIÓN DE VUELOS '.$hoy_titulo;
        //dd($nombre_archivo);

        $data = compact('titulo','vuelo');
        //dd($nombre_archivo);

        return Excel::download(new ProgramacionVueloExport($data), $nombre_archivo);
        //return view('excel.programacion_vuelos', compact('titulo','vuelo'));
    }

    public function imprimirProgramacionGrupoAereo($unidad) {

        Carbon::setLocale('es');
        $nombre_mes = Carbon::now()->format('M');
        $nombre_mes_mayusculas = mb_strtoupper($nombre_mes);
        $hoy = Carbon::now();
        $mañana_condicion = $hoy->addDay();
        $mañana_condicion = $mañana_condicion->format('Y-m-d'); /*DECLARACION DE LA FECHA*/

        /*$mision = Fam0001A1Mision::all();*/
        $vuelo = Fam0001::join('fam0001_a1_mision','fam0001_a1_mision.fam0001_id','=','fam0001.id')
        ->join('aeronave_modelo','aeronave_modelo.id','=','fam0001.aeronave_modelo')
        ->join('aeronave_unidad','aeronave_unidad.codigos','=','fam0001.unidad')
        //->where('fam0001.completado','=','revisado')
        //->where('fam0001.completado','=','sinProg')
        ->where(function ($query) {
            $query->where('fam0001.completado', '=', 'revisado')
                ->orWhere('fam0001.completado', '=', 'sinProg');
        })
        ->where('fam0001.unidad', '=', $unidad)
        ->whereDate('fam0001.fecha', '=', $mañana_condicion)
        ->select(
            'fam0001.unidad AS unidad',
            'fam0001.fecha AS fecha',
            'fam0001.base_estacion AS base_estacion',
            'aeronave_modelo.modelo AS aeronave_modelo',
            'fam0001.matricula AS matricula',
            'fam0001.matriculas_alternas AS matriculas_alternas',
            'fam0001_a1_mision.ordenada_por AS ordenada_por',
            'fam0001_a1_mision.codigo AS codigo',
            'fam0001_a1_mision.ruta_desde AS ruta_desde',
            'fam0001_a1_mision.ruta_hasta AS ruta_hasta',
            'fam0001_a1_mision.encend AS encend',
            'fam0001_a1_mision.apag AS apag',
            'fam0001.completado AS completado'
        )
        ->orderByRaw('aeronave_unidad.id ASC, fam0001_a1_mision.id ASC')
        ->get();

        //dd($vuelo);

        if(!$vuelo){
            return back()
            ->with('warning','No se puede generar el reporte, no existen registros');
        }

        $hoy_titulo = $hoy->format('d-m-Y H:i:s');
        $titulo = 'PROGRAMACIÓN DE VUELOS '.$hoy_titulo;
        //dd($nombre_archivo);

        $nombre_archivo = sprintf('PROGRAMACIÓN DE VUELO %s.xlsx', Carbon::now()->format('d') . $nombre_mes_mayusculas . Carbon::now()->format('y'));

        $data = compact('titulo','vuelo');
        //dd($nombre_archivo);

        return Excel::download(new ProgramacionVueloExport($data), $nombre_archivo);
        //return view('excel.programacion_vuelos', compact('titulo','vuelo'));
    }

    public function imprimirProgramacionV($tipo) {

        Carbon::setLocale('es');
        $nombre_mes = Carbon::now()->format('M');
        $nombre_mes_mayusculas = mb_strtoupper($nombre_mes);
        $hoy = Carbon::now();
        $hoy_format = $hoy->format('Y-m-d');
        $mañana_condicion = $hoy->addDay();
        $mañana_condicion = $mañana_condicion->format('Y-m-d'); /*DECLARACION DE LA FECHA*/

        $checkProgramacion = ProgramacionVuelo::where('fecha', $mañana_condicion)
        ->get();

        $fecha_vigente = $checkProgramacion->isEmpty() ? $hoy_format : $mañana_condicion;
        $fecha_vigente_invertida = date('d-m-Y', strtotime($fecha_vigente));

        if($tipo == 'ce'){

            $programacion = ProgramacionVuelo::where('programacion_vuelo.fecha', $fecha_vigente)
                ->whereIn('programacion_vuelo.unidad', ['G-11','G-12','G-13','G-14','G-15','G-16','G-18','G-19'])
                ->join('aeronave_unidad','aeronave_unidad.codigos','=','programacion_vuelo.unidad')
                ->select(
                    'programacion_vuelo.unidad AS unidad',
                    'programacion_vuelo.fecha AS fecha',
                    'programacion_vuelo.sistema_matricula AS sistema_matricula',
                    'programacion_vuelo.matriculas_alternas AS matriculas_alternas',
                    'programacion_vuelo.ordenada_por AS ordenada_por',
                    'programacion_vuelo.mision_ruta AS mision_ruta',
                    'programacion_vuelo.salida AS salida',
                    'programacion_vuelo.retorno AS retorno',
                    'programacion_vuelo.militar AS militar',
                    'programacion_vuelo.civil AS civil',
                    'programacion_vuelo.carga AS carga',
                )
                ->orderByRaw('aeronave_unidad.id ASC, programacion_vuelo.fam0001_a1_mision_id ASC')
            ->get();

            $nombre_archivo = sprintf('01) PROGRAMACIÓN DE VUELO %s.xlsx', Carbon::now()->format('d') . $nombre_mes_mayusculas . Carbon::now()->format('y'));

        }else {
            $programacion = ProgramacionVuelo::where('programacion_vuelo.fecha', $fecha_vigente)
                ->whereIn('programacion_vuelo.unidad', ['G-4','G-5','G-6','G-8','G-9','G-10','G-17'])
                ->join('aeronave_unidad','aeronave_unidad.codigos','=','programacion_vuelo.unidad')
                ->select(
                    'programacion_vuelo.unidad AS unidad',
                    'programacion_vuelo.fecha AS fecha',
                    'programacion_vuelo.sistema_matricula AS sistema_matricula',
                    'programacion_vuelo.matriculas_alternas AS matriculas_alternas',
                    'programacion_vuelo.ordenada_por AS ordenada_por',
                    'programacion_vuelo.mision_ruta AS mision_ruta',
                    'programacion_vuelo.salida AS salida',
                    'programacion_vuelo.retorno AS retorno',
                    'programacion_vuelo.militar AS militar',
                    'programacion_vuelo.civil AS civil',
                    'programacion_vuelo.carga AS carga',
                )
                ->orderByRaw('aeronave_unidad.id ASC, programacion_vuelo.fam0001_a1_mision_id ASC')
            ->get();

            $nombre_archivo = sprintf('05) PROGRAMACIÓN DE VUELO GRUPOS DE TRANSPORTE %s.xlsx', Carbon::now()->format('d') . $nombre_mes_mayusculas . Carbon::now()->format('y'));
        }
        /*$mision = Fam0001A1Mision::all();*/

        if(!$programacion){
            return back()
            ->with('warning','No se puede generar el reporte, no existen registros');
        }

        $hoy_titulo = $fecha_vigente_invertida;
        $titulo = 'PROGRAMACIÓN DE VUELOS '.$hoy_titulo;
        //dd($nombre_archivo);

        $data = compact('titulo','programacion');
        //dd($nombre_archivo);

        return Excel::download(new ProgramacionVueloVExport($data), $nombre_archivo);
        //return view('excel.programacion_vuelos', compact('titulo','vuelo'));
    }

    public function editProgramacion($fam_id)
    {
        $bases = Base::get();
        $parroquias = Parroquias::get();
        $aeropuertos = Aeropuerto::get();
        $vueloOrdenadaPor = VueloOrdenadaPor::get();
        $codigoMision = CodigoTipoMision::orderBy('codigo', 'asc')->get();
        $codigoTipoMisionSiglas = CodigoTipoMisionSiglas::get();
        $A1_mision = Fam0001A1Mision::where('fam0001_id',$fam_id)->get();
        $comprobarAlertaA1 = Fam0001::where('id',$fam_id)
        ->select('alerta')
        ->get();
        $esAlerta = $comprobarAlertaA1[0]->alerta;

        foreach ($A1_mision as $mision) {
            if($mision->codigo == 'ALERTA'){
                $mision->codigo = 'ALERTA';
                $mision->siglas = 'ALERTA';
                $mision->numero = '';
            }elseif($mision->codigo == 'ENCENDIDO Y CHEQUEO EN TIERRA'){
                $mision->codigo = 'ENCENDIDO Y CHEQUEO EN TIERRA';
                $mision->siglas = 'ENCENDIDO Y CHEQUEO EN TIERRA';
                $mision->numero = '';
            } elseif(substr($mision->codigo, 0, 2) == "AC"){
                $codigo = $mision->codigo;
                $siglas = substr($codigo, 0, 2);
                $numero = substr($codigo, 3);
                $mision->siglas = $siglas;
                $mision->numero = $numero;
            }
            else{
                $codigo = $mision->codigo;
                $siglas = substr($codigo, 0, 1);
                $numero = substr($codigo, 2);
                $mision->siglas = $siglas;
                $mision->numero = $numero;
            }
        }
        $headerFam0001 = Fam0001::where('id',$fam_id)->with('aeronaves')->get();
        $matriculas = AeronaveMatricula::whereIn('estatus',['DISPONIBLE', 'DISPONIBLE PARA EL COMBATE', 'INDISPONIBLE'])->whereNotIn('matricula', [$headerFam0001[0]->matricula])->where('aeronave_id', [$headerFam0001[0]->aeronave_modelo])->get();
        /*$baseSelect = Base::where('id',$headerFam0001[0]->base_estacion)->get();
        $baseSelect = $baseSelect[0];*/
        $fam0001 = $fam_id;

        $ubicacion= Fam0001::where('id',$fam_id)
        ->select('base_estacion')
        ->get();

        return view('dao.operacionesAereas.programacionVuelo.edit', compact('fam0001','codigoTipoMisionSiglas','A1_mision','codigoMision','vueloOrdenadaPor', 'bases', 'matriculas', 'headerFam0001', 'parroquias', 'aeropuertos' ,'ubicacion', 'esAlerta'));
    }


    public function deleteProgramacion(Request $request)
    {
        $fecha = date('Y-m-d'); //Obtienes la fecha actual
        $fecha_manana = date('Y-m-d', strtotime($fecha . ' +1 day')); // Sumar un día a la fecha y obtener la fecha de mañana

        // Eliminar registros de Fam0001A1Mision
        Fam0001A1Mision::whereIn('fam0001_id', function ($query) use ($fecha_manana, $request) {
            $query->select('id')
                ->from('fam0001')
                ->whereDate('fecha', $fecha_manana)
                ->where('id', $request->fam_id);
        })->delete();

        // Eliminar registros de Fam0001
        Fam0001::whereDate('fecha', $fecha_manana)
        ->where('id', $request->fam_id)
        ->delete();

        //return response()->json($request);
        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully'
            ]
        );
    }

    public function programacion_data(Request $request)
    {
        $headerData = Fam0001::where('id',$request->data_id)
        ->with('aeronaves')
        ->get();
        //$headerData->join('aeronave_unidad','aeronave_unidad.codigos','=','fam0001.unidad');
        $unidad = AeronaveUnidades::where('codigos',$headerData[0]->unidad)->get();
        $A1_data = Fam0001A1Mision::where('fam0001_id',$request->data_id)->where('user_id',auth()->id())->get();
        return response()->json([
            "headerData"=>$headerData,
            "A1_data"=>$A1_data,
            "unidad"=>$unidad,
        ]);
    }


    public function fam0001()
    {
        $user_id = auth()->id();
        $empleado = Empleado::where('user_id',$user_id)->with('data_empleado', 'user.rolesUser')->get();
        if(count($empleado)>0){
            $rol_user = $empleado[0]['user']['rolesUser'][0]['name'];
            $codigo_ubicacion = $empleado[0]['data_empleado']['codigo_ubicacion'];
            $ubicacion = AeronaveUnidades::where('codigo_ubicacion',$codigo_ubicacion)->get();
            if ($rol_user == 'aviacion_dao'|| $rol_user == 'cmd_general') {
                $fam0001 = Fam0001::with('aeronaves')->get();
            }
            elseif(count($ubicacion)>0){
                $fam0001 = Fam0001::where('unidad', $ubicacion[0]['codigos'])->where('user_id',$user_id)->with('aeronaves')->get();
            }else{
                dd('este usuario no tiene ubicacion relacionada con las aeronaves en la BD');
            }
        }else{
            $fam0001 = Fam0001::with('aeronaves')->get();
        }

        return view('dao.operacionesAereas.forms.FAM0001', compact('fam0001'));
    }

    public function verProgramacion()
    {
        date_default_timezone_set('America/Caracas');

        $fecha = date('Y-m-d'); //Obtienes la fecha actual
        $fecha_manana = date('Y-m-d', strtotime($fecha . ' +1 day')); // Sumar un día a la fecha y obtener la fecha de mañana
        $user_id = auth()->id();
        $empleado = Empleado::where('user_id',$user_id)->with('data_empleado', 'user.rolesUser')->get();

        if(count($empleado)>0){

            $rol_user = $empleado[0]['user']['rolesUser'][0]['name'];
            $codigo_ubicacion = $empleado[0]['data_empleado']['codigo_ubicacion'];
            $ubicacion = AeronaveUnidades::where('codigo_ubicacion',$codigo_ubicacion)->get();

            if ($rol_user == 'aviacion_dao'|| $rol_user == 'cmd_general') {

                $fam0001_data = Fam0001::whereDate('fam0001.fecha', $fecha_manana)
                ->join('aeronave_unidad', 'aeronave_unidad.codigos', '=', 'fam0001.unidad')
                ->whereIn('fam0001.completado', ['enviado','revisado', 'sinProg'])
                ->with('aeronaves')
                ->select(
                    'fam0001.id as id',
                    'aeronave_unidad.id as id_unidad',
                    'fam0001.fecha as fecha',
                    'fam0001.ov_ota_om as ov_ota_om',
                    'fam0001.componente_organismo as organismo',
                    'fam0001.unidad as unidad',
                    'fam0001.aeronave_modelo as aeronave_modelo',
                    'fam0001.serial as serial',
                    'fam0001.matricula as matricula',
                    'fam0001.base_estacion as base_estacion',
                    'fam0001.completado as completado',
                    'fam0001.user_id as user_id',
                    'fam0001.created_at as created_at',
                    'fam0001.updated_at as updated_at',
                    'fam0001.matriculas_alternas as matriculas_alternas',
                    'aeronave_unidad.codigos as codigos',
                    'aeronave_unidad.codigo_ubicacion as codigo_ubicacion'
                )
                ->orderBy('aeronave_unidad.id', 'asc')->get();

                # Ordenar por unidad
                $fam0001 = [];
                foreach ($fam0001_data as $key => $value) {
                    $fam0001[$value['codigos']][] = $value;
                }

                return view('dao.operacionesAereas.programacionVuelo.ver_programacion', compact('fam0001'));
            }
            elseif(count($ubicacion)>0){
                $fam0001 = Fam0001::whereDate('fecha', $fecha_manana)->where('unidad', $ubicacion[0]['codigos'])->whereIn('completado', ['enviado','revisado','actualizado','programando'])->where('user_id',$user_id)->with('aeronaves')->get();
                $unidad = $ubicacion[0]['codigos'];

                // Verificar si la unidad tiene programacion para el dia siguiente
                $progra = Fam0001::whereDate('fecha', $fecha_manana)->where('unidad', $ubicacion[0]['codigos'])->where('completado', 'sinProg');
                if($progra->count() > 0){
                    $programacion = 0;
                }else{
                    $programacion = 1;
                }

                return view('dao.operacionesAereas.programacionVuelo.ver_programacion', compact('fam0001','unidad', 'programacion'));
            }else{
                dd('este usuario no tiene ubicacion relacionada con las aeronaves en la BD');
            }
        }else{
            $fam0001_data = Fam0001::whereDate('fam0001.fecha', $fecha_manana)
                ->join('aeronave_unidad', 'aeronave_unidad.codigos', '=', 'fam0001.unidad')
                ->whereIn('fam0001.completado', ['enviado','revisado', 'sinProg'])
                ->with('aeronaves')
                ->select(
                    'fam0001.id as id',
                    'aeronave_unidad.id as id_unidad',
                    'fam0001.fecha as fecha',
                    'fam0001.ov_ota_om as ov_ota_om',
                    'fam0001.componente_organismo as organismo',
                    'fam0001.unidad as unidad',
                    'fam0001.aeronave_modelo as aeronave_modelo',
                    'fam0001.serial as serial',
                    'fam0001.matricula as matricula',
                    'fam0001.base_estacion as base_estacion',
                    'fam0001.completado as completado',
                    'fam0001.user_id as user_id',
                    'fam0001.created_at as created_at',
                    'fam0001.updated_at as updated_at',
                    'fam0001.matriculas_alternas as matriculas_alternas',
                    'aeronave_unidad.codigos as codigos',
                    'aeronave_unidad.codigo_ubicacion as codigo_ubicacion'
                )
                ->orderBy('aeronave_unidad.id', 'asc')->get();
            # Ordenar por unidad
            $fam0001 = [];
            foreach ($fam0001_data as $key => $value) {
                $fam0001[$value['unidad']][] = $value;
            }

            return view('dao.operacionesAereas.programacionVuelo.ver_programacion', compact('fam0001'));
        }
    }


    public function programacionesListas()
    {
        date_default_timezone_set('America/Caracas');

        $fecha = date('Y-m-d'); //Obtienes la fecha actual
        $fecha_manana = date('Y-m-d', strtotime($fecha . ' +1 day')); // Sumar un día a la fecha y obtener la fecha de mañana
        $user_id = auth()->id();
        $empleado = Empleado::where('user_id',$user_id)->with('data_empleado', 'user.rolesUser')->get();

        $checkProgramacion = ProgramacionVuelo::where('fecha', $fecha_manana)
        ->get();

        $fecha_vigente = $checkProgramacion->isEmpty() ? $fecha : $fecha_manana;
        $fecha_vigente_invertida = date('d-m-Y', strtotime($fecha_vigente));

        if(count($empleado)>0){

            $rol_user = $empleado[0]['user']['rolesUser'][0]['name'];
            $codigo_ubicacion = $empleado[0]['data_empleado']['codigo_ubicacion'];
            $ubicacion = AeronaveUnidades::where('codigo_ubicacion',$codigo_ubicacion)->get();

            if ($rol_user == 'aviacion_dao' || $rol_user == 'aviacion_ceo'|| $rol_user == 'cmd_general') {

                $programacionCE = ProgramacionVuelo::where('programacion_vuelo.fecha', $fecha_vigente)
                ->whereIn('programacion_vuelo.unidad', ['G-11','G-12','G-13','G-14','G-15','G-16','G-18','G-19'])
                ->join('aeronave_unidad','aeronave_unidad.codigos','=','programacion_vuelo.unidad')
                ->select(
                    'programacion_vuelo.unidad AS unidad',
                    'programacion_vuelo.fecha AS fecha',
                    'programacion_vuelo.sistema_matricula AS sistema_matricula',
                    'programacion_vuelo.matriculas_alternas AS matriculas_alternas',
                    'programacion_vuelo.ordenada_por AS ordenada_por',
                    'programacion_vuelo.mision_ruta AS mision_ruta',
                    'programacion_vuelo.salida AS salida',
                    'programacion_vuelo.retorno AS retorno',
                    'programacion_vuelo.militar AS militar',
                    'programacion_vuelo.civil AS civil',
                    'programacion_vuelo.carga AS carga',
                )
                ->orderByRaw("CASE
                    WHEN programacion_vuelo.unidad = 'G-4' THEN 1
                    WHEN programacion_vuelo.unidad = 'G-5' THEN 2
                    WHEN programacion_vuelo.unidad = 'G-6' THEN 3
                    WHEN programacion_vuelo.unidad = 'G-7' THEN 4
                    WHEN programacion_vuelo.unidad = 'G-8' THEN 5
                    WHEN programacion_vuelo.unidad = 'G-9' THEN 6
                    WHEN programacion_vuelo.unidad = 'G-10' THEN 7
                    WHEN programacion_vuelo.unidad = 'G-11' THEN 8
                    WHEN programacion_vuelo.unidad = 'G-12' THEN 9
                    WHEN programacion_vuelo.unidad = 'G-13' THEN 10
                    WHEN programacion_vuelo.unidad = 'G-14' THEN 11
                    WHEN programacion_vuelo.unidad = 'G-15' THEN 12
                    WHEN programacion_vuelo.unidad = 'G-16' THEN 13
                    WHEN programacion_vuelo.unidad = 'G-17' THEN 14
                    WHEN programacion_vuelo.unidad = 'G-18' THEN 15
                    WHEN programacion_vuelo.unidad = 'G-19' THEN 16
                END, programacion_vuelo.unidad")
                ->get();

                $programacionTA = ProgramacionVuelo::where('programacion_vuelo.fecha', $fecha_vigente)
                ->whereIn('programacion_vuelo.unidad', ['G-4','G-5','G-6','G-8','G-9','G-10','G-17'])
                ->join('aeronave_unidad','aeronave_unidad.codigos','=','programacion_vuelo.unidad')
                ->select(
                    'programacion_vuelo.unidad AS unidad',
                    'programacion_vuelo.fecha AS fecha',
                    'programacion_vuelo.sistema_matricula AS sistema_matricula',
                    'programacion_vuelo.matriculas_alternas AS matriculas_alternas',
                    'programacion_vuelo.ordenada_por AS ordenada_por',
                    'programacion_vuelo.mision_ruta AS mision_ruta',
                    'programacion_vuelo.salida AS salida',
                    'programacion_vuelo.retorno AS retorno',
                    'programacion_vuelo.militar AS militar',
                    'programacion_vuelo.civil AS civil',
                    'programacion_vuelo.carga AS carga',
                )
                ->orderByRaw("CASE
                    WHEN programacion_vuelo.unidad = 'G-4' THEN 1
                    WHEN programacion_vuelo.unidad = 'G-5' THEN 2
                    WHEN programacion_vuelo.unidad = 'G-6' THEN 3
                    WHEN programacion_vuelo.unidad = 'G-7' THEN 4
                    WHEN programacion_vuelo.unidad = 'G-8' THEN 5
                    WHEN programacion_vuelo.unidad = 'G-9' THEN 6
                    WHEN programacion_vuelo.unidad = 'G-10' THEN 7
                    WHEN programacion_vuelo.unidad = 'G-11' THEN 8
                    WHEN programacion_vuelo.unidad = 'G-12' THEN 9
                    WHEN programacion_vuelo.unidad = 'G-13' THEN 10
                    WHEN programacion_vuelo.unidad = 'G-14' THEN 11
                    WHEN programacion_vuelo.unidad = 'G-15' THEN 12
                    WHEN programacion_vuelo.unidad = 'G-16' THEN 13
                    WHEN programacion_vuelo.unidad = 'G-17' THEN 14
                    WHEN programacion_vuelo.unidad = 'G-18' THEN 15
                    WHEN programacion_vuelo.unidad = 'G-19' THEN 16
                END, programacion_vuelo.unidad")
                ->get();

                return view('dao.operacionesAereas.programacionVuelo.programacionesListas', compact('programacionCE', 'programacionTA', 'fecha_vigente', 'fecha_vigente_invertida'));
            }
            elseif(count($ubicacion)>0){

                $programacion = ProgramacionVuelo::where('fecha', $fecha_vigente)
                ->where('unidad', $ubicacion[0]['codigos'])
                ->get();

                return view('dao.operacionesAereas.programacionVuelo.programacionesListas', compact('programacion', 'fecha_vigente', 'fecha_vigente_invertida'));
            }else{
                dd('este usuario no tiene ubicacion relacionada con las aeronaves en la BD');
            }
        }else{

            $programacionCE = ProgramacionVuelo::where('programacion_vuelo.fecha', $fecha_vigente)
                ->whereIn('programacion_vuelo.unidad', ['G-11','G-12','G-13','G-14','G-15','G-16','G-18','G-19'])
                ->join('aeronave_unidad','aeronave_unidad.codigos','=','programacion_vuelo.unidad')
                ->select(
                    'programacion_vuelo.unidad AS unidad',
                    'programacion_vuelo.fecha AS fecha',
                    'programacion_vuelo.sistema_matricula AS sistema_matricula',
                    'programacion_vuelo.matriculas_alternas AS matriculas_alternas',
                    'programacion_vuelo.ordenada_por AS ordenada_por',
                    'programacion_vuelo.mision_ruta AS mision_ruta',
                    'programacion_vuelo.salida AS salida',
                    'programacion_vuelo.retorno AS retorno',
                    'programacion_vuelo.militar AS militar',
                    'programacion_vuelo.civil AS civil',
                    'programacion_vuelo.carga AS carga',
                )
                ->orderByRaw("CASE
                    WHEN programacion_vuelo.unidad = 'G-4' THEN 1
                    WHEN programacion_vuelo.unidad = 'G-5' THEN 2
                    WHEN programacion_vuelo.unidad = 'G-6' THEN 3
                    WHEN programacion_vuelo.unidad = 'G-7' THEN 4
                    WHEN programacion_vuelo.unidad = 'G-8' THEN 5
                    WHEN programacion_vuelo.unidad = 'G-9' THEN 6
                    WHEN programacion_vuelo.unidad = 'G-10' THEN 7
                    WHEN programacion_vuelo.unidad = 'G-11' THEN 8
                    WHEN programacion_vuelo.unidad = 'G-12' THEN 9
                    WHEN programacion_vuelo.unidad = 'G-13' THEN 10
                    WHEN programacion_vuelo.unidad = 'G-14' THEN 11
                    WHEN programacion_vuelo.unidad = 'G-15' THEN 12
                    WHEN programacion_vuelo.unidad = 'G-16' THEN 13
                    WHEN programacion_vuelo.unidad = 'G-17' THEN 14
                    WHEN programacion_vuelo.unidad = 'G-18' THEN 15
                    WHEN programacion_vuelo.unidad = 'G-19' THEN 16
                END, programacion_vuelo.unidad")
                ->get();

                $programacionTA = ProgramacionVuelo::where('programacion_vuelo.fecha', $fecha_vigente)
                ->whereIn('programacion_vuelo.unidad', ['G-4','G-5','G-6','G-8','G-9','G-10','G-17'])
                ->join('aeronave_unidad','aeronave_unidad.codigos','=','programacion_vuelo.unidad')
                ->select(
                    'programacion_vuelo.unidad AS unidad',
                    'programacion_vuelo.fecha AS fecha',
                    'programacion_vuelo.sistema_matricula AS sistema_matricula',
                    'programacion_vuelo.matriculas_alternas AS matriculas_alternas',
                    'programacion_vuelo.ordenada_por AS ordenada_por',
                    'programacion_vuelo.mision_ruta AS mision_ruta',
                    'programacion_vuelo.salida AS salida',
                    'programacion_vuelo.retorno AS retorno',
                    'programacion_vuelo.militar AS militar',
                    'programacion_vuelo.civil AS civil',
                    'programacion_vuelo.carga AS carga',
                )
                ->orderByRaw("CASE
                    WHEN programacion_vuelo.unidad = 'G-4' THEN 1
                    WHEN programacion_vuelo.unidad = 'G-5' THEN 2
                    WHEN programacion_vuelo.unidad = 'G-6' THEN 3
                    WHEN programacion_vuelo.unidad = 'G-7' THEN 4
                    WHEN programacion_vuelo.unidad = 'G-8' THEN 5
                    WHEN programacion_vuelo.unidad = 'G-9' THEN 6
                    WHEN programacion_vuelo.unidad = 'G-10' THEN 7
                    WHEN programacion_vuelo.unidad = 'G-11' THEN 8
                    WHEN programacion_vuelo.unidad = 'G-12' THEN 9
                    WHEN programacion_vuelo.unidad = 'G-13' THEN 10
                    WHEN programacion_vuelo.unidad = 'G-14' THEN 11
                    WHEN programacion_vuelo.unidad = 'G-15' THEN 12
                    WHEN programacion_vuelo.unidad = 'G-16' THEN 13
                    WHEN programacion_vuelo.unidad = 'G-17' THEN 14
                    WHEN programacion_vuelo.unidad = 'G-18' THEN 15
                    WHEN programacion_vuelo.unidad = 'G-19' THEN 16
                END, programacion_vuelo.unidad")
                ->get();

            return view('dao.operacionesAereas.programacionVuelo.programacionesListas', compact('programacionCE', 'programacionTA', 'fecha_vigente', 'fecha_vigente_invertida'));
        }
    }

    public function FormaFAM_status($fam_id)
    {
        //HEADER
        $aeronaveModelos = AeronaveModelo::get();
        $matriculas = AeronaveMatricula::whereIn('estatus', ['DISPONIBLE', 'DISPONIBLE PARA EL COMBATE', 'INDISPONIBLE'])->get();
        $unidad = AeronaveUnidades::get();
        $componentes = ComponenteOrganismo::get();
        $bases = Base::get();
        $parroquias = Parroquias::get();
        $aeropuertos = Aeropuerto::get();
        $jefeMaquina = EmpleadoFuncion::with('empleado')->where('id_funcion', 16)->get();

        //A1-MISION
        $vueloOrdenadaPor = VueloOrdenadaPor::get();
        $enApoyo = VueloEnApoyo::get();
        $consumibles = UnidadesConsumible::get();
        $unidadesMedida = UnidadesMedidas::get();
        $codigoMision = CodigoTipoMision::orderBy('codigo', 'asc')->get();
        $codigoMisionPropia = CodigoTipoMision::where('tipo_tarea', 'P')->orderBy('codigo', 'asc')->get();
        $codigoTipoMisionSiglas = CodigoTipoMisionSiglas::get();
        //B1-TRIPULACION
        $A1_mision = Fam0001A1Mision::get();
        $fam0001data = Fam0001::where('id', $fam_id)->get();
        $fam0001data = $fam0001data[0];
        $funcion = FuncionTripulante::get();
        $despegue = CodigoDespegue::get();
        $fam0001 = $fam_id;

        $comprobarAlertaA1 = Fam0001::where('id', $fam_id)
        ->select('alerta')
        ->get();
        $esAlerta = $comprobarAlertaA1[0]->alerta;

        return view('dao.operacionesAereas.forms.FAM0001_estatus', compact('fam0001','codigoTipoMisionSiglas','despegue','funcion','A1_mision','codigoMision', 'codigoMisionPropia','consumibles','unidadesMedida','enApoyo','vueloOrdenadaPor','jefeMaquina', 'aeronaveModelos','matriculas','unidad','componentes', 'bases', 'parroquias', 'aeropuertos', 'fam0001data', 'esAlerta'));
    }

    public function index()
    {
        //HEADER
        $aeronaveModelos = AeronaveModelo::get();
        $matriculas = AeronaveMatricula::whereIn('estatus',['DISPONIBLE', 'DISPONIBLE PARA EL COMBATE', 'INDISPONIBLE'])->get();
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
        return view('dao.operacionesAereas.forms.index', compact('codigoTipoMisionSiglas','despegue','funcion','A1_mision','codigoMision','consumibles','unidadesMedida','enApoyo','vueloOrdenadaPor','jefeMaquina', 'aeronaveModelos','matriculas','unidad','componentes', 'bases'));
    }

    public function aeronaves_grupos(Request $request)
    {
        $aeronaves = AeronaveModelo::where('codigo_unidad', $request->unidad)->get();
        return response()->json($aeronaves);
    }

    public function seriales(Request $request)
    {
        $selectedUnidad = AeronaveMatricula::where('matricula', $request->id)->whereNotNull('serial')->get();
        return response()->json($selectedUnidad);
    }

    public function matriculas(Request $request)
    {
        $fecha = date('Y-m-d'); //Obtienes la fecha actual
        $fecha_manana = date('Y-m-d', strtotime($fecha . ' +1 day'));

        $matriculasUsadas = Fam0001::where('aeronave_modelo', $request->id)
        ->where('fecha', $fecha_manana)
        ->pluck('matricula')
        ->toArray();

        if ($request->id == 20 || $request->id == 23) {
            $selectedMatricula = AeronaveMatricula::whereIn('estatus',['DISPONIBLE', 'DISPONIBLE PARA EL COMBATE', 'INDISPONIBLE'])
            ->whereIn('aeronave_id', [20, 23])
            ->whereNotIn('matricula', $matriculasUsadas)
            ->get();

            return response()->json($selectedMatricula);
        } else{
            $selectedMatricula = AeronaveMatricula::whereIn('estatus',['DISPONIBLE', 'DISPONIBLE PARA EL COMBATE', 'INDISPONIBLE'])
            ->where('aeronave_id', $request->id)
            ->whereNotIn('matricula', $matriculasUsadas)
            ->get();

            return response()->json($selectedMatricula);
        }
    }

    public function matriculasAlternas(Request $request)
    {
        $matricula = $request->id;
        if ($request->naved == 20 || $request->naved == 23) {
            $selectedMatriculaAlternas = AeronaveMatricula::whereIn('estatus',['DISPONIBLE', 'DISPONIBLE PARA EL COMBATE', 'INDISPONIBLE'])->whereNot('matricula', $matricula)->whereIn('aeronave_id', [20, 23])->get();
            return response()->json($selectedMatriculaAlternas);
        } else {
            $selectedMatriculaAlternas = AeronaveMatricula::whereIn('estatus',['DISPONIBLE', 'DISPONIBLE PARA EL COMBATE', 'INDISPONIBLE'])->whereNot('matricula', $matricula)->where('aeronave_id', $request->naved)->get();
            return response()->json($selectedMatriculaAlternas);
        }
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
        $A1_data = Fam0001A1Mision::where('fam0001_id',$request->data_id)->get();
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

    public function storeProgramacion(Request $request)
    {

        date_default_timezone_set('America/Caracas');

        $fecha = date('Y-m-d'); //Obtienes la fecha actual
        $fecha_manana = date('Y-m-d', strtotime($fecha . ' +1 day')); // Sumar un día a la fecha y obtener la fecha de mañana

        $fam0001 = new Fam0001;
        $fam0001->fecha = $fecha_manana;
        $fam0001->ov_ota_om = $request->ov_ota_om;
        $fam0001->componente_organismo = $request->componente_organismo;
        $fam0001->unidad = $request->unidad;
        $fam0001->aeronave_modelo = $request->aeronave_modelo;
        $fam0001->serial = $request->serial;
        $fam0001->matricula = $request->matricula;
        $fam0001->base_estacion = $request->base_estacion;
        $fam0001->jefe_maquina = $request->jefe_maquina;
        $fam0001->completado = $request->completado;
        $fam0001->matriculas_alternas = $request->matriculas_alternas;
        $fam0001->alerta = $request->alerta;

        $fam0001->user_id = auth()->id();

        $fam0001->save();

        $dataFam001 = [
            "id" => $fam0001->id,
            "ov_ota_om" => $request->ov_ota_om,
            "fecha" => $request->fecha,
            "componente_organismo" => $request->componente_organismo,
            "unidad" => $request->unidad
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


    public function enviarReporteCeo(Request $request)
    {
        try {
            // Código para obtener los datos y crear el modelo ProgramacionVuelo
            $hoy = Carbon::now();
            $mañana_condicion = $hoy->addDay();
            $mañana_condicion = $mañana_condicion->format('Y-m-d'); /*DECLARACION DE LA FECHA*/

            /*$mision = Fam0001A1Mision::all();*/
            $programacion = Fam0001::join('fam0001_a1_mision','fam0001_a1_mision.fam0001_id','=','fam0001.id')
            ->join('aeronave_modelo','aeronave_modelo.id','=','fam0001.aeronave_modelo')
            ->join('aeronave_unidad','aeronave_unidad.codigos','=','fam0001.unidad')
            ->where(function ($query) {
                $query->where('fam0001.completado', '=', 'revisado')
                    ->orWhere('fam0001.completado', '=', 'sinProg');
            })
            ->whereDate('fam0001.fecha', '=', $mañana_condicion)
            ->select(
                'fam0001.id AS fam0001_id',
                'fam0001_a1_mision.id AS fam0001_a1_mision_id',
                'fam0001.fecha AS fecha',
                'fam0001.unidad AS unidad',
                'fam0001.base_estacion AS base_estacion',
                'aeronave_modelo.modelo AS aeronave_modelo',
                'fam0001.matricula AS matricula',
                'fam0001.matriculas_alternas AS matriculas_alternas',
                'fam0001_a1_mision.ordenada_por AS ordenada_por',
                'fam0001_a1_mision.codigo AS codigo',
                'fam0001_a1_mision.ruta_desde AS ruta_desde',
                'fam0001_a1_mision.ruta_hasta AS ruta_hasta',
                'fam0001_a1_mision.encend AS encend',
                'fam0001_a1_mision.apag AS apag',
                'fam0001.completado AS completado'
            )
            ->orderBy('aeronave_unidad.id', 'asc')
            ->get();

            foreach ($programacion as $row) {

                if ($row->completado == 'revisado') {

                    $sistema_matricula = $row->aeronave_modelo.' / '.$row->matricula;

                    if ($row->codigo === 'ALERTA') {
                        $mision_ruta = $row->codigo.' / '.$row->base_estacion;
                    } else if ($row->codigo === 'ENCENDIDO Y CHEQUEO EN TIERRA') {
                        $mision_ruta = $row->codigo.' / '.$row->base_estacion;
                    }
                    else {
                        $codigo = $row->codigo;
                        if ($row->ruta_desde === 'EVENTUAL' && $row->ruta_hasta === 'EVENTUAL') {
                            $mision_ruta = $row->codigo.' / EVENTUAL';
                        } else if ($row->ruta_desde === 'LOCAL' && $row->ruta_hasta === 'LOCAL') {
                            $mision_ruta = $row->codigo.' / '.$row->base_estacion;
                        }
                        else {
                            $mision_ruta = $row->codigo.' / '.$row->ruta_desde.' - '.$row->ruta_hasta;
                        }
                    }


                    ProgramacionVuelo::create([
                        'fam0001_id' => $row->fam0001_id,
                        'fam0001_a1_mision_id' => $row->fam0001_a1_mision_id,
                        'fecha' => $row->fecha,
                        'unidad' => $row->unidad,
                        'sistema_matricula' => $sistema_matricula,
                        'matriculas_alternas' => $row->matriculas_alternas,
                        'ordenada_por' => $row->ordenada_por,
                        'mision_ruta' => $mision_ruta,
                        'salida' => $row->encend,
                        'retorno' => $row->apag,
                        'militar' => '-',
                        'civil' => '-',
                        'carga' => '-',
                        // Otros campos que deseas insertar
                    ]);

                } else {
                    ProgramacionVuelo::create([
                        'fam0001_id' => $row->fam0001_id,
                        'fam0001_a1_mision_id' => $row->fam0001_a1_mision_id,
                        'fecha' => $row->fecha,
                        'unidad' => $row->unidad,
                        'sistema_matricula' => 'SP',
                        'matriculas_alternas' => 'SP',
                        'ordenada_por' => 'SP',
                        'mision_ruta' => 'SIN PROGRAMACION',
                        'salida' => 'SP',
                        'retorno' => 'SP',
                        'militar' => 'SP',
                        'civil' => 'SP',
                        'carga' => 'SP',
                        // Otros campos que deseas insertar
                    ]);
                }

            }

            // Se actualizan las cabeceras al estado de paso2 y sinProgEnv
            Fam0001A1Mision::whereIn('fam0001_id', function ($query) use ($request) {
                $query->select('id')
                    ->from('fam0001')
                    ->where('fecha',$request->fecha)
                    ->where('completado', 'revisado');
            })
            ->whereNotIn('codigo', ['ALERTA'])
            ->update(['completado' => 'paso2']);

            Fam0001A1Mision::whereIn('fam0001_id', function ($query) use ($request) {
                $query->select('id')
                    ->from('fam0001')
                    ->where('fecha',$request->fecha)
                    ->where('completado', 'sinProg');
            })->update(['completado' => 'sinProgEnv']);

            //Eliminamos las misiones de alerta
            Fam0001A1Mision::whereIn('fam0001_id', function ($query) use ($request) {
                $query->select('id')
                    ->from('fam0001')
                    ->where('fecha',$request->fecha)
                    ->where('completado', 'revisado');
            })
            ->where('codigo', 'ALERTA')
            ->update(['completado' => 'alertaProg']);


            // Se actualizan las cabeceras al estado de paso1 y sinProgEnv
            Fam0001::where('fecha',$request->fecha)->where('completado', 'revisado')->update(['completado' => 'paso1']);

            Fam0001::where('fecha',$request->fecha)->where('completado', 'sinProg')->update(['completado' => 'sinProgEnv']);

            // Realizar otras acciones si la inserción es exitosa
            return response()->json(
                [
                    'success' => true,
                    'message' => 'enviada con éxito',
                    'data' => $programacion,
                ]
            );

        } catch (\Exception $e) {
            // Manejo de la excepción
            return response()->json(['error' => $e->getMessage()]);
        }



        //return response()->json($request);
        /* return response()->json(
            [
                'success' => true,
                'message' => 'enviada con éxito',
                'data' => $programacion,
            ]
        ); */
    }

    public function enviarProgramacionDao(Request $request)
    {
        date_default_timezone_set('America/Caracas');

        $fecha = date('Y-m-d'); //Obtienes la fecha actual
        $fecha_manana = date('Y-m-d', strtotime($fecha . ' +1 day')); // Sumar un día a la fecha y obtener la fecha de mañana
        $enviar_programacion = Fam0001::where('unidad', $request->unidad)->where('fecha',$fecha_manana)->whereIn('completado', ['programando', 'actualizado'])->update(['completado' => 'enviado']);

        //return response()->json($request);
        return response()->json(
            [
                'success' => true,
                'message' => 'enviada con éxito',
                'data' => $enviar_programacion,
            ]
        );
    }

    public function revisarProgramacion(Request $request)
    {
        $programacion_revisada = Fam0001::where('id',$request->id)->update(['completado' => 'revisado']);

        //return response()->json($request);
        return response()->json(
            [
                'success' => true,
                'message' => 'enviada con éxito',
                'data' => $programacion_revisada,
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

        if($request->completado === 'actualizado'){
            Fam0001::where('id',$request->fam0001_id)->update(['completado' => 'actualizado']);
        }

        $vinvuloGrupoAereo = Config::get('constants.vinvulo_grupo_aereo');
        if($request->pierna == 1){
            if (isset($vinvuloGrupoAereo[$request->ordenada_por])) {
                $ordenada_por = $vinvuloGrupoAereo[$request->ordenada_por];
            } else {
                $ordenada_por = ''; // Manejar el caso en que no se encuentre la unidad en la constante
            }
        }else if($request->pierna == 2){
            if (isset($vinvuloGrupoAereo[$request->ordenada_por])) {
                $ordenada_por = $vinvuloGrupoAereo[$request->ordenada_por];
                Fam0001::where('id',$request->fam0001_id)->update(['alerta' => 1]);
            } else {
                $ordenada_por = ''; // Manejar el caso en que no se encuentre la unidad en la constante
            }
        }
        else{
            $ordenada_por = $request->ordenada_por;
        }

        $flyLoop = count($checkVuelo);

        $A1 = new Fam0001A1Mision;
        $A1->vuelo = $flyLoop < 1 ? $A1->vuelo = 1: $A1->vuelo = $flyLoop + 1;

        $A1->ordenada_por = $ordenada_por;
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
        $A1->cod1 = $request->cod1;
        $A1->hv1 = $request->hv1;
        $A1->cod2 = $request->cod2;
        $A1->hv2 = $request->hv2;
        $A1->cod3 = $request->cod3;
        $A1->hv3 = $request->hv3;
        $A1->cod4 = $request->cod4;
        $A1->hv4 = $request->hv4;
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

        $A1_id = Fam0001A1Mision::where('id',$A1->id)->get();
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


    public function store_a1_sinProgramacion(Request $request)
    {
        $fecha = date('Y-m-d'); //Obtienes la fecha actual
        $fecha_manana = date('Y-m-d', strtotime($fecha . ' +1 day')); // Sumar un día a la fecha y obtener la fecha de mañana

        $checkVuelo = Fam0001A1Mision::select('vuelo')->where('fam0001_id',$request->fam0001_id)->get();

        $flyLoop = count($checkVuelo);

        $A1 = new Fam0001A1Mision;
        $A1->vuelo = $flyLoop < 1 ? $A1->vuelo = 1: $A1->vuelo = $flyLoop + 1;
        $A1->ov_ota_om = $request->ov_ota_om;
        $A1->fam0001_id = $request->fam0001_id;
        $A1->completado = $request->completado;
        $A1->user_id = auth()->id();
        $A1->save();

        $A1_id = Fam0001A1Mision::where('id',$A1->id)->get();
        $A1_data = Fam0001A1Mision::where('fam0001_id',$request->fam0001_id)->get();

        // Eliminar registros de Fam0001A1Mision
        Fam0001A1Mision::whereIn('fam0001_id', function ($query) use ($fecha_manana, $request) {
            $query->select('id')
                ->from('fam0001')
                ->whereDate('fecha', $fecha_manana)
                ->where('unidad', $request->unidad)
                ->where('completado', '<>', 'sinProg');
        })->delete();

        // Eliminar registros de Fam0001
        Fam0001::whereDate('fecha', $fecha_manana)
            ->where('unidad', $request->unidad)
            ->where('completado', '<>', 'sinProg')
            ->delete();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'data' => $A1_data,
                'A1_id' => $A1_id
            ]
        );

    }
    public function revertirSinproP($unidad)
    {
        $fecha = date('Y-m-d'); //Obtienes la fecha actual
        $fecha_manana = date('Y-m-d', strtotime($fecha . ' +1 day')); // Sumar un día a la fecha y obtener la fecha de mañana

        // Eliminar registros de Fam0001A1Mision
        Fam0001A1Mision::whereIn('fam0001_id', function ($query) use ($fecha_manana, $unidad) {
            $query->select('id')
                ->from('fam0001')
                ->whereDate('fecha', $fecha_manana)
                ->where('unidad', $unidad)
                ->where('completado', 'sinProg');
        })->delete();

        // Eliminar registros de Fam0001
        Fam0001::whereDate('fecha', $fecha_manana)
            ->where('unidad', $unidad)
            ->where('completado', 'sinProg')
            ->delete();

        return redirect()->route('dao.ver_programacion');

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

        $mision = Fam0001A1Mision::find($request->id);
        $vuelo = $mision->vuelo;
        $mision->delete();

        // Actualizar los números de vuelo de los registros restantes
        Fam0001A1Mision::where('fam0001_id', $mision->fam0001_id)
        ->where('vuelo', '>', $vuelo)
        ->decrement('vuelo');

        return response()->json([
                'success' => true,
                'message' => 'Data Eliminada'
            ]
        );
    }

    public function delete_pro_alerta(Request $request)
    {
        $mision = Fam0001A1Mision::where('fam0001_id',$request->id)
        ->where('codigo','ALERTA')
        ->first();
        $vuelo = $mision->vuelo;
        $mision->delete();

        // Actualizar los números de vuelo de los registros restantes
        Fam0001A1Mision::where('fam0001_id', $mision->fam0001_id)
        ->where('vuelo', '>', $vuelo)
        ->decrement('vuelo');

        // Actualizamos el estado de la fam0001 a sin alerta
        Fam0001::where('id',$request->id)->update(['alerta' => 0]);

        return response()->json([
                'success' => true,
                'message' => 'Data Eliminada'
            ]
        );
    }


    public function concluir_alerta(Request $request)
    {
        Fam0001::where('id',$request->id)->update(['alerta' => 2]);

        return response()->json([
                'success' => true,
                'message' => 'Alerta Conluida'
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

    public function cancelar_a1_mision(Request $request)
    {
        Fam0001A1Mision::where('id',$request->id)->update(['completado' => 'cancelado']);

        return response()->json([
                'success' => true,
                'message' => 'Misión Cancelada'
            ]
        );
    }

    public function comprobar_status_misiones(Request $request)
    {
        $misionesStatus = Fam0001A1Mision::where('fam0001_id',$request->id)
        ->whereIn('completado',['paso2','paso2Alert'])
        ->whereDoesntHave('tripulaciones')
        ->whereDoesntHave('cargas')
        ->get();

        if (count($misionesStatus)>0) {
            return response()->json([
                'success' => false,
                'message' => 'Misiones sin completar',
                'data' => count($misionesStatus)
        ]);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Misiones completadas',
                'data' => count($misionesStatus)
            ]);
        }
    }

    public function actualizarProgramacionA1(Request $request)
    {

        $editMision = Fam0001A1Mision::where('id', $request->id)->update($request->except('id'));

        $pAid = Fam0001A1Mision::where('id', $request->id)->select('fam0001_id')->get();
        Fam0001::where('id',$pAid[0]->fam0001_id)->update(['completado' => 'actualizado']);
        // $loop = count($request->consumiblesDATA);
        // if($loop>0){
        //     for ($i=0; $i < $loop; $i++) {
        //         $updateConsumibles = Fam0001A1MisionConsumible::where('id', $request->id_consumible)->update($request->except('id'));
        //     }
        // }

        return response()->json([
                'success' => true,
                'editMision' => $pAid[0]->fam0001_id
            ]
        );
    }


    public function actuDisponibilidadAeronave(Request $request)
    {
        $editDispon = AeronaveMatricula::where('id', $request->id)->update($request->except('id'));

        return response()->json([
                'success' => true,
                'editDispon' => $editDispon
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
            //->where('id_funcion', $request->id_funcion)
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
        $data_v_trip = Fam0001A1Mision::where('fam0001_id', $request->id)
        ->whereIn('completado', ['paso2', 'paso2Alert'])
        ->whereNotIn('codigo', ['ENCENDIDO Y CHEQUEO EN TIERRA'])
        ->get();
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
        return view('dao.operacionesAereas.forms.listado_pilotos');
    }

    //DATA TABLE PARA LLAMAR A LOS PILOTOS QUE TIENEN VUELOS COMPLETADOS
    public function data_pilotos(){
        $pilotos = Empleado::where('empleados.situacion','A');
        $pilotos->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $pilotos->join('empleado_funcion','empleado_funcion.codigo_empleado','=','empleados.codigo_empleado');
        $pilotos->join('funcion_tripulante','funcion_tripulante.id','=','empleado_funcion.id_funcion');
        $pilotos->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $pilotos->join('fam0001_b1_tripulacion','empleados.cedula','=','fam0001_b1_tripulacion.cedula');

        //  chequear porque antes solo traia los datos de solo los pilotos
        $pilotos->where('fam0001_b1_tripulacion.completado','completado');
        $pilotos->whereIn('fam0001_b1_tripulacion.codigo_funcion', ['PI', 'CP']);
        $pilotos->whereIn('funcion_tripulante.codigo', ['PI', 'CP']);

        $pilotos->select(
            'empleados.id',
            'empleados.codigo_empleado as codigo_empleado',
            'empleados.cedula as cedula',
            'empleados.nombre1',
            'empleados.apellido1',
            'grados_militares.siglas as grado',
        );


        $datatable= DataTables::of($pilotos)
            ->addColumn('actions', 'dao.operacionesAereas.forms._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function ver_listado_piloto($id){
        $user_auth=auth()->user();

        $funcion_tripulante = FuncionTripulante::all();
        $grados_militares = GradosMilitares::all();
        $ubicaciones = Ubicaciones::all();
        $datos = Empleado::with(['nomina'])->find($id);

        return view('dao.operacionesAereas.forms.ver_listado_piloto',
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
            'fam0001_b1_tripulacion.cedula as cedula',
            'bases.descripcion as base',
            'fam0001.unidad as unidad',
            'aeronave_modelo.aeronave as aeronave',
            'fam0001.serial as serial',
            'fam0001.matricula as matricula',
            'fam0001.fecha as fecha'
        );

        $datatable= DataTables::of($piloto);
        return $datatable->make(true);
    }

    public function reporte_vuelos($id) {
        $user_auth=auth()->user();

        $datos = Empleado::find($id);
        return view('dao.operacionesAereas.forms.reporte_vuelos',
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
        if(count($piloto)==0){
            return back()
            ->with('warning','No se puede generar el reporte, no existen registros para el periodo solicitado');
        };

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

        $pdf = \PDF::loadview('dao.operacionesAereas.forms.imprimir_reporte', compact('piloto', 'anteriores'));

        return $pdf->stream('REPORTE.pdf');
        //return view('dao.forms.imprimir_reporte', compact('piloto'));
    }

    public function ProFin ()
    {
        $user = auth()->user()->id;

        $ubicacion = Nomina::select('nomina.codigo_ubicacion as ubicacion')
        ->join('empleados','empleados.codigo_empleado','=','nomina.codigo_empleado')
        ->where('empleados.user_id','=',$user)
        ->first();

        $aeronave = AeronaveUnidades::select('aeronave_unidad.codigos as aeronave')
        ->join('nomina','nomina.codigo_ubicacion','=','aeronave_unidad.codigo_ubicacion')
        ->where('aeronave_unidad.codigo_ubicacion','=',$ubicacion->ubicacion)
        ->first();



        $aeronaveM = AeronaveModelo::select('aeronave_modelo.aeronave as modelo','aeronave_matricula.matricula as matricula')
        ->join('aeronave_matricula','aeronave_matricula.aeronave_id','=','aeronave_modelo.id')
        ->where('aeronave_modelo.codigo_unidad','=',$aeronave->aeronave)  ->get();
        $fechaSabado = Carbon::now()->startOfWeek()->addWeek()->next(Carbon::SATURDAY)->format('Y-m-d');
        $fechaDomingo = Carbon::now()->startOfWeek()->next(Carbon::SUNDAY)->format('Y-m-d');

        return view('dao.operacionesAereas.create',compact('ubicacion','aeronave','aeronaveM','fechaDomingo','fechaSabado'));
    }
    public function storeProFin(Request $request)
    {
        $this->validate($request, [
            'sistema.*' => 'required',
            'unidad.*' => 'required',
            'situacion.*' => 'required',
            'observacion.*' => 'required',
            'desde.*'=>'required',
            'hasta.*'=>'required'
        ]);
        if ($request->has('sistema')) {
            $sistemas = $request->input('sistema');
            $unidades = $request->input('unidad');
            $situaciones = $request->input('situacion');
            $observaciones = $request->input('observacion');
            $desde = $request->input('desde');
            $hasta = $request->input('hasta');

            foreach ($sistemas as $key => $sistema) {
                $programacion = new ProgramacionFin();
                $programacion->sistema = $sistema;
                $programacion->unidad = $unidades[$key];
                $programacion->situacion = $situaciones[$key];
                $programacion->observacion = $observaciones[$key];
                $programacion->desde = $desde[$key];
                $programacion->hasta = $hasta[$key];
                $programacion->save();
            }
        }

        return redirect()->route('dao.forms.ProFin')->with('success','Programacion de fin de semana creada correctamente');
    }

    public function programacioReportExcel(Request $request) {


        $titulo = 'AGENDA DE OPERACIONES AÉREAS DE LA DIRECCIÓN DE APRESTO OPERACIONAL
        CORRESPONDIENTE AL FIN DE SEMANA';
        $programacion = ProgramacionFin::select('sistema','unidad','situacion','observacion'

    )->get();
    $fechaActual = Carbon::now()->format('dMY');
    $fecha_inv = Carbon::now()->format('dMY');

        $nombre_archivo = sprintf('reporte de programacion de fin de semana %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
        $data = compact('titulo', 'programacion');
        return Excel::download(new ProgramacionFinExport($data), $nombre_archivo);
    }



    public function imprimir_reportepfd(Request $request) {

        $this->validate($request, [
            'fecha' => 'required'

        ]);

        $programacion = ProgramacionFin::select('sistema','unidad','situacion','observacion','desde as desde','hasta as hasta'
        )->where('desde','=',$request->fecha)
        ->get();
        setlocale(LC_TIME, 'es_ES'); // Establecer la configuración regional en español
        $fechaActual = Carbon::now();
        $diaSemana = ucfirst(strftime('%A', $fechaActual->timestamp));
        $dia = $fechaActual->format('d');
        $mes = ucfirst(strftime('%B', $fechaActual->timestamp));
        $anio = $fechaActual->format('Y');

        $fecha_inve = $diaSemana . ', ' . $dia . ' ' . $mes . ' DE ' . $anio;
        $fecha_inv= strtoupper($fecha_inve);
        $pdf = \PDF::loadview('dao.operacionesAereas.programacionVuelo.programacionfinpdf', compact('programacion','fecha_inv'))
        ->setPaper('legal', 'landscape');
        return $pdf->stream('REPORTE.pdf');
       //return view('dao.operacionesAereas.programacionVuelo.programacionfinpdf', compact('programacion','fecha_inv'));
    }



    public function daoAgenda()
{
    $user = auth()->user();
    $ubicacion = null;
    $aeronave = null;
    $programacion = null;

    if ($user->hasRole('aviacion_dao|cmd_general')) {
        // Si el usuario tiene el rol "aviacion_dao", mostrar todos los registros
        $programacion = ProgramacionFin::select('sistema', 'unidad', 'situacion', 'observacion')
        ->whereDate('created_at', now()->toDateString())
        ->get();
    } else {
        // Obtener la ubicación del usuario
        $ubicacion = Nomina::select('nomina.codigo_ubicacion as ubicacion')
            ->join('empleados', 'empleados.codigo_empleado', '=', 'nomina.codigo_empleado')
            ->where('empleados.user_id', '=', $user->id)
            ->first();

        if ($ubicacion) {
            // Obtener la aeronave de la ubicación
            $aeronave = AeronaveUnidades::select('aeronave_unidad.codigos as aeronave')
                ->join('nomina', 'nomina.codigo_ubicacion', '=', 'aeronave_unidad.codigo_ubicacion')
                ->where('aeronave_unidad.codigo_ubicacion', '=', $ubicacion->ubicacion)
                ->first();

            if ($aeronave) {
                // Obtener los registros de la programación según la aeronave
                $programacion = ProgramacionFin::select('sistema', 'unidad', 'situacion', 'observacion','id')
                    ->where('unidad', '=', $aeronave->aeronave)
                    ->whereDate('created_at', now()->toDateString())
                    ->get();
            }
        }
    }

    return view('dao.agenda.index', compact('programacion'));
}



public function PReporte()
    {
        return view('dao.agenda.reportes');
    }
    public function editAgenda($id)
    {



        $user = auth()->user()->id;

        $ubicacion = Nomina::select('nomina.codigo_ubicacion as ubicacion')
        ->join('empleados','empleados.codigo_empleado','=','nomina.codigo_empleado')
        ->where('empleados.user_id','=',$user)
        ->first();

        $aeronave = AeronaveUnidades::select('aeronave_unidad.codigos as aeronave')
        ->join('nomina','nomina.codigo_ubicacion','=','aeronave_unidad.codigo_ubicacion')
        ->where('aeronave_unidad.codigo_ubicacion','=',$ubicacion->ubicacion)
        ->first();



        $aeronaveM = AeronaveModelo::select('aeronave_modelo.aeronave as modelo','aeronave_matricula.matricula as matricula')
        ->join('aeronave_matricula','aeronave_matricula.aeronave_id','=','aeronave_modelo.id')
        ->where('aeronave_modelo.codigo_unidad','=',$aeronave->aeronave)  ->get();
        $fechaSabado = Carbon::now()->startOfWeek()->addWeek()->next(Carbon::SATURDAY)->format('Y-m-d');
        $fechaDomingo = Carbon::now()->startOfWeek()->next(Carbon::SUNDAY)->format('Y-m-d');
        $programacion = ProgramacionFin::find($id);
        return view('dao.agenda.edit',compact('aeronave','aeronaveM','fechaDomingo','fechaSabado','programacion'));

    }

    public function updateAgenda($id)
    {

        $this->validate(request(), [
            'sistema' => 'required',
            'unidad' => 'required',
            'situacion' => 'required',
            'observacion' => 'required',
            'desde'=>'required',
            'hasta'=>'required'
        ]);



        $programacion = ProgramacionFin::find($id);
        $programacion->sistema = request('sistema');
        $programacion->unidad = request('unidad');
        $programacion->situacion = request('situacion');
        $programacion->observacion = request('observacion');
        $programacion->desde = request('desde');
        $programacion->hasta = request('hasta');
        $programacion->save();
        return redirect()->route('dao.agenda')->with('success','Programacion de fin de semana actualizada correctamente');
    }

}
