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

class CondecoracionesController extends Controller
{
    public function indexView($id){
        $datos = Empleado::with(['nomina','nomina.cargo','estudios_realizados','nomina.datos_militares','nomina.ubicacion'])->find($id);

        $familiares = Familiares::where('codigo_empleado',$datos->codigo_empleado)->get();
        $tipos_emp = TiposEmpleado::all();
        $edos_civil = Config::get('constants.edo_civil');
        $ubicaciones = Ubicaciones::all();
        $cargos = Cargos::all();
        $grados_militares = GradosMilitares::whereIn('tipo_emp',['MIL','TRP'])->get();
      
        $condecoraciones = Condecoracion::whereIn('tipo_emp',[$datos->nomina->tipo_emp,''])->get();
        $niveles = Nivel::all();
        $categorias_militares = CategoriasMilitares::where('tipo_emp',$datos->nomina->tipo_emp)->get();
        return view('sireh.condecoraciones.view', 
            compact(
                'datos','familiares','tipos_emp','edos_civil','ubicaciones','cargos','grados_militares',
                'condecoraciones', 'niveles','categorias_militares'
            )
        );
    }

    //Obtiene las condecoraciones del empleados, exclusivo por api para el Datatable 
    public function dataCondecoraciones(Request $request){
        $condecoraciones = MilitaresCondecorados::join('condecoraciones_militares','militares_condecorados.codigo_condecoracion','=','condecoraciones_militares.codigo_condecoracion')
            ->join('grados_militares','grados_militares.codigo_grado','=','militares_condecorados.codigo_grado')
            ->where('codigo_empleado',$request->codigo_empleado); 
       
        $condecoraciones->select(
            'militares_condecorados.id',
            'condecoraciones_militares.descripcion as condecoracion',
            'militares_condecorados.fecha_condecoracion',
            'grados_militares.descripcion as grado',
            'militares_condecorados.resuelto',
        );
        $condecoraciones->orderBy('id');
        $datatable= Datatables::of($condecoraciones)
            ->addColumn('actions', 'sireh.condecoraciones._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function edit($id){
        $condecoracion = MilitaresCondecorados::find($id);
        return response()->json($condecoracion);
    }

    public function store(Request $request){
        
        if ($request->id){
            try {
                $condecoracion = MilitaresCondecorados::find($request->id);
                $condecoracion->codigo_condecoracion = $request->codigo_condecoracion;
                $condecoracion->resuelto = $request->resuelto;
                $condecoracion->fecha_condecoracion = $request->fecha_condecoracion;
                $condecoracion->codigo_grado = $request->codigo_grado;
                $condecoracion->usuario = auth()->user()->username;
                $condecoracion->update();
                return response()->json(['success'=>true]);
            } catch (Exception $e) {
                Log::error("************************* ERROR ************************* \n" . $e);
                return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
            }
        }else{
            try {
                $condecoracion = new MilitaresCondecorados();
                $condecoracion->codigo_empleado = $request->id_empleado;
                $condecoracion->codigo_condecoracion = $request->codigo_condecoracion;
                $condecoracion->resuelto = $request->resuelto;
                $condecoracion->fecha_condecoracion = $request->fecha_condecoracion;
                $condecoracion->codigo_grado = $request->codigo_grado;
                $condecoracion->usuario = auth()->user()->username;
                $condecoracion->fecha_registro = Carbon::now()->format('Y-m-d');
                $condecoracion->save();
                return response()->json(['success'=>true]);
            } catch (Exception $e) {
                Log::error("************************* ERROR ************************* \n" . $e);
                return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $condecoracion = MilitaresCondecorados::find($id);
        $condecoracion->delete();
        return response()->json(['success' => true]);
    }
}
