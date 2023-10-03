<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Models\Empleado;
use App\Models\Nomina;
use App\Models\Familiares;
use App\Models\TiposEmpleado;
use App\Models\Ubicaciones;
use App\Models\Cargos;
use App\Models\GradosMilitares;
use App\Models\Nivel;
use App\Models\Condecoracion;
use App\Models\MilitaresCondecorados;
use App\Models\CategoriasMilitares;
use App\Models\Sanciones;

class SancionesController extends Controller
{
    public function indexView($id){
        $datos = Empleado::with(['nomina','nomina.cargo','estudios_realizados','nomina.datos_militares','nomina.ubicacion'])->find($id);

        $familiares = Familiares::where('codigo_empleado',$datos->codigo_empleado)->get();
        $tipos_emp = TiposEmpleado::all();
        $edos_civil = Config::get('constants.edo_civil');
        $ubicaciones = Ubicaciones::all();
        $cargos = Cargos::all();
        $grados_militares = GradosMilitares::whereIn('tipo_emp',['MIL','TRP'])->get();

        $niveles = Nivel::all();
        $categorias_militares = CategoriasMilitares::where('tipo_emp',$datos->nomina->tipo_emp)->get();
        return view('sireh.Sanciones.view',
            compact(
                'datos','familiares','tipos_emp','edos_civil','ubicaciones','cargos','grados_militares',
                 'niveles','categorias_militares'
            )
        );
    }

    //Obtiene las condecoraciones del empleados, exclusivo por api para el Datatable
    public function dataSanciones(Request $request)
    
    {
        $sancion = Sanciones::join('aparte_nieto','aparte_nieto.id_aparte_nieto','=','datos_boleta.aparte1')
            ->join('articulo_hijo','articulo_hijo.id_articulo_hijo','=','datos_boleta.articulo1')
            ->where('datos_boleta.cedula',$request->cedula);

        $sancion->select(
            'articulo_hijo.articulo_hijo',
            'aparte_nieto.aparte_nieto',
            'datos_boleta.grado as grado',
            'datos_boleta.fecha as fecha',
            'datos_boleta.articulo1 as articulo1',
            'datos_boleta.aparte1 as aparte1'
        );
        $sancion->where('datos_boleta.status','=',1);    
        $sancion->orderBy('id');
        $datatable= Datatables::of($sancion)
          //  ->addColumn('actions', 'sireh.Sanciones._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }
}
