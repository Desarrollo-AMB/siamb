<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\User;
use App\Models\Empleado;
use App\Models\EmpleadosOtroComponente;
use App\Models\TiposEmpleado;
use App\Models\Estados;
use App\Models\Ubicaciones;
use App\Models\UbicacionDetallada;
use App\Models\Nivel;
use App\Models\Cargos;
use App\Models\Universidades;
use App\Models\Profesion;
use App\Models\Nomina;
use App\Models\DatosMilitares;
use App\Models\EspecialidadesMilitares;
use App\Models\EstudiosRealizados;
use App\Models\Ciudades;
use App\Models\GradosMilitares;
use App\Models\CategoriasMilitares;
use App\Models\PromocionesMilitares;
use App\Models\Movimientos;
use App\Models\Cursos;
use App\Models\CursosRealizados;
use App\Models\IntelectualesCivil;
use App\Models\TipoDeBaja;
use App\Models\Egresos;
use App\Models\FuncionTripulante;
use App\Models\EmpleadoFuncion;
use App\Models\Escalafon;
use App\Exports\PerosnalubicacionesExport;
use App\Exports\PersonalMilitarExport;
use App\Exports\FichaExport;
use App\Exports\PersonalMilitarEnFormacionExport;
use PhpParser\Node\Stmt\Else_;

class PersonalController extends Controller
{
    public function index()
    {
        return view('sireh.personal.index');
    }

    public function indexPersonalMilitar()
    {
        $funcionEmpleado = FuncionTripulante::get();
        return view('sireh.personal.militar.index',
            compact(
                'funcionEmpleado'
            )
        );
    }

    public function indexPersonalCivil()
    {
        $cursos = Cursos::all();
        return view('sireh.personal.civil.index',
            compact(
                'cursos'
            )
        );
    }

    public function indexPersonalMilitarNoProf()
    {
        return view('sireh.personal.militar_noprof.index');
    }

    public function ingresoPersonal()
    {
        $user_auth=auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $nacionalidades = Config::get('constants.nacionalidad');
        $generos = Config::get('constants.sexo');
        $edos_civil = Config::get('constants.edo_civil');
        $estados = Estados::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $niveles = Nivel::all();
        $cargos = Cargos::all();
        $universidades = Universidades::all();
        $profesiones = Profesion::all();
        $categorias = CategoriasMilitares::all();

        return view('sireh.personal.ingreso',
            compact(
                'user_auth', 'tipos_emp', 'generos', 'edos_civil',
                'estados', 'ubicaciones', 'ubicaciones_det', 'niveles',
                'cargos', 'nacionalidades', 'universidades', 'profesiones','categorias'
            )
        );
    }

