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

        return view('sireh.personal.ingreso', 
            compact(
                'user_auth', 'tipos_emp', 'generos', 'edos_civil',
                'estados', 'ubicaciones', 'ubicaciones_det', 'niveles',
                'cargos', 'nacionalidades', 'universidades', 'profesiones'
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
            $codigo_empleado = Empleado::max('codigo_empleado')+1;
            if ($request->file("foto")){
                $ext = $request->file('foto')->getClientOriginalExtension();
                $file_name = 'empleado_'.$codigo_empleado . '.' . $ext;
        
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
                $datos_militares->save();
            }
            if( !empty($request->universidad) || !empty($request->profesion)){
                $estudio_realizado = new EstudiosRealizados;
                $estudio_realizado->codigo_empleado = $empleado->codigo_empleado;
                $estudio_realizado->nivel = $request->nivel;
                $estudio_realizado->profesion = $request->profesion;
                $estudio_realizado->universidad = $request->universidad;
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
        $datos_militares = DatosMilitares::all();
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
                'categorias_militares','situaciones','promociones_militares',
                'datos_militares','especialidades_militares','lateralidades'
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
        $datos_militares = DatosMilitares::all();
        $categorias_militares = CategoriasMilitares::all();
        $promociones_militares = PromocionesMilitares::all();
        $datos = Empleado::with(['nomina','datos_militares','estudios_realizados'])->find($id);
        return view('sireh.personal.militar.edit', 
            compact(
                'datos','ciudades','grados_militares',
                'user_auth', 'tipos_emp', 'generos', 'edos_civil',
                'estados', 'ubicaciones', 'ubicaciones_det', 'niveles',
                'cargos', 'nacionalidades', 'universidades', 'profesiones',
                'datos_militares', 'categorias_militares', 'situaciones',
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
            if ($request->file("foto")){
                $ext = $request->file('foto')->getClientOriginalExtension();
                $file_name = 'empleado_'.$request->codigo_empleado . '.' . $ext;
        
                $path_foto = 'fotos/empleados/' . $file_name;
                if(file_exists($path_foto)){
                    unlink($path_foto); // Eliminamos la imagen previa si existe.
                }
                Image::make($request->file('foto'))->save( public_path($path_foto));
            }else{
                $path_foto = null;
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
                "foto" => $path_foto,
            ]);

            $nomina = Nomina::where('codigo_empleado',$request->codigo_empleado)->update([
                "cedula" => $request->cedula,
                "tipo_emp" => $request->tipo_emp,
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
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar');
        $empleados->join('egresos','egresos.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipo_de_baja','tipo_de_baja.codigo_egreso','=','egresos.causa_egreso');
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
        $datos_militares = DatosMilitares::all();
        $tipo_de_baja = TipoDeBaja::all();
        $datos = Empleado::with(['nomina','datos_militares'])->find($id);
        return view('sireh.personal.militar.baja', 
            compact(
                'datos','grados_militares','situaciones',
                'user_auth','ubicaciones','datos_militares',
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
        $empleados = Empleado::join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado')
        ->join('datos_militares','datos_militares.codigo_empleado','=','nomina.codigo_empleado')
        ->leftJoin('cargos','cargos.codigo_cargo','=','nomina.codigo_cargo')
        ->leftJoin('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
        ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
        ->join('categorias_militares','categorias_militares.codigo_categoria','=','datos_militares.codigo_categoria')
        ->leftjoin('especialidades_militares as em1','em1.codigo_especialidad','=','datos_militares.codigo_especialidad1')
        ->leftjoin('especialidades_militares as em2','em2.codigo_especialidad','=','datos_militares.codigo_especialidad2')
        ->where('empleados.situacion','A')
        ->where('nomina.grado_militar',$request->grado_militar)
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
        //->limit(50)
        ->orderBy('datos_militares.fecha_ultimo_ascenso','asc')
        ->orderBy('datos_militares.fecha_graduacion','asc')
        ->orderBy('datos_militares.orden_merito','asc')
        ->get();

        $agrupados = $empleados->groupBy('categoria');

        $pdf = \PDF::loadview('sireh.personal.militar.imprimirescalafon', compact('agrupados','empleados'))->setPaper('a4', 'landscape');

        return $pdf->stream('escalafon.pdf');
        //return view('sireh.personal.militar.imprimirescalafon', compact('agrupados'));
    }

    //PERSONAL CIVIL FUNCTIONS
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
        $getEmpleadoCode = Empleado::select('codigo_empleado')->find($id);
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
        $noActive = Empleado::where('empleados.situacion','<>','A')
            ->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado')
            ->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp')
            //->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
            ->join('cargos','cargos.codigo_cargo','=','nomina.codigo_cargo')
            ->where('nomina.tipo_emp','<>','MIL')
            ->where('nomina.tipo_emp','<>','TRP')
            ->where('nomina.tipo_emp','<>','ALI')
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
                'cedula' => 'required|unique:empleados,cedula,'.$empleado->id,
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
        $haveFuncion = EmpleadoFuncion::where('codigo_empleado', $request->id)
            ->join('funcion_tripulante','funcion_tripulante.id','=','empleado_funcion.id_funcion')
            ->select(
                'empleado_funcion.id',
                'funcion_tripulante.funcion',
            )
            ->get();
        return response()->json([
                'success' => true,
                'message' => 'Data',
                'data' => $data,
                'haveFuncion' => $haveFuncion,
            ]
        );
    }
    public function storeFuncionPersonalMilitar(Request $request)
    {
        $loop = count($request->funcion_id);
        for ($i=0; $i < $loop; $i++) { 
            $funcion = new EmpleadoFuncion;
            $funcion->codigo_empleado = $request->codigo_empleado;
            $funcion->id_funcion = $request->funcion_id[$i];
            $funcion->save();
        }
        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'data' => $funcion,
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

}
