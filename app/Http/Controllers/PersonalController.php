<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

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
use App\Models\EstudiosRealizados;
use App\Models\Ciudades;
use App\Models\GradosMilitares;
use App\Models\CategoriasMilitares;
use App\Models\PromocionesMilitares;
use App\Models\Movimientos;
use App\Models\Cursos;
use App\Models\CursosRealizados;

class PersonalController extends Controller
{
    public function index()
    {
        return view('sireh.personal.index');
    }

    public function indexPersonalMilitar()
    {
        return view('sireh.personal.militar.index');
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
        $empleados->whereIn('nomina.tipo_emp',['MIL','TRP']);
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
        //$empleados->whereNotIn('nomina.tipo_emp',['MIL','TRP','ALI','MEF']);
        $empleados->where('nomina.tipo_emp','<>','MIL')->where('nomina.tipo_emp','<>','TRP')->where('nomina.tipo_emp','<>','ALI');
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
        return view('sireh.personal.militar.view', 
            compact(
                'datos','ciudades','grados_militares',
                'user_auth', 'tipos_emp', 'generos', 'edos_civil',
                'estados', 'ubicaciones', 'ubicaciones_det', 'niveles',
                'cargos', 'nacionalidades', 'universidades', 'profesiones'
            )
        );
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

}
