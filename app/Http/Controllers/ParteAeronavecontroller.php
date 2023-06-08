<?php

namespace App\Http\Controllers;

use App\Exports\ParteAeronaveExport;
use App\Models\AeronaveMatricula;
use App\Models\AeronaveModelo;
use App\Models\AeronaveUnidades;
use App\Models\Nomina;
use App\Models\ParteAeronave;
use App\Models\Ubicaciones;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ParteAeronavecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     *
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
     *
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
            $ubicaciones = Ubicaciones::all(); // Obtener todas las ubicaciones

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



        public function parteAeronaveExceldao(Request $request) {


            $titulo = ' PARTE DE AERONAVES ';
            $programacion = ParteAeronave::select('unidad',
            'sistema',
            'matricula',
            'serial',
            'situacion',
            'observacion')
            ->whereDate('fecha', Carbon::today())
            ->orderByRaw("FIELD(unidad, 'G-4', 'G-5', 'G-6', 'G-7', 'G-8', 'G-9', 'G-10', 'G-11', 'G-12', 'G-13', 'G-14', 'G-15', 'G-16', 'G-17', 'G-18', 'G-19')")
            ->get();

            $num = ParteAeronave::select('parte_aeronave.unidad as unidad', 'parte_aeronave.sistema as sistema')
            ->selectRaw('count(*) as total')
            ->selectRaw('sum(CASE WHEN parte_aeronave.situacion = "DISPONIBLE" THEN 1 ELSE 0 END) as total1')
            ->selectRaw('sum(CASE WHEN parte_aeronave.situacion = "DISPONIBLE PARA EL COMBATE" THEN 1 ELSE 0 END) as total2')
            ->selectRaw('sum(CASE WHEN parte_aeronave.situacion = "INDISPONIBLE" THEN 1 ELSE 0 END) as total3')
            ->selectRaw('sum(CASE WHEN parte_aeronave.situacion = "SINIESTRADA" THEN 1 ELSE 0 END) as total4')
            ->groupBy('parte_aeronave.unidad', 'parte_aeronave.sistema')
            ->whereDate('fecha', Carbon::today())
            ->orderByRaw("FIELD(unidad, 'G-4', 'G-5', 'G-6', 'G-7', 'G-8', 'G-9', 'G-10', 'G-11', 'G-12', 'G-13', 'G-14', 'G-15', 'G-16', 'G-17', 'G-18', 'G-19')")
            ->get();


            setlocale(LC_TIME, 'es_LA'); // Establece el locale en español

            $fecha_inv = strtoupper(Carbon::now()->formatLocalized('%d DE %B %Y'));

            $nombre_archivo = sprintf('reporte de Aeronves %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
            $data = compact('titulo', 'programacion','num','fecha_inv');
            return Excel::download(new ParteAeronaveExport($data), $nombre_archivo);
            // return view('excel.parteAeronave', $data = compact('titulo', 'programacion','num'));
        }
}
