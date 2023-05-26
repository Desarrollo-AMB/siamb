<?php

namespace App\Http\Controllers;

use App\Models\AeronaveMatricula;
use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Paf;
use App\Models\Intelectuales;
use App\Models\DatosBoleta;
use App\Models\Ubicaciones;
use App\Models\Cargos;
use App\Models\GradosMilitares;
use App\Models\Nivel;
use App\Models\Fam0001;
use App\Models\Fam0001A1Mision;
use App\Models\Partegenerales;
use DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $date = Carbon::now();
        $ultimo_year = $date->format('Y')-1;
        $hoy = $date->format('Y-m-d');
        $ultimo_mes_completo = $date->subMonth(6);
        $ultimo_mes_completo = $ultimo_mes_completo->format('Y-m-d');
        $year = date('Y'); // Obtiene el año actual
        $lastYear = $year - 2;
        $lastYear2 = $year - 3;

        $militares_activos = Empleado::with(['nomina'])
                ->whereHas('nomina', function ($query) {
                    $query->where('situacion', 'A');
                    $query->whereIn('tipo_emp',['MIL','MEX','TRP']);
                }
            )
            ->count();
            $evaluacionesANTe = Intelectuales::whereYear('fechaI',  $lastYear2)->where('is_deleted',0)
            ->count();
            $evaluacionesANT = Intelectuales::whereYear('fechaI',  $lastYear)->where('is_deleted',0)
            ->count();
        $evaluaciones = Intelectuales::whereYear('fechaI',  $ultimo_year)->where('is_deleted',0)
            ->count();
        $pafs = Paf::whereYear('fecha_pres',  $ultimo_year)->where('is_deleted',0)
            ->count();
            $pafs1 = Paf::whereYear('fecha_pres',  $lastYear)->where('is_deleted',0)
            ->count();
            $pafs2 = Paf::whereYear('fecha_pres',  $lastYear2)->where('is_deleted',0)
            ->count();
        $sanciones = DatosBoleta::count();
        $sanciones_aprobadas = DatosBoleta::where('status', 1)
            ->count();
        $sanciones_denegadas = DatosBoleta::where('status', 2)
            ->count();
        $sanciones_pendientes = DatosBoleta::where('status', 0)
            ->count();
        $sanciones_registradas_year = DatosBoleta::whereYear('fecha',  $ultimo_year)
            ->count();
        $sanciones_aprobadas_year = DatosBoleta::where('status', 1)->whereYear('fecha',  $ultimo_year)
            ->count();
        $sanciones_denegadas_year = DatosBoleta::where('status', 2)->whereYear('fecha',  $ultimo_year)
            ->count();
        $procedimientos_devueltos = DatosBoleta::where('status', 3)->whereYear('fecha',  $ultimo_year)
            ->count();
            $procedimientos_devueltos1 = DatosBoleta::where('status', 3)->whereYear('fecha',  $lastYear)
            ->count();

            $procedimientos_devueltos2 = DatosBoleta::where('status', 3)->whereYear('fecha',  $lastYear2)
            ->count();
        $vuelos_registrados = Fam0001::whereBetween('fecha',[$ultimo_mes_completo,$hoy])
        ->count();
        $vuelos_completados = Fam0001::whereBetween('fam0001.fecha',[$ultimo_mes_completo,$hoy])
        ->select(DB::raw("SUM(case when fam0001.completado = 'completado' then 1 ELSE 0 END) AS completados"), DB::raw("SUM(case when fam0001.completado != 'completado' then 1 ELSE 0 END) AS pendientes"), DB::raw("DATE_FORMAT(fam0001.fecha, '%m-%Y') as new_date"), DB::raw('YEAR(fam0001.fecha) as anno, MONTH(fam0001.fecha) as mes'))
        ->groupBy('anno','mes')
        ->orderby('anno','asc')
        ->orderby('mes','asc')
        ->get();


        $aeronave = AeronaveMatricula::select(
            \DB::raw('count(*) as total'),
            \DB::raw('sum(case when estatus  = "DISPONIBLE" then 1 else 0 end) as disponible'),
            \DB::raw('sum(case when estatus = "INDISPONIBLE" then 1 else 0 end) as indisponible'),
            \DB::raw('sum(case when estatus = "DISPONIBLE PARA EL COMBATE" then 1 else 0 end) as disponible_combate'),
            \DB::raw('sum(case when estatus = "SINIESTRADA" then 1 else 0 end) as siniestrada'),

        )
        ->get();

        $mesEnCurso = Carbon::now()->month;
        $anioEnCurso = Carbon::now()->year;
        $totalDias = Carbon::now()->daysInMonth;

        $vuelosPorDia = [];

        for ($dia = 1; $dia <= $totalDias; $dia++) {
            $fecha = Carbon::create($anioEnCurso, $mesEnCurso, $dia);

            $vuelosDia = Fam0001A1Mision::select(
                \DB::raw('count(*) as total'),
                \DB::raw('sum(case when completado  = "completado" then 1 else 0 end) as completado'),
                \DB::raw('sum(case when completado != "completado" then 1 else 0 end) as pendiente')
            )
                ->whereDate('updated_at', $fecha)
                ->first();

            $vuelosPorDia[] = [
                'fecha' => $fecha->toDateString(),
                'total' => $vuelosDia->total,
                'completado' => $vuelosDia->completado,
                'pendiente' => $vuelosDia->pendiente,
            ];
        }

        $data1 = [
            'values' => [120, 150, 180, 90, 200],
        ];
        $data = [
            ['Manzanas', 5],
            ['Naranjas', 3],
            ['Peras', 4],
            ['Plátanos', 7],
            ['Sandías', 2]
        ];
        //dd($vuelos_completados);

        //dd(DB::getQueryLog());
        //dd($militares_activos);
        //dd($evaluaciones,$date);

        return view('home',
            compact(
                'militares_activos', 'evaluaciones', 'pafs', 'ultimo_year',
                'sanciones', 'sanciones_aprobadas', 'sanciones_denegadas',
                'sanciones_pendientes', 'sanciones_registradas_year',
                'sanciones_aprobadas_year', 'sanciones_denegadas_year',
                'procedimientos_devueltos','vuelos_registrados','ultimo_mes_completo','hoy',
                'vuelos_completados','data','data1','evaluacionesANT','evaluacionesANTe',
                'pafs1','pafs2','procedimientos_devueltos1','procedimientos_devueltos2','aeronave','vuelosPorDia'
            )
        );
    }

    public function no_authorize()
    {
        return view('no_authorize');
    }

    public function auxiliares()
    {
        return view('auxiliares.auxiliares');
    }
}
