<?php

namespace App\Http\Controllers;

use App\Models\Cargos;
use App\Models\Ciudades;
use App\Models\EmpleadoFuncion;
use App\Models\EmpleadosOtroComponente;
use App\Models\Estados;
use App\Models\FuncionTripulante;
use App\Models\GradosMilitares;
use App\Models\MovimientosExtra;
use App\Models\Nivel;
use App\Models\Profesion;
use App\Models\PromocionesMilitares;
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
        $user_auth = auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $nacionalidades = Config::get('constants.nacionalidad');
        $generos = Config::get('constants.sexo');
        $componentes = Config::get('constants.componentes');
        $edos_civil = Config::get('constants.edo_civil');
        $estados = Estados::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $niveles = Nivel::all();
        $cargos = Cargos::all();
        $universidades = Universidades::all();
        $profesiones = Profesion::all();

        return view(
            'extra_component.ingreso',
            compact(
                'user_auth',
                'tipos_emp',
                'generos',
                'edos_civil',
                'estados',
                'ubicaciones',
                'ubicaciones_det',
                'niveles',
                'cargos',
                'nacionalidades',
                'universidades',
                'profesiones',
                'componentes'
            )
        );
    }


    public function registraPerson(Request $request)
    {

        $this->validate(
            $request,
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
            // Obtener el último código de empleado de la base de datos
            $lastCodigo = EmpleadosOtroComponente::select('codigo_empleado')
                ->orderBy('id', 'desc')
                ->value('codigo_empleado');

            // Incrementar el número del código de empleado
            $nextNumber = intval(substr($lastCodigo, 1)) + 1;

            // Crear el nuevo código de empleado
            $codigo_empleado = 'E' . $nextNumber;
            if ($request->file("foto")) {
                $ext = $request->file('foto')->getClientOriginalExtension();
                $file_name = 'empleado_' . $request->cedula . '.' . $ext;

                $path_foto = 'fotos/empleados/' . $file_name;
                if (file_exists($path_foto)) {
                    unlink($path_foto); // Eliminamos la imagen previa si existe.
                }
                Image::make($request->file('foto'))->save(public_path($path_foto));
            } else {
                $path_foto = null;
            }

            $empleado = new EmpleadosOtroComponente;
            $empleado->codigo_empleado = $codigo_empleado;
            $empleado->tipo_emp = $request->tipo_emp;
            $empleado->nacionalidad = $request->nacionalidad;
            $empleado->cedula = $request->cedula;
            $empleado->nombre1 = $request->nombre1;
            $empleado->nombre2 = $request->nombre2;
            $empleado->apellido1 = $request->apellido1;
            $empleado->apellido2 = $request->apellido2;
            $empleado->fecha_nacim = $request->fecha_nacim;
            $empleado->sexo = $request->genero;
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
            $empleado->componente = $request->componente;
            $empleado->contacto_emergencia = $request->persona_contacto;
            $empleado->telefono_emergencia = $request->telefono_e;
            $empleado->foto = $path_foto ? $path_foto :  null;
            $empleado->save();





            return redirect()->route('extra.index',)->with('success', 'Se ha ingresado al Personal');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }
    public function personal(Request $request)
    {
        $empleados = EmpleadosOtroComponente::where('empleados_otro_componente.situacion', 'ACTIVO');
        $empleados->leftJoin('ubicaciones', 'ubicaciones.codigo_ubicacion', '=', 'empleados_otro_componente.codigo_ubicacion');
        $empleados->leftJoin('grados_militares', 'grados_militares.codigo_grado', '=', 'empleados_otro_componente.codigo_grado');
        $empleados->select(
            'empleados_otro_componente.id',
            'empleados_otro_componente.codigo_empleado',
            'empleados_otro_componente.cedula',
            'empleados_otro_componente.nombre1',
            'empleados_otro_componente.nombre2',
            'empleados_otro_componente.apellido1',
            'empleados_otro_componente.apellido2',
            'empleados_otro_componente.componente',
            'grados_militares.descripcion as grado_militar',
            'ubicaciones.descripcion as ubicacion'
        );

        // Columnas en el DataTables
        $datatable = Datatables::of($empleados)
            ->addColumn('actions', 'extra_component._actions')
            ->addColumn('componente_nombre', function ($empleado) {
                $componente = Config::get('constants.componentes');
                return $componente[$empleado->componente] ?? '';
            })
            ->rawColumns(['actions']);

        return $datatable->make(true);
    }
    public function index()
    {
        return view('extra_component.index');
    }
    public function viewPersonal($id)
    {
        $user_auth = auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $nacionalidades = Config::get('constants.nacionalidad');
        $generos = Config::get('constants.sexo');
        $edos_civil = Config::get('constants.edo_civil');
        $situaciones = Config::get('constants.situacion');
        $componente = Config::get('constants.componentes');
        $lateralidades = Config::get('constants.zur_der_amb');
        $estados = Estados::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $niveles = Nivel::all();
        $cargos = Cargos::all();
        $universidades = Universidades::all();
        $profesiones = Profesion::all();
        $ciudades = Ciudades::all();
        $grados_militares = GradosMilitares::all();
        $datos = EmpleadosOtroComponente::find($id);


        return view(
            'extra_component.view',
            compact(
                'datos',
                'ciudades',
                'grados_militares',
                'user_auth',
                'tipos_emp',
                'generos',
                'edos_civil',
                'estados',
                'ubicaciones',
                'ubicaciones_det',
                'niveles',
                'cargos',
                'nacionalidades',
                'universidades',
                'profesiones',
                'situaciones',
                'lateralidades',
                'componente'
            )
        );
    }
    public function editPersonal($id)
    {
        $user_auth = auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $nacionalidades = Config::get('constants.nacionalidad');
        $generos = Config::get('constants.sexo');
        $edos_civil = Config::get('constants.edo_civil');
        $situaciones = Config::get('constants.situacion');
        $componente = Config::get('constants.componentes');
        $lateralidades = Config::get('constants.zur_der_amb');
        $estados = Estados::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $niveles = Nivel::all();
        $cargos = Cargos::all();
        $universidades = Universidades::all();
        $profesiones = Profesion::all();
        $ciudades = Ciudades::all();
        $grados_militares = GradosMilitares::all();
        $datos = EmpleadosOtroComponente::find($id);
        return view(
            'extra_component.edit',
            compact(
                'datos',
                'ciudades',
                'user_auth',
                'tipos_emp',
                'generos',
                'edos_civil',
                'estados',
                'ubicaciones',
                'ubicaciones_det',
                'niveles',
                'cargos',
                'nacionalidades',
                'universidades',
                'profesiones',
                'situaciones',
                'lateralidades',
                'grados_militares',
                'componente'
            )
        );
    }

    public function updatePersonal(Request $request)
    {

        $this->validate(
            $request,
            [
                'cedula' => 'required',
                'nacionalidad' => 'required',
                'nombre1' => 'required',
                'apellido1' => 'required',
                'sexo' => 'required',
                'edo_civil' => 'required',
                'fecha_nacim' => 'required',
                'estado' => 'required',
                'ciudad' => 'required',
                'direccion' => 'required',
                'grado_militar' => 'required',
                'componente' => 'required',
                'tipo_emp' => 'required',
            ],
            [
                'cedula.required' => 'La cedula es requerida',
                'nacionalidad.required' => 'La nacionalidad es requerida',
                'nombre1.required' => 'El primer nombre es requerido',
                'apellido1.required' => 'El primer apellido es requerido',
                'sexo.required' => 'El sexo es requerido',
                'edo_civil.required' => 'El estado civil es requerido',
                'fecha_nacim.required' => 'La fecha de nacimiento es requerida',
                'estado.required' => 'El estado donde vive es requerido',
                'ciudad.required' => 'La ciudad donde vive es requerida',
                'direccion.required' => 'La direccion es requerida',
                'grado_militar.required' => 'El grado militar es requerido',
                'componente' => 'El componente es requerido',
                'tipo_emp' => 'el tipo de empleado es requerido'
            ]
        );
        try {
            if ($request->hasFile("foto")) {   // Si se envía una foto
                $ext = $request->file('foto')->getClientOriginalExtension();
                $file_name = 'empleado_' . $request->cedula . '.' . $ext; // Nombre del archivo

                $path_foto = 'fotos/empleados/' . $file_name;
                if (file_exists($path_foto)) {
                    unlink($path_foto); // Eliminamos la imagen previa si existe.
                }
                Image::make($request->file('foto'))->save(public_path($path_foto)); // Guardamos la imagen en la ruta especificada

                $updateData = [
                    // Aquí agregamos la columna de la foto para la actualización
                    "foto" => $path_foto,
                ];
            } else {
                $updateData = []; // Sin cambios en la columna de la foto
            }

            $empleado = EmpleadosOtroComponente::where('codigo_empleado', $request->codigo_empleado)->update([
                "cedula" => $request->cedula,
                "nacionalidad" => $request->nacionalidad,
                "nombre1" => $request->nombre1,
                "nombre2" => $request->nombre2,
                "apellido1" => $request->apellido1,
                "apellido2" => $request->apellido2,
                "sexo" => $request->sexo,
                "estado_civil" => $request->edo_civil,
                "fecha_nacim" => $request->fecha_nacim,
                "telefono_casa" => $request->telefono_casa,
                "telefono" => $request->telefono,
                "estado" => $request->estado,
                "ciudad" => $request->ciudad,
                "direccion" => $request->direccion,
                "componente" => $request->componente,
                "codigo_grado" => $request->grado_militar,
                "correo" => $request->correo,
                "zurd_der_amb" => $request->zur_der_amb,
                "contacto_emergencia" => !empty($request->persona_contacto) ? $request->persona_contacto : null,
                "telefono_emergencia" => !empty($request->telefono_e) ? $request->telefono_e : null,

            ] + $updateData);


            return redirect()->route('personal.view', [$request->id])->with('success', 'Se han actualizado los Datos del Profesional');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }

    public function EgresarPersonal(Request $request)
    {
        $empleado = EmpleadosOtroComponente::where('id', $request->id)->first();

        $updateSituacion = EmpleadosOtroComponente::where('codigo_empleado', $empleado->codigo_empleado)->update([
            'situacion' => 'EGRESADO'
        ]);


        $movimiento = new MovimientosExtra;
        $movimiento->codigo_empleado = $empleado->codigo_empleado;
        $movimiento->fecha_movimiento = $request->fechaSuspencion;
        $movimiento->tipo_movimiento = $request->motivo;
        $movimiento->situacion = 'E';
        $movimiento->observaciones = $request->observaciones;
        $movimiento->codigo_ubicacion = $empleado->codigo_ubicacion;
        $movimiento->codigo_grado = $empleado->codigo_grado;
        $movimiento->save();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'situacion' => $updateSituacion,
            ]
        );
    }

    public function storeFuncionPersonal(Request $request)
    {

        $empleado = EmpleadosOtroComponente::where('codigo_empleado', $request->codigo_empleado)->first();

        $empleado->empleadoFuncion()->sync($request->funcion_id);

        /*$loop = count($request->funcion_id);
        for ($i=0; $i < $loop; $i++) {
            $funcion = new EmpleadoFuncion;
            $funcion->codigo_empleado = $request->codigo_empleado;
            $funcion->id_funcion = $request->funcion_id[$i];
            $funcion->save();
        }*/
        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                //'data' => $funcion,
            ]
        );
    }
    //MOSTRAR DATA PARA AGREGAR FUNCION PERSONAL MILITAR
    public function showDataPersonal(Request $request)
    {
        $data = EmpleadosOtroComponente::where('codigo_empleado', $request->id)->get();
        $funcionEmpleado = FuncionTripulante::get();
        $haveFuncion = EmpleadoFuncion::where('codigo_empleado', $request->id)
            ->join('funcion_tripulante', 'funcion_tripulante.id', '=', 'empleado_funcion.id_funcion')
            ->select(
                'empleado_funcion.id',
                'empleado_funcion.id_funcion',
                'funcion_tripulante.funcion',
            )
            ->get();
        $idsFuncion = $haveFuncion->pluck('id_funcion')->toArray();
        //dd($idsFuncion);
        return response()->json(
            [
                'success' => true,
                'message' => 'Data',
                'data' => $data,
                'haveFuncion' => $haveFuncion,
                'funcionTripulante' => $funcionEmpleado,
                'idsFuncion' => $idsFuncion
            ]
        );
    }
    public function deteleFuncionPersonal(Request $request)
    {
        EmpleadoFuncion::find($request->id)->delete();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data Eliminada'
            ]
        );
    }
}
