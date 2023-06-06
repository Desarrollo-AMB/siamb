<?php

namespace App\Http\Controllers;

use App\Models\Cargos;
use App\Models\EmpleadosOtroComponente;
use App\Models\Estados;
use App\Models\Nivel;
use App\Models\Profesion;
use App\Models\TiposEmpleado;
use App\Models\UbicacionDetallada;
use App\Models\Ubicaciones;
use App\Models\Universidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

class empleadoExtraComponeteController extends Controller
{
    public function ingresoPersonal()
    {
        $user_auth=auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $nacionalidades = Config::get('constants.nacionalidad');
        $generos = Config::get('constants.sexo');
        $componentes= Config::get('constants.componentes');
        $edos_civil = Config::get('constants.edo_civil');
        $estados = Estados::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $niveles = Nivel::all();
        $cargos = Cargos::all();
        $universidades = Universidades::all();
        $profesiones = Profesion::all();

        return view('extra_component.ingreso',
            compact(
                'user_auth', 'tipos_emp', 'generos', 'edos_civil',
                'estados', 'ubicaciones', 'ubicaciones_det', 'niveles',
                'cargos', 'nacionalidades', 'universidades', 'profesiones','componentes'
            )
        );
    }


    public function registraPerson(Request $request){

        $this->validate($request,
            [
                'tipo_emp' => 'required',
                'cedula' => 'required|unique:empleados_otro_componente,cedula',
                'nombre1' => 'required',
                'apellido1' => 'required',
                'ubicacion' => 'required',
            ],
            [
                'tipo_emp.required' => 'Tipo de empleado es requerido',
                'nombre1.required' => 'El primer nombre es requerido',
                'apellido1.required' => 'El primer apellido es requerido'
            ]
        );
        try {
            $codigo_empleado = EmpleadosOtroComponente::max('codigo_empleado')+1;
            if ($request->file("foto")){
                $ext = $request->file('foto')->getClientOriginalExtension();
                $file_name = 'empleado_'. $request->cedula . '.' . $ext;

                $path_foto = 'fotos/empleados/' . $file_name;
                if(file_exists($path_foto)){
                    unlink($path_foto); // Eliminamos la imagen previa si existe.
                }
                Image::make($request->file('foto'))->save( public_path($path_foto));
            }else{
                $path_foto = null;
            }

            $empleado = new EmpleadosOtroComponente;
            $empleado->codigo_empleado = $codigo_empleado;
            $empleado->tipo_emp = $request->tipos_emp;
            $empleado->nacionalidad = $request->nacionalidad;
            $empleado->cedula = $request->cedula;
            $empleado->nombre1 = $request->nombre1;
            $empleado->nombre2 = $request->nombre2;
            $empleado->apellido1 = $request->apellido1;
            $empleado->apellido2 = $request->apellido2;
            $empleado->fecha_nacim = $request->fecha_nacim;
            $empleado->sexo = $request->sexo;
            $empleado->estado_civil = $request->edo_civil;
            $empleado->telefono = $request->telefono_cel;
            $empleado->telefono_casa = $request->telefono;
            $empleado->correo = $request->correo;
            $empleado->estado = $request->estado;
            $empleado->ciudad = $request->ciudad;
            $empleado->direccion = $request->direccion;
            $empleado->fecha_ingreso = $request->fecha_ingreso;
            $empleado->codigo_ubicacion = $request->ubicacion;
            $empleado->codigo_grado = $request->grado_militar;
            $empleado->contacto_emergencia = $request->persona_contacto;
            $empleado->telefono_emergencia = $request->telefono_e;
            $empleado->save();





            return redirect()->route('extra.ingreso_personal')->with('success', 'Se ha ingresado al Personal');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }
    public function personal(Request $request){
        $empleados = EmpleadosOtroComponente::where('empleados_otro_componente.situacion','ACTIVO');
        $empleados->leftJoin('ubicaciones','ubicaciones.codigo_ubicacion','=','empleados_otro_componente.codigo_ubicacion');
        $empleados->leftJoin('grados_militares','grados_militares.codigo_grado','=','empleados_otro_componente.codigo_grado');
        $empleados->select(
            'empleados_otro_componente.id',
            'empleados_otro_componente.codigo_empleado',
            'empleados_otro_componente.cedula',
            'empleados_otro_componente.nombre1',
            'empleados_otro_componente.nombre2',
            'empleados_otro_componente.apellido1',
            'empleados_otro_componente.apellido2',
            'grados_militares.descripcion as grado_militar',
            'ubicaciones.descripcion as ubicacion',
        );
        $datatable= Datatables::of($empleados)
            ->addColumn('actions', 'extra_component._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }
    public function index()
    {
        return view('extra_component.index');
    }

}
