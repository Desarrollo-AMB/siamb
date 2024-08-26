<?php

namespace App\Http\Controllers;


use App\Exports\HorasAeronaveExport;
use App\Exports\ParteAeronaveExport;
use App\Models\AeronaveMatricula;
use App\Models\AeronaveModelo;
use App\Models\AeronaveUnidades;
use App\Models\Fam0001;
use App\Models\Nomina;
use App\Models\ParteAeronave;
use App\Models\Ubicaciones;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ParteAeronaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *Este código define un método de controlador indexparte que recupera datos de la base de datos y devuelve una vista para mostrarlos.
      *El método une tres tablas (nomina, empleados y ubicaciones) para recuperar una lista de datos relacionados con el usuario autenticado.
      *Luego utiliza estos datos para filtrar registros de la tabla parte_aeronave, recupera el recuento de registros con valores específicos en la columna situacion, agrupa los registros filtrados por varias columnas y devuelve todos estos datos a la vista.
     * @return \Illuminate\Http\Response
     *
     */
    public function indexparte()
    {  $user_id = auth()->user()->id; //obtener el id del usuario que ha iniciado sesión

        $datas = Nomina::
            join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
            ->where('empleados.user_id', '=', $user_id)
            ->select('nomina.codigo_ubicacion', 'ubicaciones.descripcion as ubicacion')
            ->get();


            $ubicacion = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
            ->where('empleados.user_id', '=', $user_id)
            ->select('nomina.codigo_ubicacion')
            ->first();


            $list = ParteAeronave::select(
                'parte_aeronave.unidad',
                'parte_aeronave.sistema',
                'parte_aeronave.matricula',
                'parte_aeronave.serial',
                'parte_aeronave.situacion',
                'parte_aeronave.observacion',
                'parte_aeronave.fecha'
            )
            ->where('parte_aeronave.codigo_ubicacion', $ubicacion->codigo_ubicacion) // Corregido: Acceder al valor de codigo_ubicacion
            ->whereDate('fecha', Carbon::today())
            ->groupBy(
                'parte_aeronave.unidad',
                'parte_aeronave.sistema',
                'parte_aeronave.matricula',
                'parte_aeronave.serial',
                'parte_aeronave.situacion',
                'parte_aeronave.observacion',
                'parte_aeronave.fecha',
                'parte_aeronave.codigo_ubicacion'
            )
            ->get();



        $num = ParteAeronave::select(\DB::raw('count(*) as total'),
        \DB::raw('sum(CASE WHEN parte_aeronave.situacion = "DISPONIBLE" THEN 1 ELSE 0 END) as total1'),
        \DB::raw('sum(CASE WHEN parte_aeronave.situacion = "DISPONIBLE PARA EL COMBATE" THEN 1 ELSE 0 END) as total2'),
        \DB::raw('sum(CASE WHEN parte_aeronave.situacion = "INDISPONIBLE" THEN 1 ELSE 0 END) as total3'),
        \DB::raw('sum(CASE WHEN parte_aeronave.situacion = "SINIESTRADA" THEN 1 ELSE 0 END) as total4'))
        ->where ('parte_aeronave.codigo_ubicacion', $ubicacion->codigo_ubicacion)
        ->whereDate('fecha', Carbon::today())->first();




        return view('dao.aeronaves.parte_aeronave', compact('list','datas','num'));
    }

    /**
     * Show the form for creating a new resource.
     *Este código define una función llamada crear() que recupera datos de la base de datos y los pasa a una vista. Específicamente,
     *obtiene el ID del usuario actualmente autenticado y lo utiliza para unir datos de varias tablas en la base de datos.
      *Los datos resultantes se devuelven a una vista llamada 'dao.aeronaves.create'.
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        $user_id = auth()->user()->id; //obtener el id del usuario que ha iniciado sesión

        $datas = Nomina::
            join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
            ->where('empleados.user_id', '=', $user_id)
            ->select('nomina.codigo_ubicacion', 'ubicaciones.descripcion as ubicacion')
            ->first();

            $aeronaves = AeronaveUnidades::join('aeronave_modelo','aeronave_modelo.codigo_unidad','=','aeronave_unidad.codigos')
            ->join('aeronave_matricula','aeronave_matricula.aeronave_id','=','aeronave_modelo.id')
            ->where('aeronave_unidad.codigo_ubicacion','=',$datas->codigo_ubicacion)
            ->select('aeronave_modelo.id','aeronave_unidad.codigos as unidad','aeronave_modelo.aeronave as sistema','aeronave_matricula.matricula as matricula',
            'aeronave_matricula.serial as serial','aeronave_matricula.estatus as situacion',
            'aeronave_matricula.observacion as observacion','aeronave_matricula.porcentaje_disponibilidad as porcentaje','aeronave_unidad.codigo_ubicacion as ubicacion')
            ->get();

            return view('dao.aeronaves.create', compact('datas','aeronaves'));

    }

    /**
     * Store a newly created resource in storage.
     *Este código define una función que guarda nuevos recursos en un almacenamiento.
     * Toma un objeto de solicitud como argumento, extrae algunos datos de él y
      * los utiliza para comprobar si un recurso ya existe. Si no existe, guarda
       * el nuevo recurso en el almacenamiento y devuelve una respuesta exitosa.
       *  Si existe, devuelve una respuesta de error.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        $user = User::select('username')->where('id', '=', $user_id)->first();

           try {
               $aeronaves = $request->input('aeronaves');
               $fecha = $request->input('fecha');

               // Comprobar si la fecha ya existe para una ubicación específica
               foreach ($aeronaves as $aeronave) {
                   $parteExistente = ParteAeronave::where([
                       ['fecha', '=', $fecha],
                       ['unidad', '=', $aeronave['unidad']]
                   ])->first();

                   if ($parteExistente) {
                       return response()->json([
                           'success' => false,
                           'message' => 'Ya existe un parte para la fecha y ubicación especificadas'
                       ]);
                   }
               }

               // Guardar las nuevas nominas
               foreach ($aeronaves as $aeronave) {
                   $parte = new ParteAeronave;
                   $parte->fecha = $fecha;
                   $parte->unidad = $aeronave['unidad'];
                   $parte->sistema = $aeronave['sistema'];
                   $parte->matricula = $aeronave['matricula'];
                   $parte->serial = $aeronave['serial'];
                   $parte->situacion = $aeronave['situacion'];
                   $parte->observacion = $aeronave['observacion'];
                   $parte->codigo_ubicacion = $aeronave['ubicacion'];
                   $parte->user_created = $user->username; // ID del usuario creador
                    $parte->user_updated = $user->username; // ID del usuario actualizador

                   $parte->save();
               }
               foreach ($aeronaves as $aeronave) {
    $act = AeronaveMatricula::where('aeronave_id', $aeronave['id'])
    ->where('matricula', $aeronave['matricula'])
    ->where('serial', $aeronave['serial'])
    ->first();
    if ($act) {
        // Realizar la actualización en la otra tabla según tus necesidades
        $act->estatus = $aeronave['situacion'];
        $act->observacion = $aeronave['observacion'];
        $act->porcentaje_disponibilidad = $aeronave['porcentaje'];
        $act->save();
    }
}

               return response()->json([
                   'success' => true,
                   'message' => 'Parte fue ingresado con éxito.'
               ]);
           } catch (\Exception $e) {
               return response()->json([
                   'success' => false,
                   'message' => 'Error al guardar los datos: ' . $e->getMessage()
               ]);
           }
    }
/**
     * Valida la solicitud dada y recupera todas las ubicaciones y partes de una aeronave en una fecha determinada,
     * las agrupa por ubicación y devuelve una vista con las ubicaciones que tienen partes y las que no las tienen.
     *Mon, Jun 19, 2023, 10:54 am
    *Esta es una función escrita en PHP que valida una solicitud dada,
    *recupera todas las ubicaciones y partes de una aeronave en una fecha determinada,
    *las agrupa por ubicación y devuelve una vista con las ubicaciones que tienen partes y las que no las tienen.
    *Toma como parámetro un objeto de solicitud, lo valida y no lanza excepciones.
    *Devuelve una vista con dos variables: ubicacionesConRegistro (ubicaciones con partes)
    *y ubicionesSinRegistro (ubicaciones sin partes).
     * @param request $request La solicitud a validar.
     * @throws None
     * @return view La vista con las ubicaciones con partes y las que no las tienen.
     */
    public function auditoriadao(request $request){
        {

            $this->validate($request,
        //dd($request),
            [
                'fecha' => 'required'

            ],
            [
                'fecha.required' => 'Debe seleccionar una fecha'
            ]);
            $fecha = $request->fecha;
            $ubicaciones = Ubicaciones::select('*')
           ->whereIn('codigo_ubicacion',['0420',
            '0010','0418','0412','0421','0419','0415','0408','0409',
            '0411','0428','0416','0410','0417','0413', '0414','0420',
            '0010','0418','0412','0421','0419','0415','0408','0409',
            '0411','0428','0416','0410','0417', '0413', '0414'])->get(); // Obtener todas las ubicaciones

            $partes = ParteAeronave::where('fecha',$fecha)->get();
            $partesUbicacion = $partes->groupBy('codigo_ubicacion');

            $ubicacionesConRegistro = $ubicaciones->filter(function ($ubicacion) use ($partesUbicacion) {
                return $partesUbicacion->has($ubicacion->codigo_ubicacion);
            })->values();

            $ubicacionesSinRegistro = $ubicaciones->diff($ubicacionesConRegistro);

            return view('dao.aeronaves.auditoria', compact('ubicacionesConRegistro', 'ubicacionesSinRegistro'));
        }
        }

        public function auditoriaingdao()
        {


            return view('dao.aeronaves.auditoriaingreso'

        );
        }