    public function registraPersonal(Request $request){

        $this->validate($request,
            [
                'tipo_emp' => 'required',
                'cedula' => 'required|unique:empleados,cedula',
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
            $codigo_empleado = Nomina::max('codigo_empleado')+1;
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

            $empleado = new Empleado;
            $empleado->codigo_empleado = $codigo_empleado;
            $empleado->cedula = $request->cedula;
            $empleado->nacionalidad = $request->nacionalidad;
            $empleado->nombre1 = $request->nombre1;
            $empleado->nombre2 = $request->nombre2;
            $empleado->apellido1 = $request->apellido1;
            $empleado->apellido2 = $request->apellido2;
            $empleado->fecha_nacim = $request->fecha_nacim;
            $empleado->sexo = $request->genero;
            $empleado->edo_civil = $request->edo_civil;
            $empleado->situacion = 'I';
            $empleado->nivel_instruccion = $request->nivel;
            $empleado->telefono = $request->telefono;
            $empleado->telefono_cel = $request->telefono_cel;
            $empleado->telefono_ofi = $request->telefono_ofi;
            $empleado->direccion = $request->direccion;
            $empleado->profesion = !empty($request->profesion) ? $request->profesion : null;
            $empleado->ciudad = !empty($request->ciudad) ? $request->ciudad : null;
            $empleado->estado = !empty($request->estado) ? $request->estado : null;
            $empleado->persona_contacto = !empty($request->persona_contacto) ? $request->persona_contacto : null;
            $empleado->telefono_e = !empty($request->telefono_e) ? $request->telefono_e : null;
            $empleado->estado = !empty($request->estado) ? $request->estado : null;
            $empleado->foto = $path_foto ? $path_foto :  null;
            $empleado->correo = $request->correo;
            $empleado->save();

            $nomina = new Nomina;
            $nomina->codigo_empleado = $empleado->codigo_empleado;
            $nomina->nombre1 = $request->nombre1;
            $nomina->nombre2 = $request->nombre2;
            $nomina->apellido1 = $request->apellido1;
            $nomina->apellido2 = $request->apellido2;
            $nomina->situacion = 'I';
            $nomina->cedula = $empleado->cedula;
            $nomina->tipo_emp = $request->tipo_emp;
            $nomina->codigo_ubicacion = $request->ubicacion;
            $nomina->fecha_ingreso = $request->fecha_ingreso;
            $nomina->codigo_cargo = !empty($request->cargo) ? $request->cargo : null;
            $nomina->tipo_ingreso = '1';
            $nomina->grado_militar = !empty($request->grado_militar) ? $request->grado_militar : null;
            $nomina->cod_rac = !empty($request->cod_rac) ? $request->cod_rac : null;
            $nomina->cod_ubicacion_detallada = $request->ubicacion_det;
            $nomina->save();

            if($request->contingente){
                $datos_militares = new DatosMilitares;
                $datos_militares->codigo_empleado = $empleado->codigo_empleado;
                $datos_militares->contingente = $request->contingente;
                $datos_militares->fecha_graduacion = $request->fecha_graduacion;
                $datos_militares->save();
            }
            if( !empty($request->universidad) || !empty($request->profesion)){
                $estudio_realizado = new EstudiosRealizados;
                $estudio_realizado->codigo_empleado = $empleado->codigo_empleado;
                $estudio_realizado->nivel = $request->nivel;
                $estudio_realizado->profesion = $request->profesion;
                $estudio_realizado->universidad = $request->universidad;
                $estudio_realizado->fecha_registro = $request->fecha_ingreso;
                $estudio_realizado->save();
            }
            return redirect()->route('sireh.ingreso-personal.index')->with('success', 'Se ha ingresado al Personal');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }

    public function editIngresoPersonal($id)
    {
        $user_auth=auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $nacionalidades = Config::get('constants.nacionalidad');
        $generos = Config::get('constants.sexo');
        $edos_civil = Config::get('constants.edo_civil');
        $estados = Estados::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $niveles = Nivel::all();
        $cargos = Cargos::all();
        $universidades = Universidades::all();
        $profesiones = Profesion::all();
        $ciudades = Ciudades::all();
        $grados_militares = GradosMilitares::all();
        $datos = Empleado::with(['nomina','datos_militares','estudios_realizados'])->find($id);

        return view('sireh.personal.edit-ingreso',
            compact(
                'datos','ciudades','grados_militares',
                'user_auth', 'tipos_emp', 'generos', 'edos_civil',
                'estados', 'ubicaciones', 'ubicaciones_det', 'niveles',
                'cargos', 'nacionalidades', 'universidades', 'profesiones'
            )
        );
    }

    public function updatePersonal(Empleado $empleado,Request $request){

        $this->validate($request,
            [
                'tipo_emp' => 'required',
                'cedula' => 'required|unique:empleados,cedula,'.$empleado->id,
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
            //$codigo_empleado = Empleado::max('codigo_empleado')+1;
            $empleado = Empleado::where('codigo_empleado', $request->codigo_empleado)->firstOrFail();

            $path_foto_actual = $empleado->foto;
    
            if ($request->hasFile("foto")) { // Si se envía una nueva foto
                $ext = $request->file('foto')->getClientOriginalExtension();
                $file_name = 'empleado_' . $request->cedula . '.' . $ext; // Nombre del archivo
            
                $path_foto_nueva = 'fotos/empleados/' . $file_name;
            
                // Verificar si la foto previa existe antes de eliminarla
                if ($path_foto_actual && file_exists(public_path($path_foto_actual))) {
                    unlink(public_path($path_foto_actual)); // Eliminamos la imagen previa
                }
            
                Image::make($request->file('foto'))->save(public_path($path_foto_nueva)); // Guardamos la nueva imagen
            } else {
                // Si no se envía una nueva foto, mantener la ruta existente
                $path_foto_nueva = $path_foto_actual;
            }

            $empleado->cedula = $request->cedula;
            $empleado->nacionalidad = $request->nacionalidad;
            $empleado->nombre1 = $request->nombre1;
            $empleado->nombre2 = $request->nombre2;
            $empleado->apellido1 = $request->apellido1;
            $empleado->apellido2 = $request->apellido2;
            $empleado->fecha_nacim = $request->fecha_nacim;
            $empleado->sexo = $request->genero;
            $empleado->edo_civil = $request->edo_civil;

            $empleado->nivel_instruccion = $request->nivel;
            $empleado->telefono = $request->telefono;
            $empleado->telefono_cel = $request->telefono_cel;
            $empleado->telefono_ofi = $request->telefono_ofi;
            $empleado->direccion = $request->direccion;
            $empleado->profesion = !empty($request->profesion) ? $request->profesion : null;
            $empleado->ciudad = !empty($request->ciudad) ? $request->ciudad : null;
            $empleado->estado = !empty($request->estado) ? $request->estado : null;
            $empleado->persona_contacto = !empty($request->persona_contacto) ? $request->persona_contacto : null;
            $empleado->telefono_e = !empty($request->telefono_e) ? $request->telefono_e : null;
            $empleado->estado = !empty($request->estado) ? $request->estado : null;
            if ($path_foto_nueva) {
                $empleado->foto = $path_foto_nueva ;
            }
            $empleado->correo = $request->correo;
            $empleado->save();

            $nomina = Nomina::where('codigo_empleado',$empleado->codigo_empleado)->first();
            $nomina->cedula = $empleado->cedula;
            $nomina->tipo_emp = $request->tipo_emp;
            $nomina->codigo_ubicacion = $request->ubicacion;
            $nomina->fecha_ingreso = $request->fecha_ingreso;
            $nomina->codigo_cargo = !empty($request->cargo) ? $request->cargo : null;
            $nomina->grado_militar = !empty($request->grado_militar) ? $request->grado_militar : null;
            $nomina->cod_rac = !empty($request->cod_rac) ? $request->cod_rac : null;
            $nomina->cod_ubicacion_detallada = $request->ubicacion_det;
            $nomina->save();

            if($request->contingente){
                $datos_militares = DatosMilitares::where('codigo_empleado',$empleado->codigo_empleado)->first();
                $datos_militares->contingente = $request->contingente;
                $datos_militares->save();
            }
            if( !empty($request->universidad) || !empty($request->profesion)){
                EstudiosRealizados::updateOrCreate(
                    ['codigo_empleado' => $empleado->codigo_empleado],
                    [
                        'nivel' => $request->nivel,
                        'profesion' => $request->profesion,
                        'universidad' => $request->universidad,
                    ]
                );
            }
            return redirect()->route('sireh.ingreso-personal.index')->with('success', 'Se ha actualizado los Datos de Ingreso de Personal');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Empleado $empleado)
    {
        $empleado = Empleado::find($empleado->id);
        $nomina = Nomina::where('codigo_empleado',$empleado->codigo_empleado)->first();
        $nomina->delete();
        $datos_militares = DatosMilitares::where('codigo_empleado',$empleado->codigo_empleado)->first();
        $datos_militares->delete();
        $estudios_realizados = EstudiosRealizados::where('codigo_empleado',$empleado->codigo_empleado)->first();
        $estudios_realizados->delete();
        $empleado->delete();

        return redirect()->route('sireh.ingreso-personal.index')
            ->with('success','Eliminado satisfactoriamente');
    }

    public function activarIngreso(Empleado $empleado){
        try{
            $empleado->situacion='A';
            $empleado->save();
            $nomina=Nomina::where('codigo_empleado', $empleado->codigo_empleado)->first();
            $nomina->situacion='A';
            $nomina->save();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }

    //Obtiene los empleados registrados aun sin activar el Ingreso, exclusivo por api para el Datatable
    public function empleadosInactivos(Request $request){
        $empleados = Empleado::where('empleados.situacion','I');
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->leftJoin('cargos','cargos.codigo_cargo','=','nomina.codigo_cargo');
        $empleados->leftJoin('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->select(
            'empleados.id',
            'empleados.codigo_empleado',
            'empleados.cedula',
            'empleados.nombre1',
            'empleados.nombre2',
            'empleados.apellido1',
            'empleados.apellido2',
            'tipos_empleados.descripcion as tipo_empleado',
            'ubicaciones.descripcion as ubicacion',
            'cargos.nombre_cargo as cargo',
            'grados_militares.descripcion as grado_militar',
        );
        $datatable= Datatables::of($empleados)
            ->addColumn('actions', 'sireh.personal._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    //Obtiene el personal militar, exclusivo por api para el Datatable
    public function personalMilitar(Request $request){
        $empleados = Empleado::where('empleados.situacion','A');
        $empleados->leftJoin('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->leftJoin('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->leftJoin('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->leftJoin('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MIL','MEX','TRP']);
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
            ->addColumn('actions', 'sireh.personal.militar._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    //Obtiene el personal Civil, exclusivo por api para el Datatable
    public function personalCivil(Request $request){
        $empleados = Empleado::where('empleados.situacion','A');
        //$empleados = Empleado::where('empleados.situacion', '<>','');
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('cargos','cargos.codigo_cargo','=','nomina.codigo_cargo');
        $empleados->whereNotIn('nomina.tipo_emp',['MIL','TRP','ALI','MEF']);
        //$empleados->where('nomina.tipo_emp','<>','MIL')->where('nomina.tipo_emp','<>','TRP')->where('nomina.tipo_emp','<>','ALI')->where('nomina.tipo_emp','<>','MEF');
        $empleados->select(
            'empleados.id',
            'empleados.codigo_empleado',
            'empleados.cedula',
            'empleados.nombre1',
            'empleados.nombre2',
            'empleados.apellido1',
            'empleados.apellido2',
            'tipos_empleados.descripcion as tipo_empleado',
            'cargos.nombre_cargo as cargo',
            'ubicaciones.descripcion as ubicacion',
        );
        $datatable= Datatables::of($empleados)
            ->addColumn('actions', 'sireh.personal.civil._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    //Obtiene el personal militar no profesional, exclusivo por api para el Datatable
    public function personalMilitarNoProf(Request $request){
        $empleados = Empleado::where('empleados.situacion','A');
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['ALI','MEF']);
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
            ->addColumn('actions', 'sireh.personal.militar_noprof._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    //Obtiene los empleados sin asociar Usuario, exclusivo por api para el Datatable
    public function empleadosSinUser(Request $request){
        $empleados = Empleado::whereNull('user_id')->where('empleados.situacion','A');
        //$empleados = Empleado::where('empleados.situacion','A');
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('cargos','cargos.codigo_cargo','=','nomina.codigo_cargo');
        $empleados->select(
            'empleados.codigo_empleado',
            'empleados.cedula',
            'empleados.nombre1',
            'empleados.nombre2',
            'empleados.apellido1',
            'empleados.apellido2',
            'tipos_empleados.descripcion as tipo_empleado',
            'cargos.nombre_cargo as cargo',
            'ubicaciones.descripcion as ubicacion',
        );
        $datatable= Datatables::of($empleados)
            ->addColumn('actions', 'users._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    //Obtiene los empleados que no son del componente Aviacion sin asociar Usuario, exclusivo por api para el Datatable
    public function notEmpleadosSinUser(Request $request){
        $empleados = EmpleadosOtroComponente::whereNull('user_id');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','empleados_otro_componente.codigo_ubicacion');
        $empleados->select(
            'empleados_otro_componente.id',
            'empleados_otro_componente.cedula',
            'empleados_otro_componente.nombre1',
            'empleados_otro_componente.nombre2',
            'empleados_otro_componente.apellido1',
            'empleados_otro_componente.apellido2',
            'ubicaciones.descripcion as ubicacion',
        );
        $datatable= Datatables::of($empleados)
            ->addColumn('actions', 'users._actions2')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function viewPersonalMilitarNoProf($id)
    {
        $user_auth=auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $nacionalidades = Config::get('constants.nacionalidad');
        $generos = Config::get('constants.sexo');
        $edos_civil = Config::get('constants.edo_civil');
        $estados = Estados::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $niveles = Nivel::all();
        $cargos = Cargos::all();
        $universidades = Universidades::all();
        $profesiones = Profesion::all();
        $ciudades = Ciudades::all();
        $grados_militares = GradosMilitares::all();
        $datos = Empleado::with(['nomina','datos_militares','estudios_realizados'])->find($id);
        return view('sireh.personal.militar_noprof.view',
            compact(
                'datos','ciudades','grados_militares',
                'user_auth', 'tipos_emp', 'generos', 'edos_civil',
                'estados', 'ubicaciones', 'ubicaciones_det', 'niveles',
                'cargos', 'nacionalidades', 'universidades', 'profesiones'
            )
        );
    }

    public function viewPersonalMilitar($id)
    {
        $user_auth=auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $nacionalidades = Config::get('constants.nacionalidad');
        $generos = Config::get('constants.sexo');
        $edos_civil = Config::get('constants.edo_civil');
        $situaciones = Config::get('constants.situacion');
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
        $categorias_militares = CategoriasMilitares::all();
        $promociones_militares = PromocionesMilitares::all();
        $especialidades_militares = EspecialidadesMilitares::all();
        $datos = Empleado::with(['nomina','datos_militares'])->find($id);
        return view('sireh.personal.militar.view',
            compact(
                'datos','ciudades','grados_militares',
                'user_auth', 'tipos_emp', 'generos', 'edos_civil',
                'estados', 'ubicaciones', 'ubicaciones_det', 'niveles',
                'cargos', 'nacionalidades', 'universidades', 'profesiones',
                'categorias_militares','situaciones','promociones_militares','especialidades_militares','lateralidades'
            )
        );
    }

    public function editPersonalMilitar($id)
    {
        $user_auth=auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $nacionalidades = Config::get('constants.nacionalidad');
        $generos = Config::get('constants.sexo');
        $edos_civil = Config::get('constants.edo_civil');
        $situaciones = Config::get('constants.situacion');
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
        $categorias_militares = CategoriasMilitares::all();
        $promociones_militares = PromocionesMilitares::all();
        $datos = Empleado::with(['nomina','datos_militares','estudios_realizados'])->find($id);
        return view('sireh.personal.militar.edit',
            compact(
                'datos','ciudades','grados_militares',
                'user_auth', 'tipos_emp', 'generos', 'edos_civil',
                'estados', 'ubicaciones', 'ubicaciones_det', 'niveles',
                'cargos', 'nacionalidades', 'universidades', 'profesiones', 'categorias_militares', 'situaciones',
                'promociones_militares','lateralidades'
            )
        );
    }

    public function updatePersonalMilitar(Request $request){

        $this->validate($request,
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
                'tipo_emp' => 'required',
                'categoria' => 'required',
                'grado_militar' => 'required',
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
                'tipo_emp.required' => 'El tipo de empleado es requerido',
                'categoria.required' => 'La categoria es requerida',
                'grado_militar.required' => 'El grado militar es requerido'
            ]
        );
        try {
            $empleado = Empleado::where('codigo_empleado', $request->codigo_empleado)->firstOrFail();

            $path_foto_actual = $empleado->foto;
    
            if ($request->hasFile("foto")) { // Si se envía una nueva foto
                $ext = $request->file('foto')->getClientOriginalExtension();
                $file_name = 'empleado_' . $request->cedula . '.' . $ext; // Nombre del archivo
            
                $path_foto_nueva = 'fotos/empleados/' . $file_name;
            
                // Verificar si la foto previa existe antes de eliminarla
                if ($path_foto_actual && file_exists(public_path($path_foto_actual))) {
                    unlink(public_path($path_foto_actual)); // Eliminamos la imagen previa
                }
            
                Image::make($request->file('foto'))->save(public_path($path_foto_nueva)); // Guardamos la nueva imagen
            } else {
                // Si no se envía una nueva foto, mantener la ruta existente
                $path_foto_nueva = $path_foto_actual;
            }
            $empleado = Empleado::where('codigo_empleado',$request->codigo_empleado)->update([
                "cedula" => $request->cedula,
                "nacionalidad" => $request->nacionalidad,
                "nombre1" => $request->nombre1,
                "nombre2" => $request->nombre2,
                "apellido1" => $request->apellido1,
                "apellido2" => $request->apellido2,
                "sexo" => $request->sexo,
                "edo_civil" => $request->edo_civil,
                "fecha_nacim" => $request->fecha_nacim,
                "telefono_cel" => $request->telefono_cel,
                "telefono" => $request->telefono,
                "telefono_ofi" => $request->telefono_ofi,
                "estado" => $request->estado,
                "ciudad" => $request->ciudad,
                "direccion" => $request->direccion,
                "correo" => $request->correo,
                "peso" => $request->peso,
                "estatura" => $request->estatura,
                "zur_der_amb" => $request->zur_der_amb,
                "ojos" => $request->ojos,
                "cabellos" => $request->cabellos,
                "color" => $request->color,
                "talla_camisa" => $request->talla_camisa,
                "talla_pant" => $request->talla_pant,
                "talla_chaqueta" => $request->talla_chaqueta,
                "numero_calzado" => $request->numero_calzado,
                "talla_falda" => !empty($request->talla_falda) ? $request->talla_falda : null,
                "persona_contacto" => !empty($request->persona_contacto) ? $request->persona_contacto : null,
                "telefono_e" => !empty($request->telefono_e) ? $request->telefono_e : null,
                "foto" => $path_foto_nueva,
            ]);

            $nomina = Nomina::where('codigo_empleado',$request->codigo_empleado)->update([
                "cedula" => $request->cedula,
                "tipo_emp" => $request->tipo_emp,
                "nombre1" => $request->nombre1,
                "nombre2" => $request->nombre2,
                "apellido1" => $request->apellido1,
                "apellido2" => $request->apellido2,
                "grado_militar" => !empty($request->grado_militar) ? $request->grado_militar : null,
            ]);

            $datos_militares = DatosMilitares::where('codigo_empleado',$request->codigo_empleado)->update([
                "codigo_categoria" => $request->categoria,
                "codigo_promocion" => !empty($request->promocion) ? $request->promocion : null,
            ]);

            $movimiento = new Movimientos;
            $movimiento->codigo_empleado = $request->codigo_empleado;
            $movimiento->fecha_movimiento = date('Y-m-d');
            $movimiento->tipo_movimiento = 'Actualizacion de Datos Personales y Militares';
            $movimiento->tipo_emp_nuevo = $request->tipo_emp;
            $movimiento->codigo_grado = $request->grado_militar;
            $movimiento->codigo_ubicacion = $request->ubicacion;
            $movimiento->fecha_ubicacion = $request->fecha_ubicacion;
            $movimiento->resol_ubicacion = $request->resolucion_ubicacion;
            $movimiento->codigo_cargo = $request->cargo;
            $movimiento->fecha_cargo = $request->fecha_cargo;
            $movimiento->resol_cargo = $request->resolucion_cargo;
            $movimiento->ubicacion_detallada = $request->ubicacion_detallada;

            $movimiento->save();

            return redirect()->route('sireh.personal-militar.view', [$request->id])->with('success', 'Se han actualizado los Datos del Profesional');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }

    public function cargosPersonalMilitar($id)
    {
        $user_auth=auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $cargos = Cargos::all();
        $grados_militares = GradosMilitares::all();
        $movimientos = Movimientos::all();
        $datos = Empleado::with(['nomina','movimientos'])->find($id);
        return view('sireh.personal.militar.cargo',
            compact(
                'datos', 'grados_militares', 'user_auth', 'tipos_emp',
                'ubicaciones', 'ubicaciones_det', 'cargos', 'movimientos'
            )
        );
    }

    public function updateCargosPersonalMilitar(Request $request){

        $this->validate($request,
            [
                'cargo' => 'required',
                'fecha_inic_cargo' => 'required',
                'nro_resolucion_cargo' => 'required',
            ],
            [
                'cargo.required' => 'El cargo es requerido',
                'fecha_inic_cargo.required' => 'La fecha de inicio del cargo es requerida',
                'nro_resolucion_cargo.required' => 'El numero de resolución es requerido'
            ]
        );
        try {
            $nomina = Nomina::where('codigo_empleado',$request->codigo_empleado)->update([
                "codigo_cargo" => !empty($request->cargo) ? $request->cargo : 0,
                "fecha_inic_cargo" => !empty($request->fecha_inic_cargo) ? $request->fecha_inic_cargo : 0,
                "nro_resolucion_cargo" => !empty($request->nro_resolucion_cargo) ? $request->nro_resolucion_cargo : 0,
            ]);

            $nomina = Nomina::where('codigo_empleado',$request->codigo_empleado)->first();

            $movimiento = new Movimientos;
            $movimiento->codigo_empleado = $request->codigo_empleado;
            $movimiento->fecha_movimiento = date('Y-m-d');
            $movimiento->tipo_movimiento = 'Actualizacion del Cargo';
            //$movimiento->situacion = $datos_anteriores->situacion;
            //$movimiento->tipo_emp_anterior = $datos_anteriores->tipo_emp;
            $movimiento->tipo_emp_nuevo = $nomina->tipo_emp;
            //$movimiento->codigo_grado_anterior = $datos_anteriores->grado_militar;
            $movimiento->codigo_grado = $nomina->grado_militar;
            //$movimiento->ubicacion_anterior = $datos_anteriores->ubicacion;
            $movimiento->codigo_ubicacion = $nomina->codigo_ubicacion;
            //$movimiento->cargo_anterior = $datos_anteriores->cargo;
            $movimiento->codigo_cargo = $request->cargo;
            //$movimiento->fecha_cargo_anterior = $datos_anteriores->fecha_cargo;
            $movimiento->fecha_cargo = $request->fecha_inic_cargo;
            //$movimiento->resol_cargo_anterior = $datos_anteriores->resolucion_cargo;
            $movimiento->resol_cargo = $request->nro_resolucion_cargo;
            $movimiento->ubicacion_detallada = $nomina->cod_ubicacion_detallada;
            //dd($movimiento);
            $movimiento->save();

            return redirect()->route('sireh.personal-militar.cargo', [$request->id])->with('success', 'Se ha actualizado el Cargo del Profesional');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }

    public function ubicacionesPersonalMilitar($id)
    {
        $user_auth=auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $cargos = Cargos::all();
        $grados_militares = GradosMilitares::all();
        $movimientos = Movimientos::all();
        $datos = Empleado::with(['nomina','movimientos'])->find($id);
        return view('sireh.personal.militar.ubicacion',
            compact(
                'datos', 'grados_militares', 'user_auth', 'tipos_emp',
                'ubicaciones', 'ubicaciones_det', 'cargos', 'movimientos'
            )
        );
    }

    public function updateUbicacionesPersonalMilitar(Request $request){

        $this->validate($request,
            [
                'ubicacion' => 'required',
                'ubicacion_detallada' => 'required',
                'fecha_inic_ubicacion' => 'required',
                'nro_resolucion_ubicacion' => 'required',
            ],
            [
                'ubicacion.required' => 'La ubicación es requerida',
                'ubicacion_detallada.required' => 'La ubicación detallada es requerida',
                'fecha_inic_ubicacion.required' => 'La fecha de inicio de la ubicación es requerida',
                'nro_resolucion_ubicacion.required' => 'El numero de resolución es requerido'
            ]
        );
        try {
            $nomina = Nomina::where('codigo_empleado',$request->codigo_empleado)->update([
                "codigo_ubicacion" => !empty($request->ubicacion) ? $request->ubicacion : 0,
                "cod_ubicacion_detallada" => !empty($request->ubicacion_detallada) ? $request->ubicacion_detallada : 0,
                "fecha_inic_ubicacion" => !empty($request->fecha_inic_ubicacion) ? $request->fecha_inic_ubicacion : 0,
                "nro_resolucion_ubicacion" => !empty($request->nro_resolucion_ubicacion) ? $request->nro_resolucion_ubicacion : 0,
            ]);

            $nomina = Nomina::where('codigo_empleado',$request->codigo_empleado)->first();

            $movimiento = new Movimientos;
            $movimiento->codigo_empleado = $request->codigo_empleado;
            $movimiento->fecha_movimiento = date('Y-m-d');
            $movimiento->tipo_movimiento = 'Actualizacion de la Ubicacion';
            //$movimiento->situacion = $datos_anteriores->situacion;
            //$movimiento->tipo_emp_anterior = $datos_anteriores->tipo_emp;
            $movimiento->tipo_emp_nuevo = $nomina->tipo_emp;
            //$movimiento->codigo_grado_anterior = $datos_anteriores->grado_militar;
            $movimiento->codigo_grado = $nomina->grado_militar;
            //$movimiento->ubicacion_anterior = $datos_anteriores->ubicacion;
            $movimiento->codigo_ubicacion = $request->ubicacion;
            //$movimiento->fecha_ubicacion_anterior = $datos_anteriores->fecha_ubicacion;
            $movimiento->fecha_ubicacion = $request->fecha_inic_ubicacion;
            //$movimiento->resol_ubicacion_anterior = $datos_anteriores->resolucion_ubicacion;
            $movimiento->resol_ubicacion = $request->nro_resolucion_ubicacion;
            //$movimiento->cargo_anterior = $datos_anteriores->cargo;
            $movimiento->codigo_cargo = $nomina->codigo_cargo;
            //$movimiento->ubicacion_detallada_anterior = $datos_anteriores->ubicacion_detallada;
            $movimiento->ubicacion_detallada = $request->ubicacion_detallada;

            $movimiento->save();

            return redirect()->route('sireh.personal-militar.ubicacion', [$request->id])->with('success', 'Se ha actualizado la Ubicación del Profesional');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }

    public function listPersonalMilitarSuspendido()
    {
        return view('sireh.personal.militar.suspendidos.index');
    }

    //Obtiene el personal militar suspendido, exclusivo por api para el Datatable
    public function personalMilitarSuspendido(Request $request){
        $empleados = Empleado::where('empleados.situacion','S');
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp',['MIL','MEX','TRP']);
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
            ->addColumn('actions', 'sireh.personal.militar.suspendidos._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function suspenderPersonalMilitar(Request $request)
    {
        $empleado = Empleado::where('id',$request->id)->first();
        $nomina = Nomina::where('codigo_empleado',$empleado->codigo_empleado)->first();

        $updateSituacion = Nomina::where('codigo_empleado', $empleado->codigo_empleado)->update([
            'situacion' => 'S'
        ]);
        $updateSituacion = Empleado::where('id', $request->id)->update([
            'situacion' => 'S'
        ]);

        $movimiento = new Movimientos;
        $movimiento->codigo_empleado = $empleado->codigo_empleado;
        $movimiento->fecha_movimiento = $request->fechaSuspencion;
        $movimiento->tipo_movimiento = $request->motivo;
        $movimiento->situacion = 'S';
        $movimiento->observaciones = $request->observaciones;
        $movimiento->codigo_ubicacion = $nomina->codigo_ubicacion;
        $movimiento->codigo_cargo = $nomina->codigo_cargo;
        $movimiento->tipo_emp_nuevo = $nomina->tipo_emp;
        $movimiento->codigo_grado = $nomina->grado_militar;
        $movimiento->ubicacion_detallada = $nomina->cod_ubicacion_detallada;

        $movimiento->save();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'situacion' => $updateSituacion,
            ]
        );
    }

    public function listPersonalMilitarBajas()
    {
        return view('sireh.personal.militar.bajas.index');
    }

    //Obtiene el personal militar egresado, exclusivo por api para el Datatable
    public function personalMilitarBaja(Request $request){
        $empleados = Empleado::where('empleados.situacion','E');
        $empleados->leftjoin('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->leftjoin('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->leftjoin('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->leftjoin('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->leftjoin('egresos','egresos.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->leftjoin('tipo_de_baja','tipo_de_baja.codigo_egreso','=','egresos.causa_egreso');
        $empleados->whereIn('nomina.tipo_emp',['MIL','MEX','TRP']);
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
            'tipo_de_baja.descripcion as motivo',
            'egresos.fecha_salida as fecha_salida',
            'egresos.nro_resuelto as nro_resuelto',
        );
        $datatable= Datatables::of($empleados);
        return $datatable->make(true);
    }

    public function bajaPersonalMilitar($id)
    {
        $user_auth=auth()->user();

        $situaciones = Config::get('constants.situacion');
        $ubicaciones = Ubicaciones::all();
        $grados_militares = GradosMilitares::all();
        $tipo_de_baja = TipoDeBaja::all();
        $datos = Empleado::with(['nomina','datos_militares'])->find($id);
        return view('sireh.personal.militar.baja',
            compact(
                'datos','grados_militares','situaciones',
                'user_auth','ubicaciones',
                'tipo_de_baja'
            )
        );
    }

    public function darBajaPersonalMilitar(Request $request)
    {
        $this->validate($request,
            [
                'causa_egreso' => 'required',
                'fecha_ingreso' => 'required',
                'fecha_salida' => 'required',
                'nro_resuelto' => 'required',
                'fecha_resuelto' => 'required',
            ],
            [
                'causa_egreso.required' => 'El tipo de egreso es requerido',
                'fecha_ingreso.required' => 'La fecha de ingreso es requerida',
                'fecha_salida.required' => 'La fecha de egreso es requerida',
                'nro_resuelto.required' => 'El numero de resolución es requerido',
                'fecha_resuelto.required' => 'La fecha de resolución es requerida'
            ]
        );
        try {
            $nomina = Nomina::where('codigo_empleado',$request->codigo_empleado)->update([
                "situacion" => 'E',
            ]);

            $empleados = Empleado::where('codigo_empleado',$request->codigo_empleado)->update([
                "situacion" => 'E',
            ]);

            $user_auth=auth()->user();

            $egresos = new Egresos;
            $egresos->codigo_empleado = $request->codigo_empleado;
            $egresos->causa_egreso = $request->causa_egreso;
            $egresos->fecha_salida = $request->fecha_salida;
            $egresos->nro_resuelto = $request->nro_resuelto;
            $egresos->fecha_resuelto = $request->fecha_resuelto;
            $egresos->fecha_registro = date('Y-m-d');
            $egresos->usuario = $user_auth->name;
            $egresos->save();

            $nomina = Nomina::where('codigo_empleado',$request->codigo_empleado)->first();

            $movimiento = new Movimientos;
            $movimiento->codigo_empleado = $request->codigo_empleado;
            $movimiento->fecha_movimiento = date('Y-m-d');
            $movimiento->tipo_movimiento = 'Egreso del Profesional';
            $movimiento->situacion = $nomina->situacion;
            $movimiento->tipo_emp_nuevo = $nomina->tipo_emp;
            $movimiento->codigo_grado = $nomina->grado_militar;
            $movimiento->codigo_ubicacion = $nomina->codigo_ubicacion;
            $movimiento->codigo_cargo = $nomina->codigo_cargo;
            $movimiento->ubicacion_detallada = $nomina->cod_ubicacion_detallada;
            $movimiento->save();

            return redirect()->route('sireh.personal-militar.bajas', [$request->id])->with('success', 'Se ha Egresado al Profesional');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }

    public function activarPersonalMilitar(Request $request)
    {
        $empleado = Empleado::where('id',$request->id)->first();
        $nomina = Nomina::where('codigo_empleado',$empleado->codigo_empleado)->first();

        $updateSituacion = Nomina::where('codigo_empleado', $empleado->codigo_empleado)->update([
            'situacion' => 'A'
        ]);
        $updateSituacion = Empleado::where('id', $request->id)->update([
            'situacion' => 'A'
        ]);

        $movimiento = new Movimientos;
        $movimiento->codigo_empleado = $empleado->codigo_empleado;
        $movimiento->fecha_movimiento = $request->fechaActivacion;
        $movimiento->tipo_movimiento = $request->motivo;
        $movimiento->situacion = 'A';
        $movimiento->observaciones = $request->observaciones;
        $movimiento->codigo_ubicacion = $nomina->codigo_ubicacion;
        $movimiento->codigo_cargo = $nomina->codigo_cargo;
        $movimiento->tipo_emp_nuevo = $nomina->tipo_emp;
        $movimiento->codigo_grado = $nomina->grado_militar;
        $movimiento->ubicacion_detallada = $nomina->cod_ubicacion_detallada;

        $movimiento->save();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'situacion' => $updateSituacion,
            ]
        );
    }

    public function escogerEscalafon() {
        $user_auth=auth()->user();

        $grados_militares = GradosMilitares::whereIn('tipo_emp',['MIL','TRP'])
        ->orderBy('codigo_grado','asc')
        ->get();

        return view('sireh.personal.militar.escalafon',
            compact(
                'grados_militares'
            )
        );
    }

    public function imprimirEscalafon(Request $request) {
        $this->validate($request,
            [
                'grado_militar' => 'required',
            ],
            [
                'grado_militar.required' => 'El Grado Militar es requerido'
            ]
        );
        $grado_militar = $request->grado_militar;
        if ($grado_militar == 'TODOS') {
            $empleados = Empleado::join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado')
            ->join('datos_militares','datos_militares.codigo_empleado','=','nomina.codigo_empleado')
            ->leftJoin('cargos','cargos.codigo_cargo','=','nomina.codigo_cargo')
            ->leftJoin('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
            ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
            ->join('categorias_militares','categorias_militares.codigo_categoria','=','datos_militares.codigo_categoria')
            ->leftjoin('especialidades_militares as em1','em1.codigo_especialidad','=','datos_militares.codigo_especialidad1')
            ->leftjoin('especialidades_militares as em2','em2.codigo_especialidad','=','datos_militares.codigo_especialidad2')
            ->where('nomina.situacion','A')
            ->whereIn('nomina.tipo_emp',['MIL','MEX','TRP'])
            ->select(
                'empleados.cedula',
                'empleados.nombre1',
                'empleados.nombre2',
                'empleados.apellido1',
                'empleados.apellido2',
                'empleados.fecha_nacim',
                'empleados.sexo',
                'categorias_militares.codigo_categoria as categoria',
                'grados_militares.codigo_grado as grado_militar',
                'datos_militares.orden_merito as orden_merito',
                'datos_militares.total_orden_merito as total_merito',
                'datos_militares.fecha_graduacion as graduacion',
                'datos_militares.fecha_ultimo_ascenso as ultimo_ascenso',
                'datos_militares.fecha_retiro as retiro',
                'em1.descripcion as especialidad1',
                'em2.descripcion as especialidad2',
                'ubicaciones.descripcion as ubicacion',
                'cargos.nombre_cargo as cargo',
            )
            //->limit(100)
            ->orderBy('nomina.grado_militar','asc')
            ->orderBy('datos_militares.fecha_ultimo_ascenso','asc')
            ->orderBy('datos_militares.fecha_graduacion','asc')
            ->orderBy('datos_militares.orden_merito','asc')
            ->get();
            //dd($empleados);
        }
        else {
            $empleados = Empleado::join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado')
            ->join('datos_militares','datos_militares.codigo_empleado','=','nomina.codigo_empleado')
            ->leftJoin('cargos','cargos.codigo_cargo','=','nomina.codigo_cargo')
            ->leftJoin('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
            ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
            ->join('categorias_militares','categorias_militares.codigo_categoria','=','datos_militares.codigo_categoria')
            ->leftjoin('especialidades_militares as em1','em1.codigo_especialidad','=','datos_militares.codigo_especialidad1')
            ->leftjoin('especialidades_militares as em2','em2.codigo_especialidad','=','datos_militares.codigo_especialidad2')
            ->where('empleados.situacion','A')
            ->where('nomina.grado_militar',$grado_militar)
            ->whereIn('nomina.tipo_emp',['MIL','MEX','TRP'])
            ->select(
                'empleados.cedula',
                'empleados.nombre1',
                'empleados.nombre2',
                'empleados.apellido1',
                'empleados.apellido2',
                'empleados.fecha_nacim',
                'empleados.sexo',
                'categorias_militares.descripcion as categoria',
                'grados_militares.descripcion as grado_militar',
                'datos_militares.orden_merito as orden_merito',
                'datos_militares.total_orden_merito as total_merito',
                'datos_militares.fecha_graduacion as graduacion',
                'datos_militares.fecha_ultimo_ascenso as ultimo_ascenso',
                'datos_militares.fecha_retiro as retiro',
                'em1.descripcion as especialidad1',
                'em2.descripcion as especialidad2',
                'ubicaciones.descripcion as ubicacion',
                'cargos.nombre_cargo as cargo',
            )
            ->limit(50)
            ->orderBy('datos_militares.fecha_ultimo_ascenso','asc')
            ->orderBy('datos_militares.fecha_graduacion','asc')
            ->orderBy('datos_militares.orden_merito','asc')
            ->get();
        }

        foreach ($empleados as $row) {
            $escalafon = new Escalafon;
            $escalafon->cedula = $row->cedula;
            $escalafon->nombre1 = $row->nombre1;
            $escalafon->nombre2 = $row->nombre2;
            $escalafon->apellido1 = $row->apellido1;
            $escalafon->apellido2 = $row->apellido2;
            $escalafon->fecha_nacim = $row->fecha_nacim;
            $escalafon->sexo = $row->sexo;
            $escalafon->categoria = $row->categoria;
            $escalafon->grado_militar = $row->grado_militar;
            $escalafon->orden_merito = $row->orden_merito;
            $escalafon->total_merito = $row->total_merito;
            $escalafon->graduacion = $row->graduacion;
            $escalafon->ultimo_ascenso = $row->ultimo_ascenso;
            $escalafon->retiro = $row->retiro;
            $escalafon->especialidad1 = $row->especialidad1;
            $escalafon->especialidad2 = $row->especialidad2;
            $escalafon->ubicacion = $row->ubicacion;
            $escalafon->cargo = $row->cargo;
            $escalafon->save();
        }

        $grados_mil = GradosMilitares::all();
        $categorias_mil = CategoriasMilitares::all();

        $escalafon = Escalafon::all();
        Escalafon::truncate();

        $agrupados = $escalafon->groupBy(['grado_militar', 'categoria']);

        $pdf = \PDF::loadview('sireh.personal.militar.imprimirescalafon', compact('agrupados','escalafon'))->setPaper('a4', 'landscape');

        return $pdf->stream('escalafon.pdf');
        //return view('sireh.personal.militar.imprimirescalafon', compact('grados_mil','categorias_mil','escalafon'));
    }

    //PERSONAL CIVIL FUNCTIONS
    public function viewPersonalCivilnoactivo($codigo_empleado)
    {
        $user_auth=auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $nacionalidades = Config::get('constants.nacionalidad');
        $generos = Config::get('constants.sexo');
        $edos_civil = Config::get('constants.edo_civil');
        $estados = Estados::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $niveles = Nivel::all();
        $cargos = Cargos::all();
        $cursos = Cursos::all();
        $universidades = Universidades::all();
        $profesiones = Profesion::all();
        $ciudades = Ciudades::all();
        $datos = Nomina::join('empleados','nomina.codigo_empleado','=','empleados.codigo_empleado')
        ->join('estudios_realizados','estudios_realizados.codigo_empleado','=','empleados.codigo_empleado')
      ->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp')
      ->join('movimientos','movimientos.codigo_empleado','=','nomina.codigo_empleado')
        ->where('nomina.codigo_empleado',$codigo_empleado)
        ->select('nomina.*','estudios_realizados.*','empleados.*')
        ->first();
        $getEmpleadoCode = Empleado::With('nomina')->select('codigo_empleado')->find($codigo_empleado);
        $cursosRealizados = CursosRealizados::where('codigo_empleado',$getEmpleadoCode['codigo_empleado'])->get();
        return view('sireh.personal.civil.viewNO',
            compact(
                'datos','ciudades',
                'user_auth', 'tipos_emp', 'generos', 'edos_civil',
                'estados', 'ubicaciones', 'ubicaciones_det', 'niveles',
                'cargos', 'nacionalidades', 'universidades', 'profesiones',
                'cursosRealizados', 'cursos'
            )
        );
    }
    public function viewPersonalCivil($id)
    {
        $user_auth=auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $nacionalidades = Config::get('constants.nacionalidad');
        $generos = Config::get('constants.sexo');
        $edos_civil = Config::get('constants.edo_civil');
        $estados = Estados::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $niveles = Nivel::all();
        $cargos = Cargos::all();
        $cursos = Cursos::all();
        $universidades = Universidades::all();
        $profesiones = Profesion::all();
        $ciudades = Ciudades::all();
        $grados_militares = GradosMilitares::all();
        $datos = Empleado::with(['nomina','estudios_realizados'])->find($id);
        $getEmpleadoCode = Empleado::With('nomina')->select('codigo_empleado')->find($id);
        $cursosRealizados = CursosRealizados::where('codigo_empleado',$getEmpleadoCode['codigo_empleado'])->get();
        return view('sireh.personal.civil.view',
            compact(
                'datos','ciudades','grados_militares',
                'user_auth', 'tipos_emp', 'generos', 'edos_civil',
                'estados', 'ubicaciones', 'ubicaciones_det', 'niveles',
                'cargos', 'nacionalidades', 'universidades', 'profesiones',
                'cursosRealizados', 'cursos'
            )
        );
    }

    public function suspenderPersonalCivil(Request $request)
    {
        $updateSituacion = Nomina::where('codigo_empleado', $request->codigo_empleado)->update([
            'situacion' => 'S'
        ]);
        $updateSituacion = Empleado::where('codigo_empleado', $request->codigo_empleado)->update([
            'situacion' => 'S'
        ]);

        $movimiento = new Movimientos;

        $movimiento->fecha_movimiento = $request->fecha;
        $movimiento->tipo_movimiento = $request->motivo;
        $movimiento->situacion = 'S';
        $movimiento->observaciones = $request->observaciones;
        $movimiento->codigo_empleado = $request->codigo_empleado;

        $movimiento->save();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'situacion' => $updateSituacion,
            ]
        );
    }

    public function egresoPersonalCivil(Request $request)
    {
        $updateSituacion = Nomina::where('codigo_empleado', $request->codigo_empleado)->update([
            'situacion' => 'E'
        ]);
        $updateSituacion = Empleado::where('codigo_empleado', $request->codigo_empleado)->update([
            'situacion' => 'E'
        ]);

        $movimiento = new Movimientos;

        $movimiento->fecha_movimiento = $request->fecha_egreso;
        $movimiento->tipo_movimiento = $request->egreso;
        $movimiento->situacion = 'E';
        $movimiento->observaciones = $request->observaciones;
        $movimiento->codigo_empleado = $request->codigo_empleado;

        $movimiento->save();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'situacion' => $updateSituacion,
            ]
        );
    }

    public function activarPersonalCivil(Request $request)
    {
        $updateSituacion = Nomina::where('codigo_empleado', $request->codigo_empleado)->update([
            'situacion' => 'A'
        ]);
        $updateSituacion = Empleado::where('codigo_empleado', $request->codigo_empleado)->update([
            'situacion' => 'A'
        ]);

        $movimiento = new Movimientos;
        $movimiento->tipo_movimiento = "ACTIVACION DE EMPLEADO";
        $movimiento->situacion = 'A';
        $movimiento->codigo_empleado = $request->codigo_empleado;

        $movimiento->save();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'situacion' => $request->codigo_empleado,
            ]
        );
    }

    public function editPersonalCivil($id)
    {
        $user_auth=auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $nacionalidades = Config::get('constants.nacionalidad');
        $generos = Config::get('constants.sexo');
        $edos_civil = Config::get('constants.edo_civil');
        $estados = Estados::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $niveles = Nivel::all();
        $cargos = Cargos::all();
        $universidades = Universidades::all();
        $profesiones = Profesion::all();
        $ciudades = Ciudades::all();
        $grados_militares = GradosMilitares::all();
        $datos = Empleado::with(['nomina','estudios_realizados'])->find($id);
        return view('sireh.personal.civil.edit',
            compact(
                'datos','ciudades','grados_militares',
                'user_auth', 'tipos_emp', 'generos', 'edos_civil',
                'estados', 'ubicaciones', 'ubicaciones_det', 'niveles',
                'cargos', 'nacionalidades', 'universidades', 'profesiones'
            )
        );
    }
    public function updatePersonalCivil(Request $request)
    {
        $user_auth=auth()->user();

        $updateNomina = Nomina::where('codigo_empleado', $request->codigo_empleado)->update([
            "tipo_emp" => $request->tipo_emp,
            "cedula" => $request->cedula,
            "nombre1" => $request->nombre1,
            "nombre2" => $request->nombre2,
            "apellido1" => $request->apellido1,
            "apellido2" => $request->apellido2,
            "codigo_ubicacion" => $request->codigo_ubicacion,
            "cod_ubicacion_detallada" => $request->cod_ubicacion_detallada,
            "tipo_emp" => $request->tipo_emp,
        ]);
        $updateEmpleado = Empleado::where('codigo_empleado', $request->codigo_empleado)->update([
            "nacionalidad" => $request->nacionalidad,
            "fecha_nacim" => $request->fecha_nacim,
            "sexo" => $request->genero,
            "telefono_e" => $request->telefono_e,
            "edo_civil" => $request->edo_civil,
            "telefono_cel" => $request->telefono_cel,
            "telefono" => $request->telefono,
            "telefono_ofi" => $request->telefono_ofi,
            "correo" => $request->correo,
            "estado" => $request->estado,
            "ciudad" => $request->ciudad,
            "direccion" => $request->direccion,
            "peso" => $request->peso,
            "estatura" => $request->estatura,
            "zur_der_amb" => $request->zur_der_amb,
            "grupo_sanguineo" => $request->grupo_sanguineo,
            "talla_pant" => $request->talla_pant,
            "talla_camisa" => $request->talla_camisa,
            "talla_chaqueta" => $request->talla_chaqueta,
            "numero_calzado" => $request->numero_calzado,
            "ojos" => $request->ojos,
            "cabellos" => $request->cabellos,
            "color" => $request->color,
            //"universidad" => $request->universidad,
            "profesion" => $request->profesion,
            // "fecha_graduacion" => $request->fecha_graduacion,
            "persona_contacto" => $request->persona_contacto,
            "cedula" => $request->cedula,
            "nombre1" => $request->nombre1,
            "nombre2" => $request->nombre2,
            "apellido1" => $request->apellido1,
            "apellido2" => $request->apellido2,
        ]);

        return redirect()->route('sireh.personal-civil.index')->with('success', 'Se ha actualizado el Personal');

    }
    public function personalCivilNoActive(){
        $noActive = Nomina::where('nomina.situacion','=','E')
            ->join('empleados','nomina.codigo_empleado','=','empleados.codigo_empleado')
            ->leftjoin('movimientos','movimientos.codigo_empleado','=','nomina.codigo_empleado')
            ->leftjoin('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp')
            ->leftjoin('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
            ->leftjoin('cargos','cargos.codigo_cargo','=','nomina.codigo_cargo')
            ->whereIn('nomina.tipo_emp',['EMP','CON','OBR','DOC','MED','DTC','CEX'])
          //  ->where('movimientos.situacion','=','E')
            ->whereIn('movimientos.tipo_movimiento',['PRIVADO DE LIBERTAD','RENUNCIA','DESPIDO','EGRE'])
        
            ->get();
            //dd($noActive);
        return view('sireh.personal.civil.view_civil_no_activo',
            compact(
                'noActive'
            )
        );
    }

    public function AgregarCursoPersonalCivil(Request $request)
    {
        $cursos = new CursosRealizados;

        $cursos->codigo_curso = $request->curso;
        $cursos->desde = $request->desde_curso;
        $cursos->hasta = $request->hasta_curso;
        $cursos->codigo_empleado = $request->codigo_empleado;

        $cursos->save();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'situacion' => $cursos,
            ]
        );
    }

    public function evaluarPersonalCivil($id)
    {
        $user_auth=auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $cargos = Cargos::all();
        $grados_militares = GradosMilitares::all();
        $datos = Empleado::with(['nomina','estudios_realizados'])->find($id);
        $evaluaciones = IntelectualesCivil::where('codigo_empleado', $datos->codigo_empleado)->get();
        return view('sireh.personal.civil.view_evaluar',
            compact(
                'datos','grados_militares',
                'user_auth', 'tipos_emp', 'ubicaciones', 'ubicaciones_det',
                'cargos', 'evaluaciones'
            )
        );
    }

    public function storeEvaluarPersonalCivil(Request $request)
    {
        $evaluacion_civil = new IntelectualesCivil;

        $evaluacion_civil->codigo_empleado = $request->codigo_empleado;
        $evaluacion_civil->fecha_evaluacion = $request->fecha_evaluacion;
        $evaluacion_civil->cedula_evaluador = $request->cedula_evaluador;
        $evaluacion_civil->nombre_evaluador = $request->nombre_evaluador;
        $evaluacion_civil->nota = $request->nota;
        $evaluacion_civil->rango_actuacion = $request->rango_actuacion;
        $evaluacion_civil->obervaciones = $request->obervaciones;

        $evaluacion_civil->save();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'situacion' => $evaluacion_civil,
            ]
        );
    }
    public function EditEvaluarPersonalCivil(Request $request)
    {
        $edit = IntelectualesCivil::where('id', $request->id)->get();
        return response()->json([
                'success' => true,
                'message' => 'Data',
                'data' => $edit,
            ]
        );
    }
    public function updateEvaluarPersonalCivil(Request $request)
    {
        $updateIntec = IntelectualesCivil::where('id', $request->id)->update($request->except('id'));

        return response()->json([
                'success' => true,
                'message' => 'Data',
                'updateIntec' => $updateIntec
            ]
        );
    }


    public function editPersonalMilitarNoProf($id)
    {
        $user_auth=auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $nacionalidades = Config::get('constants.nacionalidad');
        $generos = Config::get('constants.sexo');
        $edos_civil = Config::get('constants.edo_civil');
        $estados = Estados::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $niveles = Nivel::all();
        $cargos = Cargos::all();
        $universidades = Universidades::all();
        $profesiones = Profesion::all();
        $ciudades = Ciudades::all();
        $datos = Empleado::with(['nomina','nomina.cargo','estudios_realizados','nomina.datos_militares'])->find($id);
        $grados_militares = GradosMilitares::where('tipo_emp',$datos->nomina->tipo_emp)->get();
        return view('sireh.personal.militar_noprof.edit',
            compact(
                'datos','ciudades','grados_militares',
                'user_auth', 'tipos_emp', 'generos', 'edos_civil',
                'estados', 'ubicaciones', 'ubicaciones_det', 'niveles',
                'cargos', 'nacionalidades', 'universidades', 'profesiones'
            )
        );
    }

    public function updatePersonalMilitarNoProf(Empleado $empleado,Request $request){

        $this->validate($request,
            [
                'cedula' => 'required',
                'nombre1' => 'required',
                'apellido1' => 'required',
                'ubicacion' => 'required',
            ],
            [
                'nombre1.required' => 'El primer nombre es requerido',
                'apellido1.required' => 'El primer apellido es requerido'
            ]
        );
        try {
            if ($request->file("foto")){
                $ext = $request->file('foto')->getClientOriginalExtension();
                $file_name = 'empleado_'.$empleado->codigo_empleado . '.' . $ext;

                $path_foto = 'fotos/empleados/' . $file_name;
                if(file_exists($path_foto)){
                    unlink($path_foto); // Eliminamos la imagen previa si existe.
                }
                //$path = $request->file("foto")->store($path);
                Image::make($request->file('foto'))->save( public_path($path_foto));
            }else{
                $path_foto = null;
            }

            $empleado->cedula = $request->cedula;
            $empleado->nacionalidad = $request->nacionalidad;
            $empleado->nombre1 = $request->nombre1;
            $empleado->nombre2 = $request->nombre2;
            $empleado->apellido1 = $request->apellido1;
            $empleado->apellido2 = $request->apellido2;
            $empleado->fecha_nacim = $request->fecha_nacim;
            $empleado->sexo = $request->genero;
            $empleado->edo_civil = $request->edo_civil;

            $empleado->nivel_instruccion = $request->nivel;
            $empleado->telefono = $request->telefono;
            $empleado->telefono_cel = $request->telefono_cel;
            $empleado->telefono_ofi = $request->telefono_ofi;
            $empleado->direccion = $request->direccion;
            $empleado->profesion = !empty($request->profesion) ? $request->profesion : null;
            $empleado->ciudad = !empty($request->ciudad) ? $request->ciudad : null;
            $empleado->estado = !empty($request->estado) ? $request->estado : null;
            $empleado->persona_contacto = !empty($request->persona_contacto) ? $request->persona_contacto : null;
            $empleado->telefono_e = !empty($request->telefono_e) ? $request->telefono_e : null;
            $empleado->estado = !empty($request->estado) ? $request->estado : null;
            if ($path_foto) {
                $empleado->foto = $path_foto ;
            }
            $empleado->correo = $request->correo;
            $empleado->save();

            $nomina = Nomina::where('codigo_empleado',$empleado->codigo_empleado)->first();
            $nomina->cedula = $empleado->cedula;
            $nomina->codigo_ubicacion = $request->ubicacion;
            $nomina->fecha_ingreso = $request->fecha_ingreso;
            $nomina->codigo_cargo = !empty($request->cargo) ? $request->cargo : 0;
            $nomina->grado_militar = !empty($request->grado_militar) ? $request->grado_militar : null;
            $nomina->cod_rac = !empty($request->cod_rac) ? $request->cod_rac : null;
            $nomina->cod_ubicacion_detallada = !empty($request->ubicacion_det) ? $request->ubicacion_det : null;
            $nomina->save();

            if($request->contingente){
                $datos_militares = DatosMilitares::where('codigo_empleado',$empleado->codigo_empleado)->first();
                $datos_militares->contingente = $request->contingente;
                $datos_militares->save();
            }
            if( !empty($request->universidad) || !empty($request->profesion)){
                EstudiosRealizados::updateOrCreate(
                    ['codigo_empleado' => $empleado->codigo_empleado],
                    [
                        'nivel' => $request->nivel,
                        'profesion' => $request->profesion,
                        'universidad' => $request->universidad,
                    ]
                );
            }
            return redirect()->route('sireh.personal-militar-noprof.index')->with('success', 'Se ha actualizado los Datos de Ingreso de Personal');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }

    public function egresarMilitarNoProf(Request $request){

        $this->validate($request,
            [
                'fecha_egreso' => 'required',

                'observaciones' => 'required',
            ],
            [
                'fecha_egreso.required' => 'Fecha de Egreso es requerida',
                'observaciones.required' => 'Motivo de Egreso es requerido'
            ]
        );
        try {
            $empleado = Empleado::find($request->id_empleado);
            $nomina = Nomina::where('codigo_empleado',$empleado->codigo_empleado)->first();
            $empleado->situacion='E';
            $nomina->situacion='E';
            $nomina->fecha_egreso=$request->fecha_egreso;
            $nomina->observaciones=$request->observaciones;
            $empleado->update();
            $nomina->update();
            return response()->json(['success' => true,'msg'=>'Egreso Realizado con exito']);
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }

    //MOSTRAR DATA PARA AGREGAR FUNCION PERSONAL MILITAR
    public function showDataPersonalMilitar(Request $request)
    {
        $data = Nomina::where('codigo_empleado', $request->id)->get();
        $funcionEmpleado = FuncionTripulante::get();
        $haveFuncion = EmpleadoFuncion::where('codigo_empleado', $request->id)
            ->join('funcion_tripulante','funcion_tripulante.id','=','empleado_funcion.id_funcion')
            ->select(
                'empleado_funcion.id',
                'empleado_funcion.id_funcion',
                'funcion_tripulante.funcion',
            )
            ->get();
        $idsFuncion = $haveFuncion->pluck('id_funcion')->toArray();
        //dd($idsFuncion);
        return response()->json([
                'success' => true,
                'message' => 'Data',
                'data' => $data,
                'haveFuncion' => $haveFuncion,
                'funcionTripulante' => $funcionEmpleado,
                'idsFuncion' => $idsFuncion
            ]
        );
    }
    public function storeFuncionPersonalMilitar(Request $request)
    {

        $empleado= Empleado::where('codigo_empleado', $request->codigo_empleado)->first();

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
    public function deteleFuncionPersonalMilitar(Request $request)
    {
        EmpleadoFuncion::find($request->id)->delete();

        return response()->json([
                'success' => true,
                'message' => 'Data Eliminada'
            ]
        );
    }

    public function reportesPersonalMilitarView()
    {
        $grados_militares = GradosMilitares::whereIn('tipo_emp',['MIL','TRP'])->orderBy('codigo_grado','asc')->get();
        $categorias_militares = CategoriasMilitares::whereIn('tipo_emp',['MIL','TRP']) ->get();
        $ubicaciones = Ubicaciones::all();

        return view('sireh.personal.militar.reportes', compact(
            'grados_militares',
            'categorias_militares','ubicaciones'
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportesPersonalMilitar(Request $request)
    {

        $this->validate($request,
            [
                'reporte' => 'required',
                'parametros' => 'required|array|min:1',








                'parametros.*' => 'required|string|distinct',

                'parametros1' => 'array|min:1',
                'parametros1.*' => 'string|distinct',
            ],
            [
                'parametros.*.required' => 'El Parametro es requerido',
                'parametros1.*.required' => 'El Parametro es requerido',
            ]

        );

        $reporte=$request->reporte;
        $nameParametro =array_key_first($request->parametros);
        $valueParametro = $request->parametros[$nameParametro];

        if($request->parametros1!="") {
            $nameParametro1 =array_key_first($request->parametros1);
            $valueParametro1 = $request->parametros1[$nameParametro1];
        }

        $complementoTitulo='';
        switch ($reporte) {
            case 1:
                $complementoTitulo= "DE BAJA POR CATEGORIA Y GRADO";
                if($valueParametro1 !="00022"){
                    $empleados = Empleado::join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado')
                    ->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp')
                    ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
                    ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
                    ->join('datos_militares','datos_militares.codigo_empleado','=','nomina.codigo_empleado')
                    ->join('categorias_militares','categorias_militares.codigo_categoria','=','datos_militares.codigo_categoria')
                    ->whereIn('nomina.tipo_emp',['MIL','MEX','TRP'])
                    ->where('datos_militares.codigo_categoria', $valueParametro)
                    ->where('nomina.grado_militar', $valueParametro1)
                    ->select(
                    'empleados.id',
                    'empleados.codigo_empleado',
                    'empleados.cedula',
                    'empleados.nombre1',
                    'empleados.nombre2',
                    'empleados.apellido1',
                    'empleados.apellido2',
                    DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                    'grados_militares.siglas as siglas',
                    'grados_militares.descripcion as grado_militar',
                    'ubicaciones.descripcion as ubicacion',
                    'datos_militares.fecha_graduacion',
                    DB::raw("CASE nomina.situacion
                            WHEN 'A' THEN 'ACTIVO'
                            WHEN 'E' THEN 'EGRESADO'
                            WHEN 'S' THEN 'SUSPENDIDO'
                            ELSE ''
                            END as situacion"),
                    'datos_militares.codigo_categoria',
                    'categorias_militares.descripcion as categoria_militar',

                );
                }else{
                    $empleados = Empleado::join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado')
                    ->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp')
                    ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
                    ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
                    ->join('datos_militares','datos_militares.codigo_empleado','=','nomina.codigo_empleado')
                    ->join('categorias_militares','categorias_militares.codigo_categoria','=','datos_militares.codigo_categoria')
                    ->whereIn('nomina.tipo_emp',['MIL','MEX','TRP'])
                    ->where('datos_militares.codigo_categoria', $valueParametro)
                    ->select(
                    'empleados.id',
                    'empleados.codigo_empleado',
                    'empleados.cedula',
                    'empleados.nombre1',
                    'empleados.nombre2',
                    'empleados.apellido1',
                    'empleados.apellido2',
                    DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                    'grados_militares.siglas as siglas',
                    'grados_militares.descripcion as grado_militar',
                    'ubicaciones.descripcion as ubicacion',
                    'datos_militares.fecha_graduacion',
                    DB::raw("CASE nomina.situacion
                            WHEN 'A' THEN 'ACTIVO'
                            WHEN 'E' THEN 'EGRESADO'
                            WHEN 'S' THEN 'SUSPENDIDO'
                            ELSE ''
                            END as situacion"),
                    'datos_militares.codigo_categoria',
                    'categorias_militares.descripcion as categoria_militar',

                );
                }
               
                //dd($valueParametro1);
                $datos = $empleados->get();

                break;
            case 2:
                //dd($valueParametro);
                $complementoTitulo= " POR SITUACION";
                if($valueParametro1 !="00022") {
                   

                   // dd($valueParametro);
                $empleados = Empleado::join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado')
                    ->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp')
                    ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
                    ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
                    ->join('datos_militares','datos_militares.codigo_empleado','=','nomina.codigo_empleado')
                    ->leftjoin('movimientos','movimientos.codigo_empleado','=','nomina.codigo_empleado')
                    ->join('categorias_militares','categorias_militares.codigo_categoria','=','datos_militares.codigo_categoria')
                    ->whereIn('nomina.tipo_emp',['MIL','MEX','TRP'])
                    ->where('nomina.situacion', $valueParametro)
                    ->where('movimientos.situacion', $valueParametro)
                    ->where('nomina.codigo_ubicacion', $valueParametro1)
                    ->select(
                    'empleados.id',
                    'empleados.codigo_empleado',
                    'empleados.cedula',
                    'empleados.nombre1',
                    'empleados.nombre2',
                    'empleados.apellido1',
                    'empleados.apellido2',
                   'movimientos.tipo_movimiento',
                   'movimientos.observaciones',
                    DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                    'grados_militares.siglas as siglas',
                    'grados_militares.descripcion as grado_militar',
                    'ubicaciones.descripcion as ubicacion',
                    'datos_militares.fecha_graduacion',
                    DB::raw("CASE nomina.situacion
                            WHEN 'A' THEN 'ACTIVO'
                            WHEN 'E' THEN 'EGRESADO'
                            WHEN 'S' THEN 'SUSPENDIDO'
                            ELSE ''
                            END as situacion"),
                    'datos_militares.codigo_categoria',
                    'categorias_militares.descripcion as categoria_militar',

                );
                }else{
                    $empleados = Empleado::join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado')
                        ->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp')
                        ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
                        ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
                        ->join('datos_militares','datos_militares.codigo_empleado','=','nomina.codigo_empleado')
                        ->leftjoin('movimientos','movimientos.codigo_empleado','=','nomina.codigo_empleado')
                        ->join('categorias_militares','categorias_militares.codigo_categoria','=','datos_militares.codigo_categoria')
                        ->whereIn('nomina.tipo_emp',['MIL','MEX','TRP'])
                        ->where('nomina.situacion', $valueParametro)
                        ->where('movimientos.situacion', $valueParametro)
                        ->select(
                        'empleados.id',
                        'empleados.codigo_empleado',
                        'empleados.cedula',
                        'empleados.nombre1',
                        'empleados.nombre2',
                        'empleados.apellido1',
                        'empleados.apellido2',
                        'movimientos.tipo_movimiento',
                        'movimientos.observaciones',
                        DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                        'grados_militares.siglas as siglas',
                        'grados_militares.descripcion as grado_militar',
                        'ubicaciones.descripcion as ubicacion',
                        'datos_militares.fecha_graduacion',
                        DB::raw("CASE nomina.situacion
                                WHEN 'A' THEN 'ACTIVO'
                                WHEN 'E' THEN 'EGRESADO'
                                WHEN 'S' THEN 'SUSPENDIDO'
                                ELSE ''
                                END as situacion"),
                        'datos_militares.codigo_categoria',
                        'categorias_militares.descripcion as categoria_militar',
    
                    );
                   
                }
                $datos = $empleados->get();
                break;
                case 3:
                    $complementoTitulo= " POR AÑO DE GRADUACION";
                    $empleados = Empleado::join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado')
                        ->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp')
                        ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
                        ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
                        ->join('datos_militares','datos_militares.codigo_empleado','=','nomina.codigo_empleado')
                        //->join('movimientos','movimientos.codigo_empleado','=','nomina.codigo_empleado')
                        ->join('categorias_militares','categorias_militares.codigo_categoria','=','datos_militares.codigo_categoria')
                        ->whereIn('nomina.tipo_emp',['MIL','MEX','TRP'])
                        ->where('datos_militares.codigo_categoria', $valueParametro)
                        ->where('datos_militares.fecha_graduacion', $valueParametro1)
                        ->select(
                        'empleados.id',
                        'empleados.codigo_empleado',
                        'empleados.cedula',
                        'empleados.nombre1',
                        'empleados.nombre2',
                        'empleados.apellido1',
                        'empleados.apellido2',
                       // 'movimientos.tipo_movimiento',
                        //'movimientos.observaciones',
                        DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                        'grados_militares.siglas as siglas',
                        'grados_militares.descripcion as grado_militar',
                        'ubicaciones.descripcion as ubicacion',
                        'datos_militares.fecha_graduacion',
                        DB::raw("CASE nomina.situacion
                                WHEN 'A' THEN 'ACTIVO'
                                WHEN 'E' THEN 'EGRESADO'
                                WHEN 'S' THEN 'SUSPENDIDO'
                                ELSE ''
                                END as situacion"),
                        'datos_militares.codigo_categoria',
                        'categorias_militares.descripcion as categoria_militar',
    
                    );
                    $datos = $empleados->get();
                    break;
        }

        $titulo = 'REPORTE DE PERSONAL MILITAR '. $complementoTitulo;

        $nombre_archivo = sprintf('ReportePersonalMilitar %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
        $data = compact('titulo', 'datos');

        return Excel::download(new PersonalMilitarExport($data), $nombre_archivo);

    }

    public function reportesPersonalMilitarNoProfView()
    {
        $grados_militares = GradosMilitares::whereIn('tipo_emp',['ALI'])->orderBy('codigo_grado','asc')->orderBy('codigo_grado','asc')->get();
        $ubicaciones = Ubicaciones::all();
        return view('sireh.personal.militar_noprof.reportes', compact(
            'grados_militares',
            'ubicaciones',
        ));
    }


     /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportePersonalMilitarNoProfJerarquiaUbicacion(Request $request)
    {

        $this->validate($request,
            [
                'reporte' => 'required',
                'tipo_emp' => 'required',
                'grado_militar' => 'required',
                'ubicacion' => 'required',
            ],
            [
                'tipo_emp' => 'El Parametro Tipo Empleado es Requerido',
            ]

        );

        $reporte=$request->reporte;
        $codigo_ubicacion = $request->ubicacion;
        $grado_militar=$request->grado_militar;
        $ubicacion_descripcion = '';

        switch ($reporte) {
            case 1:
                $complementoTitulo= "POR JERARQUIA Y UBICACIÓN";
                $empleados = Empleado::join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado')
                    ->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp')
                    ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
                    ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
                    ->join('datos_militares','datos_militares.codigo_empleado','=','nomina.codigo_empleado')
                    ->join('categorias_militares','categorias_militares.codigo_categoria','=','datos_militares.codigo_categoria')
                    ->whereIn('nomina.tipo_emp',['ALI','MEF']);
                if($grado_militar!=='0'){
                    $empleados->where('nomina.grado_militar', $grado_militar);
                }
                if($codigo_ubicacion!=='0'){
                    $empleados->where('nomina.codigo_ubicacion', $codigo_ubicacion);
                    $ubicacion_descripcion = Ubicaciones::where('codigo_ubicacion',$codigo_ubicacion)->first()->value('descripcion');

                }
                $empleados->select(
                    'empleados.id',
                    'empleados.codigo_empleado',
                    'empleados.cedula',
                    'empleados.nombre1',
                    'empleados.nombre2',
                    'empleados.apellido1',
                    'empleados.apellido2',
                    'grados_militares.siglas as siglas',
                    'grados_militares.descripcion as grado_militar',
                    'ubicaciones.codigo_ubicacion',
                    'ubicaciones.descripcion as ubicacion',
                );
                //dd($complementoTitulo);
                $datos = $empleados->get();

            break;
        }
        if(count($datos)>0){
            \Session::flash('success','Reporte Ejecutado con exito !');
            $titulo = 'LISTADO POR UBICACION DE MILITARES EN FORMACION Y/O LA TROPA ALISTADA';

            $nombre_archivo = sprintf('ReportePersonalMilitarNoProf %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
            $data = compact('titulo', 'datos','codigo_ubicacion','ubicacion_descripcion');
            return Excel::download(new PersonalMilitarEnFormacionExport($data), $nombre_archivo);
        }else {
            return redirect()->back()->with('error', 'No hay Datos para generar el informe');
        }

    }

    public function reportePersonalMilitarubi(Request $request)
    {

        $this->validate($request,
            [

                'ubicacion' => 'required',
            ],
            [
                'ubicacion' => 'El Parametro Tipo Empleado es Requerido',
            ]

        );
 $ubicaciones = $request->ubicacion;
  $titulo = ' LISTA DE PERSONAL POR UNIDAD ';
        $datos = Nomina::leftjoin('empleados','empleados.codigo_empleado','=','nomina.codigo_empleado')
        ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
        ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
        ->whereIn('nomina.situacion',['A','S'])
        ->whereIn('nomina.tipo_emp',['MIL','TRP'])
        ->where('nomina.codigo_ubicacion','=',$ubicaciones)
        ->select('empleados.cedula as cedula','empleados.nombre1 as nombre1','empleados.nombre2 as nombre2',
         'empleados.apellido1 as apellido1', 'empleados.apellido2 as apellidos2',
        'grados_militares.siglas as siglas','ubicaciones.descripcion as ubicacion')
        ->orderByRaw("CASE WHEN nomina.grado_militar = '010' THEN 1
        WHEN nomina.grado_militar = '015' THEN 2
        WHEN nomina.grado_militar = '020' THEN 3
        WHEN nomina.grado_militar = '030' THEN 4
        WHEN nomina.grado_militar = '040' THEN 5
        WHEN nomina.grado_militar = '050' THEN 6
        WHEN nomina.grado_militar = '060' THEN 7
        WHEN nomina.grado_militar = '070' THEN 8
        WHEN nomina.grado_militar = '080' THEN 9
        WHEN nomina.grado_militar = '090' THEN 10
        WHEN nomina.grado_militar = '410' THEN 11
        WHEN nomina.grado_militar = '420' THEN 12
        WHEN nomina.grado_militar = '430' THEN 13
        WHEN nomina.grado_militar = '440' THEN 14
        WHEN nomina.grado_militar = '450' THEN 15
        WHEN nomina.grado_militar = '460' THEN 16
        WHEN nomina.grado_militar = '470' THEN 17 END, nomina.grado_militar")
        ->get();


        $nombre_archivo = sprintf('lista de personal %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
          $data1 = compact('titulo', 'datos');
            return Excel::download(new PerosnalubicacionesExport($data1), $nombre_archivo);
             //return view('excel.personal_militar_ubicaciones', $data = compact('titulo', 'datos'));



}

    public function ficha(Request $request)
    {


        $this->validate($request,
        [

            'cedula' => 'required',
        ],
        [
            'cedula' => 'El Parametro Tipo Empleado es Requerido',
        ]

    );
$cedula = $request->cedula;
 $user_auth=auth()->user();

        $codigo_empleado1 = Nomina::select('codigo_empleado')
        ->where('cedula',$cedula)
        ->first();

        $codigo_empleado = $codigo_empleado1->codigo_empleado;
      $niveles = Nivel::all();
      $datos = Nomina::join('empleados','empleados.codigo_empleado','=','nomina.codigo_empleado')
      ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
      ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
      ->join('intelectuales','intelectuales.cedula','=','empleados.cedula')
      ->join('paf','paf.cedula','=','nomina.cedula')
      ->join('estudios_realizados','estudios_realizados.codigo_empleado','=','nomina.codigo_empleado')
      ->join('datos_militares','datos_militares.codigo_empleado','=','nomina.codigo_empleado')
      ->leftjoin('promociones_militares','promociones_militares.codigo_promocion','=','datos_militares.codigo_promocion')
      ->leftjoin('especialidades_militares','especialidades_militares.codigo_especialidad','=','datos_militares.codigo_especialidad1')
      ->join('cargos','cargos.codigo_cargo','=','nomina.codigo_cargo')
      ->join('categorias_militares','categorias_militares.codigo_categoria','=','datos_militares.codigo_categoria')
      ->select('nomina.codigo_ubicacion','empleados.foto as foto','empleados.cedula as cedula','empleados.nombre1 as nombre1','empleados.nombre2 as nombre2','empleados.apellido1 as apellido1', 'empleados.apellido2 as apellido2','grados_militares.siglas as siglas',
      'ubicaciones.descripcion as ubicacion','estudios_realizados.nivel as nivel','promociones_militares.ano_promocion as promocion','empleados.telefono_cel as telefono','intelectuales.notatotal','categorias_militares.descripcion as categoria',
      'especialidades_militares.descripcion as especialidad','cargos.nombre_cargo as cargo','datos_militares.fecha_graduacion','paf.total')
        ->where('nomina.codigo_empleado',$codigo_empleado)->first();

 $ubicacion=$datos->codigo_ubicacion;


        $cmdt = Nomina::join('empleados','empleados.codigo_empleado','=','nomina.codigo_empleado')
        ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
        ->where('nomina.codigo_ubicacion','=',$ubicacion)
        ->whereIn('nomina.codigo_cargo',['222341','1000014','1000015'])
        ->select('empleados.cedula as cedula','empleados.nombre1 as nombre1','empleados.nombre2 as nombre2','empleados.apellido1 as apellido1','empleados.telefono_cel')
        ->first();

        $año_engrd=$datos->fecha_graduacion;
        $años = Carbon::parse($año_engrd)->age;

        $tte = Nomina::join('historico_ascensos', 'historico_ascensos.codigo_empleado', '=', 'nomina.codigo_empleado')
        ->select('historico_ascensos.orden_merito_ascenso','historico_ascensos.fecha_ascenso as añoascensotte')
        ->where('nomina.codigo_empleado',$codigo_empleado)
        ->where('historico_ascensos.codigo_grado', '=', '090')
        ->first();
        if ($tte == null || $tte->añoascensotte == null) {
            $añoascensotte = "0";
        } else {
            $añoascensotte = Carbon::parse($tte->añoascensotte)->format('My');
        }
        $ptte = Nomina::join('historico_ascensos', 'historico_ascensos.codigo_empleado', '=', 'nomina.codigo_empleado')
        ->select('historico_ascensos.orden_merito_ascenso','historico_ascensos.total_orden_merito_ascenso','historico_ascensos.fecha_ascenso as añoascensoptte')
        ->where('nomina.codigo_empleado',$codigo_empleado)
        ->where('historico_ascensos.codigo_grado', '=', '080')
        ->first();
        if ($ptte == null || $ptte->añoascensoptte == null) {
            $añoascensoptte = "0";
        } else {
        $añoascensoptte = Carbon::parse($ptte->añoascensoptte)->format('My');
        }
        $cap = Nomina::join('historico_ascensos', 'historico_ascensos.codigo_empleado', '=', 'nomina.codigo_empleado')
        ->select('historico_ascensos.orden_merito_ascenso','historico_ascensos.total_orden_merito_ascenso','historico_ascensos.fecha_ascenso as añoascensocap')
        ->where('nomina.codigo_empleado',$codigo_empleado)
        ->where('historico_ascensos.codigo_grado', '=', '070')
        ->first();
        if ($cap == null || $cap->añoascensocap == null) {
            $añoascensocap = "0";
        } else {
        $añoascensocap = Carbon::parse($cap->añoascensocap)->format('My');
        }
        $may = Nomina::join('historico_ascensos', 'historico_ascensos.codigo_empleado', '=', 'nomina.codigo_empleado')
        ->select('historico_ascensos.orden_merito_ascenso','historico_ascensos.total_orden_merito_ascenso','historico_ascensos.fecha_ascenso as añoascensomay')
        ->where('nomina.codigo_empleado',$codigo_empleado)
        ->where('historico_ascensos.codigo_grado', '=', '060')
        ->first();
        if ($may == null || $may->añoascensomay == null) {
            $añoascensomay = "0";
        }else{
        $añoascensomay = Carbon::parse($may->añoascensomay)->format('My');
        }
        $tcnel = Nomina::join('historico_ascensos', 'historico_ascensos.codigo_empleado', '=', 'nomina.codigo_empleado')
        ->select('historico_ascensos.orden_merito_ascenso','historico_ascensos.total_orden_merito_ascenso','historico_ascensos.fecha_ascenso as añoascensotcnel')
        ->where('nomina.codigo_empleado',$codigo_empleado)
        ->where('historico_ascensos.codigo_grado', '=', '050')
        ->first();
        if ($tcnel == null || $tcnel->añoascensotcnel == null) {
            $añoascensotcnel = "0";
        }else{
        $añoascensotcnel = Carbon::parse($tcnel->añoascensotcnel)->format('My');
        }
        $cnel = Nomina::join('historico_ascensos', 'historico_ascensos.codigo_empleado', '=', 'nomina.codigo_empleado')
        ->select('historico_ascensos.orden_merito_ascenso','historico_ascensos.total_orden_merito_ascenso','historico_ascensos.fecha_ascenso as añoascensocnel')
        ->where('nomina.codigo_empleado',$codigo_empleado)
        ->where('historico_ascensos.codigo_grado', '=', '040')
        ->first();
        if ($cnel == null || $cnel->añoascensocnel == null) {
            $añoascensocnel = "0";
        }else{
        $añoascensocnel = Carbon::parse($cnel->añoascensocnel)->format('My');
        }
        $gb = Nomina::join('historico_ascensos', 'historico_ascensos.codigo_empleado', '=', 'nomina.codigo_empleado')
        ->select('historico_ascensos.orden_merito_ascenso','historico_ascensos.total_orden_merito_ascenso','historico_ascensos.fecha_ascenso as añoascensogb')
        ->where('nomina.codigo_empleado',$codigo_empleado)
        ->where('historico_ascensos.codigo_grado', '=', '030')
        ->first();
        if ($gb == null || $gb->añoascensogb == null) {
            $añoascensogb = "0";
        }else{
        $añoascensogb = Carbon::parse($gb->añoascensogb)->format('My');
        }


        $cursos = Nomina::join('cursos_realizados', 'cursos_realizados.codigo_empleado', '=', 'nomina.codigo_empleado')
            ->join('cursos', 'cursos.codigo_curso', '=', 'cursos_realizados.codigo_curso')
            ->join('paises', 'paises.codigo_pais', '=', 'cursos_realizados.pais_curso')
            ->join('ubicaciones', 'ubicaciones.codigo_ubicacion', '=', 'cursos_realizados.unidad')
            ->select('cursos.descripcion_curso as curso', 'paises.descripcion as pais','cursos_realizados.orden_merito_curso as ordenI',
            'cursos_realizados.total_orden_merito_curso as ordenT','ubicaciones.descripcion as unidad','cursos_realizados.fecha_registro as fecha')
            ->where('nomina.codigo_empleado',$codigo_empleado)
            ->orderBy('cursos_realizados.fecha_registro', 'desc')
            ->limit(3)
            ->get();

            // Obtener los tres registros más recientes
            $curso1 = isset($cursos[0]) ? $cursos[0] : null;
            $curso2 = isset($cursos[1]) ? $cursos[1] : null;
            $curso3 = isset($cursos[2]) ? $cursos[2] : null;


            $cargos = Movimientos:://join('movimientos', 'movimientos.codigo_empleado', '=', 'nomina.codigo_empleado')
          join('cargos', 'cargos.codigo_cargo', '=', 'movimientos.codigo_cargo')
            ->join('ubicaciones', 'ubicaciones.codigo_ubicacion', '=', 'movimientos.codigo_ubicacion')
            ->select('cargos.nombre_cargo as cargo', 'ubicaciones.descripcion as unidad',
             'movimientos.fecha_movimiento as fecha', 'ubicaciones.codigo_ubicacion as codigo',
             'movimientos.fecha_cargo as fecha')
            ->where('movimientos.codigo_empleado',$codigo_empleado)
           ->whereIn('movimientos.tipo_movimiento', ['Actualizacion de la Ubicacion','CCAR', 'Actualizacion del Cargo'])
           ->orderBy('movimientos.fecha_movimiento', 'desc')
        ->orderBy('movimientos.id', 'desc') // Ordenar también por ID
            ->limit(3)
            ->distinct()
            ->get();

// Obtener los tres registros más recientes
$cargo1 = isset($cargos[0]) ? $cargos[0] : null;
$cargo2 = isset($cargos[1]) ? $cargos[1] : null;
$cargo3 = isset($cargos[2]) ? $cargos[2] : null;
$titulo= 'ficha';

    $pdf = \PDF::loadView('juntap.reportes.ficha1', compact('datos', 'años', 'niveles', 'tte', 'ptte', 'cap', 'may', 'tcnel', 'cnel', 'gb', 'añoascensoptte', 'añoascensocap', 'añoascensomay', 'añoascensotcnel', 'añoascensocnel', 'añoascensogb', 'curso1', 'curso2', 'curso3', 'cargo1', 'cargo2', 'cargo3', 'cmdt'))
    ->setPaper('letter', 'landscape');
    return $pdf->stream('ficha.pdf', array('Attachment' => 0));


    /* return view('juntap.reportes.ficha1',
            compact(
                'datos','años','niveles','tte','ptte','cap','may','tcnel','cnel','gb',
                'añoascensoptte','añoascensocap','añoascensomay','añoascensotcnel',
                'añoascensocnel','añoascensogb','curso1','curso2','curso3','cargo1','cargo2','cargo3','cmdt'
            )
        );*/



       /* $nombre_archivo = sprintf('lista de personal %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
          $data = compact('titulo', 'datos','años','niveles','tte','ptte','cap','may','tcnel','cnel','gb',
          'añoascensoptte','añoascensocap','añoascensomay','añoascensotcnel',
          'añoascensocnel','añoascensogb','curso1','curso2','curso3','cargo1','cargo2','cargo3','cmdt');
            return Excel::download(new  FichaExport($data), $nombre_archivo);*/




    }
    public function fichaBucar()
    {
        return view('juntap.reportes.fichabuscar');
    }

     //Obtiene el personal militar egresado, exclusivo por api para el Datatable


    public function personalNoMilitarEgresado(Request $request){
        $empleados = Empleado::where('empleados.situacion','E');
        $empleados->leftjoin('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->leftjoin('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->leftjoin('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->leftjoin('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->leftjoin('egresos','egresos.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->leftjoin('tipo_de_baja','tipo_de_baja.codigo_egreso','=','egresos.causa_egreso');
        $empleados->whereIn('nomina.tipo_emp',['MEF','ALI']);
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
            'tipo_de_baja.descripcion as motivo',
            'egresos.fecha_salida as fecha_salida',
            'egresos.nro_resuelto as nro_resuelto',
        );
        $datatable= Datatables::of($empleados);
        return $datatable->make(true);
    }

    public function egresado()
    {
        $grados_militares = GradosMilitares::whereIn('tipo_emp',['ALI'])->orderBy('codigo_grado','asc')->orderBy('codigo_grado','asc')->get();
        $ubicaciones = Ubicaciones::all();
        return view('sireh.personal.militar_noprof.egresado.index', compact(
            'grados_militares',
            'ubicaciones',
        ));
    }
}
