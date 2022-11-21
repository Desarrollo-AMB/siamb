<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Paf;
use App\Models\Intelectuales;
use App\Models\DatosBoleta;
use App\Models\Ubicaciones;
use App\Models\Cargos;
use App\Models\GradosMilitares;
use App\Models\Nivel;
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
        //DB::enableQueryLog();
        $militares_activos = Empleado::with(['nomina'])
                ->whereHas('nomina', function ($query) { 
                    $query->where('situacion', 'A'); 
                    $query->whereIn('tipo_emp',['MIL','MEX','TRP']);
                }
            )
            ->count();
        $evaluaciones = Intelectuales::whereYear('fechaI',  $ultimo_year)->where('is_deleted',0)
            ->count();
        $pafs = Paf::whereYear('fecha_pres',  $ultimo_year)->where('is_deleted',0)
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
        //dd(DB::getQueryLog());
        //dd($militares_activos);
        //dd($evaluaciones,$date);
        return view('home', 
            compact(
                'militares_activos', 'evaluaciones', 'pafs', 'ultimo_year',
                'sanciones', 'sanciones_aprobadas', 'sanciones_denegadas',
                'sanciones_pendientes', 'sanciones_registradas_year',
                'sanciones_aprobadas_year', 'sanciones_denegadas_year',
                'procedimientos_devueltos'
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
