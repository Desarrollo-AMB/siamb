<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\Log;

use App\Models\Empleado;
use App\Models\Nomina;
use App\Models\Familiares;
use App\Models\TiposEmpleado;
use App\Models\Ubicaciones;
use App\Models\Cargos;
use App\Models\GradosMilitares;
use App\Models\Nivel;

class CargaFamiliarController extends Controller
{
    public function cargaFamiliar($id){
        $datos = Empleado::with(['nomina','nomina.cargo','estudios_realizados','nomina.datos_militares','nomina.ubicacion'])->find($id);

        $familiares = Familiares::where('codigo_empleado',$datos->codigo_empleado)->get();
        $tipos_emp = TiposEmpleado::all();
        $edos_civil = Config::get('constants.edo_civil');
        $ubicaciones = Ubicaciones::all();
        $cargos = Cargos::all();
        $grados_militares = GradosMilitares::where('tipo_emp',$datos->nomina->tipo_emp)->get();
        $generos = Config::get('constants.sexo');
        $parentescos = Config::get('constants.parentesco');
        $niveles = Nivel::all();
        return view('sireh.carga_familiar.view', 
            compact(
                'datos','familiares','tipos_emp','edos_civil','ubicaciones','cargos','grados_militares',
                'generos', 'parentescos','niveles'
            )
        );
    }

    //Obtiene las carga familiar del empleados, exclusivo por api para el Datatable 
    public function dataCargaFamiliar(Request $request){
        $familiares = Familiares::where('codigo_empleado',$request->codigo_empleado); 
       
        $familiares->select(
            'familiares.id',
            'familiares.numero_familiar',
            'familiares.cedula_familiar',
            'familiares.parentesco',
            'familiares.fecha_nacimiento',
            'familiares.sexo',
            'familiares.nombre1',
            'familiares.apellido1',
            'familiares.nombre2',
            'familiares.apellido2',
        );
        $familiares->orderBy('numero_familiar');
        $datatable= Datatables::of($familiares)
            ->addColumn('actions', 'sireh.carga_familiar._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function editCargaFamiliar($id){
        $familiar = Familiares::find($id);
        return response()->json($familiar);
    }

    public function storeCargarFamiliar(Request $request){
        
        if ($request->id){
            try {
                $familiar = Familiares::find($request->id);
                $familiar->parentesco = $request->parentesco;
                $familiar->cedula_familiar = $request->cedula_familiar;
                $familiar->nombre1 = $request->nombre1;
                $familiar->nombre2 = $request->nombre2;
                $familiar->apellido1 = $request->apellido1;
                $familiar->apellido2 = $request->apellido2;
                $familiar->fecha_nacimiento = $request->fecha_nacimiento;
                $familiar->sexo = $request->genero;
                $familiar->nivel_instruccion = $request->nivel;
                $familiar->discapacidad = $request->discapacidad;
                $familiar->update();
                return response()->json(['success'=>true]);
            } catch (Exception $e) {
                Log::error("************************* ERROR ************************* \n" . $e);
                return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
            }
        }else{
            try {
                $num_familiar =  Familiares::where('codigo_empleado',$request->id_empleado)->max('numero_familiar')+1;
                $familiar = new Familiares();
                $familiar->codigo_empleado = $request->id_empleado;
                $familiar->numero_familiar = $num_familiar;
                $familiar->parentesco = $request->parentesco;
                $familiar->cedula_familiar = $request->cedula_familiar;
                $familiar->nombre1 = $request->nombre1;
                $familiar->nombre2 = $request->nombre2;
                $familiar->apellido1 = $request->apellido1;
                $familiar->apellido2 = $request->apellido2;
                $familiar->fecha_nacimiento = $request->fecha_nacimiento;
                $familiar->sexo = $request->genero;
                $familiar->nivel_instruccion = $request->nivel;
                $familiar->discapacidad = $request->discapacidad;
                $familiar->save();
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
        $familiar = Familiares::find($id);
        $familiar->delete();
        return response()->json(['success' => true]);
    }
}