/**
 * Recupera una vista para la página 'auditoriaingreso' en el directorio 'dao.aeronaves'.
 *
 * @return Illuminate\View\View
 */



        public function parteAeronaveExceldao(Request $request)
        {
            $titulo = ' PARTE DE AERONAVES ';

            // Obtener la fecha actual en la zona horaria de Venezuela
            $fechaActual = Carbon::now('America/Caracas');
            $fechaFormateada = strtoupper($fechaActual->formatLocalized('%d DE %B %Y'));

            $programacion = ParteAeronave::select('unidad', 'sistema', 'matricula', 'serial', 'situacion', 'observacion')
                ->whereDate('fecha', $fechaActual)
                ->orderByRaw("FIELD(unidad, 'G-4', 'G-5', 'G-6', 'G-7', 'G-8', 'G-9', 'G-10', 'G-11', 'G-12', 'G-13', 'G-14', 'G-15', 'G-16', 'G-17', 'G-18', 'G-19')")
                ->get();

            $num = ParteAeronave::select('parte_aeronave.unidad as unidad', 'parte_aeronave.sistema as sistema')
                ->selectRaw('count(*) as total')
                ->selectRaw('sum(CASE WHEN parte_aeronave.situacion = "DISPONIBLE" THEN 1 ELSE 0 END) as total1')
                ->selectRaw('sum(CASE WHEN parte_aeronave.situacion = "DISPONIBLE PARA EL COMBATE" THEN 1 ELSE 0 END) as total2')
                ->selectRaw('sum(CASE WHEN parte_aeronave.situacion = "INDISPONIBLE" THEN 1 ELSE 0 END) as total3')
                ->selectRaw('sum(CASE WHEN parte_aeronave.situacion = "SINIESTRADA" THEN 1 ELSE 0 END) as total4')
                ->groupBy('parte_aeronave.unidad', 'parte_aeronave.sistema')
                ->whereDate('fecha', $fechaActual)
                ->orderByRaw("FIELD(unidad, 'G-4', 'G-5', 'G-6', 'G-7', 'G-8', 'G-9', 'G-10', 'G-11', 'G-12', 'G-13', 'G-14', 'G-15', 'G-16', 'G-17', 'G-18', 'G-19')")
                ->get();

            setlocale(LC_TIME, 'es_LA'); // Establece el locale en español

            $nombre_archivo = sprintf('reporte de Aeronaves %s .xlsx', $fechaActual->format('Y-m-d h_i_s_a'));
            $data = compact('titulo', 'programacion', 'num', 'fechaFormateada');
            return Excel::download(new ParteAeronaveExport($data), $nombre_archivo);
            // return view('excel.parteAeronave', $data = compact('titulo', 'programacion','num'));
        }


     /**
 * Una función que genera un archivo Excel con información sobre las aeronaves.
 *
 * @throws No se lanza ninguna excepción.
 * @return Una vista con la información que se exportará a Excel.
 */

 public function AeronaveExcel()
 {
     $fechaActual = Carbon::now('America/Caracas');
     $fechaFormateada = strtoupper($fechaActual->formatLocalized('%d DE %B %Y'));
     $titulo = ' RELACIÓN DE HORAS DE  VUELO DIARIAS Y MISIONES PROGRAMADAS DE LA AMB ';
     $aeronave = Fam0001::join('fam0001_a1_mision', 'fam0001_a1_mision.fam0001_id', '=', 'fam0001.id')
     ->leftjoin('fam0001_a1_mision_consumibles', 'fam0001_a1_mision_consumibles.fam0001_id', '=', 'fam0001.id')
     ->join('aeronave_modelo', 'aeronave_modelo.id', '=', 'fam0001.aeronave_modelo')
     ->leftJoin('fam0001_a3_carga','fam0001_a3_carga.fam0001_id', '=', 'fam0001.id')
     ->select(
         'fam0001.id as id',
         'aeronave_modelo.codigo_unidad as unidad',
         'aeronave_modelo.modelo as sistema',
         'fam0001.matricula',
         'fam0001_a1_mision.codigo as codigo',
         'fam0001_a1_mision.en_apoyo_A2',
         'fam0001_a1_mision.ruta_desde',
         'fam0001_a1_mision.ruta_hasta',
         'fam0001_a3_carga.pesocargaTotal',
         'fam0001_a3_carga.pers as perse',
         \DB::raw('GROUP_CONCAT(DISTINCT fam0001_a1_mision_consumibles.consumible SEPARATOR "\n") as consumibles'),
         \DB::raw('IFNULL(GROUP_CONCAT(DISTINCT CASE
         WHEN fam0001_a1_mision_consumibles.consumible = "JET-A1" THEN
             IF(fam0001_a1_mision_consumibles.unidad = "LBS", ROUND(fam0001_a1_mision_consumibles.cantidad * 0.4536, 2),
             IF(fam0001_a1_mision_consumibles.unidad = "GAL", ROUND(fam0001_a1_mision_consumibles.cantidad * 3.78541, 2),
             ROUND(fam0001_a1_mision_consumibles.cantidad, 2)))
         END SEPARATOR "\n"),0) as cantidad'),
         \DB::raw('GROUP_CONCAT(DISTINCT fam0001_a1_mision_consumibles.consumible SEPARATOR "\n") as consumibles'),
         \DB::raw('IFNULL(GROUP_CONCAT(DISTINCT CASE
         WHEN fam0001_a1_mision_consumibles.consumible = "AV-GAS" THEN
             IF(fam0001_a1_mision_consumibles.unidad = "LBS", ROUND(fam0001_a1_mision_consumibles.cantidad * 0.4536, 2),
             IF(fam0001_a1_mision_consumibles.unidad = "GAL", ROUND(fam0001_a1_mision_consumibles.cantidad * 3.78541, 2),
             ROUND(fam0001_a1_mision_consumibles.cantidad, 2)))
         END SEPARATOR "\n"), 0) as avgas'),
         \DB::raw('COUNT(DISTINCT fam0001_a1_mision.id) as count'),
      //  \DB::raw('SUM(DISTINCT COALESCE (CASE WHEN fam0001_a1_mision.completado  THEN 1 ELSE 0 END)) as count'),
      \DB::raw('COUNT(DISTINCT COALESCE (CASE WHEN fam0001_a1_mision.completado <> "completado" THEN fam0001_a1_mision.id END)) as canceladas'),
      \DB::raw('COUNT(DISTINCT COALESCE (CASE WHEN fam0001_a1_mision.completado = "completado" THEN fam0001_a1_mision.id END)) as completadas'),
    //  \DB::raw('SUM(DISTINCT COALESCE (CASE WHEN fam0001_a1_mision.completado = "completado" THEN 1 ELSE 0 END)) as completadas'),
         \DB::raw('SUM(DISTINCT COALESCE(fam0001_a1_mision.registro_manual, 0)) as horas'),
         \DB::raw('SUM(DISTINCT COALESCE(fam0001_a3_carga.pers, 0)) as pers'),
         \DB::raw('COUNT(DISTINCT fam0001_a1_mision.aterriz) as aterrizajes'),
         \DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN fam0001_a1_mision.ruta_hasta <> "EVENTUAL" THEN fam0001_a1_mision.ruta_hasta END) as hasta'),
         \DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN fam0001_a1_mision.ruta_desde <> "EVENTUAL" THEN fam0001_a1_mision.ruta_desde END) as desde'),
         \DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN fam0001_a1_mision.codigo <> "ALERTA" THEN fam0001_a1_mision.codigo END) as codigos'),
         \DB::raw('(SELECT COUNT( fam0001_b1_tripulacion.v_trip) FROM fam0001_b1_tripulacion WHERE fam0001_b1_tripulacion.fam0001_id = fam0001.id) as tripulacion'),
         \DB::raw('GROUP_CONCAT(DISTINCT fam0001_a1_mision.en_apoyo_A2) as apoyo')
     )
     ->groupBy('fam0001.id')
   //  ->where('fam0001.id', '=', '633')
     ->whereDate('fam0001.fecha', '=', $fechaActual)
     ->orderByRaw("FIELD(fam0001.unidad, 'G-4', 'G-5', 'G-6', 'G-7', 'G-8', 'G-9', 'G-10', 'G-11', 'G-12', 'G-13', 'G-14', 'G-15', 'G-16', 'G-17', 'G-18', 'G-19')")
     ->get();


         $aeronave2 = Fam0001::join('fam0001_a1_mision', 'fam0001_a1_mision.fam0001_id', '=', 'fam0001.id')
         ->leftJoin('fam0001_a1_mision_consumibles', 'fam0001_a1_mision_consumibles.fam0001_a1_mision_id', '=', 'fam0001_a1_mision.id')
         ->join('aeronave_modelo', 'aeronave_modelo.id', '=', 'fam0001.aeronave_modelo')
         ->select('fam0001.id', \DB::raw('COUNT(fam0001.id) as count'),
         \DB::raw('sum(case when fam0001_a1_mision.fam0001_id = fam0001.id then 1 else 0 end) as total'))
         ->whereDate('fam0001.fecha', '=', '2023-06-07')
         ->groupBy('fam0001.id')
         ->get();

     $registros = Fam0001::join('fam0001_a1_mision', 'fam0001_a1_mision.fam0001_id', '=', 'fam0001.id')
         ->leftJoin('fam0001_a1_mision_consumibles', 'fam0001_a1_mision_consumibles.fam0001_a1_mision_id', '=', 'fam0001_a1_mision.id')
         ->join('aeronave_modelo', 'aeronave_modelo.id', '=', 'fam0001.aeronave_modelo')
         ->select('fam0001.id as fam0001_id', 'fam0001_a1_mision.encend', 'fam0001_a1_mision.apag')
         ->whereDate('fam0001.fecha', '=', '2023-06-07')
         ->groupBy('fam0001.id', 'fam0001_a1_mision.encend', 'fam0001_a1_mision.apag')
         ->get();

     $horasDecimalesPorRegistro = [];

     foreach ($registros as $registro) {
        if ($registro->encend != 'EVENTUAL' && $registro->apag != 'EVENTUAL') {
            $encendido = DateTime::createFromFormat('H:i', $registro->encend);
            $apagado = DateTime::createFromFormat('H:i', $registro->apag);

            if ($encendido && $apagado) {
                // Calcular la diferencia de tiempo en segundos
                $diferencia = $apagado->getTimestamp() - $encendido->getTimestamp();

                // Calcular las horas decimales dividiendo la diferencia de tiempo entre 3600 (segundos en una hora)
                $horasDecimales = $diferencia / 3600;

                // Redondear las horas decimales a dos decimales
                $horasDecimales = round($horasDecimales, 1);

                // Sumar las horas decimales a la suma acumulada del registro asociado
                $horasDecimalesPorRegistro[$registro->fam0001_id] = ($horasDecimalesPorRegistro[$registro->fam0001_id] ?? 0) + $horasDecimales;
            }
        }
    }
       //dd($horasDecimalesPorRegistro);


           $nombre_archivo = sprintf('reporte de Aeronaves %s .xlsx', $fechaActual->format('Y-m-d h_i_s_a'));
           $data = compact('titulo', 'aeronave', 'fechaFormateada', 'aeronave2', 'horasDecimalesPorRegistro');
            return Excel::download(new HorasAeronaveExport($data), $nombre_archivo);
           // return view('excel.HorasAeronave', compact('titulo', 'aeronave', 'fechaFormateada', 'aeronave2', 'horasDecimalesPorRegistro'));
        }
}


/*    // xxxConvertir las horas de encendido y apagado a objetos DateTime
    $encendido = DateTime::createFromFormat('H:i', $horaEncendido);
    $apagado = DateTime::createFromFormat('H:i', $horaApagado);eee

    // Calcular la diferencia de tiempo en segundos
    $diferencia = $apagado->getTimestamp() - $encendido->getTimestamp();

    // Calcular las horas decimales dividiendo la diferencia de tiempo entre 3600 (segundos en una hora)
    $horasDecimales = $diferencia / 3600;

    // Redondear las hosssras decimales a dos decimales
    $horasDeciemales = round($horasDecimales, 2);*/
