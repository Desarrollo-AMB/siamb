<?php

namespace App\Http\Controllers;

use App\Exports\reportedress;
use App\Models\CategoriasMilitares;
use App\Models\DatosMilitares;
use App\Models\Empleado;
use App\Models\EspecialidadesMilitares;
use App\Models\GradosMilitares;
use App\Models\ModelArmamento;
use App\Models\ModelEquipos;
use App\Models\ModelEventos;
use App\Models\ModelJres;
use App\Models\ModelPersonalDres;
use App\Models\ModelReporteDres;
use App\Models\Nomina;
use App\Models\Ubicaciones;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Polyfill\Intl\Grapheme\Grapheme;

class Drescontroller extends Controller
{
    public function index()
    {

        $ubicaciones = Ubicaciones::all();
        $eventos = ModelEventos::all();
        $jres = ModelJres::all();
        $especialidades = EspecialidadesMilitares::all();
        $grados_militares = GradosMilitares::all();
        $categorias = CategoriasMilitares::all();
        $tipo_evento = config::get('constants.tipo_evento');
        $sexo = config::get('constants.sexo');
        return view('dress.create', compact('ubicaciones', 'eventos', 'tipo_evento', 'jres', 'especialidades', 'grados_militares', 'categorias', 'sexo'));
    }
    public function getTiposEvento(Request $request)
    {
        // Obtén la clase de evento desde la solicitud
        $claseEvento = $request->input('clase');

        // Realiza la lógica para obtener los tipos de evento asociados a la clase (ajusta según tu estructura de datos)
        $tiposEvento = ModelEventos::where('clase', $claseEvento)->get(); // Reemplaza con tu lógica para obtener los tipos de evento

        return response()->json($tiposEvento);
    }

    public function reporte(Request $request)
    {
        $this->validate(
            $request,
            [
                'n_reporte' => 'required',
                'JRES' => 'required',
                'fechaR' => 'required',
                'grupo_fecho_hora' => 'required',
                'p_envia' => 'required',
                'unidad' => 'required',
                'cmdtU' => 'required',
                'clase' => 'required',
                'tipo' => 'required',
                'event' => 'required',
                'descripcion' => 'required',
                'lugarO' => 'required',
                'fechaO' => 'required',
                'situacion' => 'required',
                'documentos' => 'required',
            ],
            [
                'n_reporte' => 'el numero de reporte es requerido',
                'JRES' => 'JRES es requerido',
                'fechaR' => 'fecha de reporte es requerido',
                'grupo_fecho_hora' => 'grupo fecho hora es requerido',
                'p_envia' => 'persona envia es requerido',
                'unidad' => 'unidad es requerido',
                'cmdtU' => 'comandante der unidad es requerido',
                'clase' => 'clase  de evento es requerido',
                'tipo' => 'tipo  de evento es requerido',
                'event' => 'evento es requerido ',
                'descripcion' => 'la descripcion es requerida',
                'lugarO' => 'lugar de ocurrencia es requerido',
                'fechaO' => 'fecha de ocurrencia es requerido',
                'situacion' => 'la situacion es requerida',
                'documentos' => 'documentos afectados es requerido',
            ]
        );

        try {

            $data = new ModelReporteDres();
            $data->n_reporte = $request->n_reporte;
            $data->JRES = $request->JRES;
            $data->fecha_reporte = $request->fechaR;
            $data->grupo_fecha = $request->grupo_fecho_hora;
            $data->persona_envia = $request->p_envia;
            $data->unidad_involucrada = $request->unidad;
            $data->gps= $request->gps;
            $data->cmdt_unidad = $request->cmdtU;
            $data->clase_envento = $request->clase;
            $data->tipo_evento = $request->tipo;
            $data->evento = $request->event;
            $data->descripcion = $request->descripcion;
            $data->lugar_ocurrencia = $request->lugarO;
            $data->fecha_ocurrencia = $request->fechaO;
            $data->situacion = $request->situacion;
            $data->documento = $request->documentos;
            $data->save();

            return redirect()->route('dres.view')->with('success', 'Se ha cargado  la información exitosamente');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }
    public function personal(Request $request)
    {
        $this->validate($request, [
            'n_reporte' => 'required',
            'especialidad.*' => 'required',
            'sexo.*' => 'required',
            'grado.*' => 'required',
            'categoria.*' => 'required',
            'nombre1.*' => 'required',
            'nombre2.*' => 'required',
            'apellido1.*' => 'required',
            'apellido2.*' => 'required',
            'cedula.*' => 'required',
            'relacion.*' => 'required',
        ]);
    
        try {
            // Recorrer cada conjunto de datos y guardar un nuevo registro
            foreach ($request->cedula as $index => $cedula) {
                $data = new ModelPersonalDres();
                $data->n_reporte = $request->n_reporte;
                $data->especialidad = $request->especialidad[$index];
                $data->sexo = $request->sexo[$index];
                $data->grado = $request->grado[$index];
                $data->categoria = $request->categoria[$index];
                $data->nombre1 = $request->nombre1[$index];
                $data->nombre2 = $request->nombre2[$index];
                $data->apellido1 = $request->apellido1[$index];
                $data->apellido2 = $request->apellido2[$index];
                $data->cedula = $cedula;
                $data->relacion = $request->relacion[$index];
                $data->save();
            }
    
            return redirect()->route('dres.view')->with('success', 'Se ha cargado el Personal exitosamente');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function armamento(Request $request)
    {
        $this->validate(
            $request,
            [
                'n_reporte' => 'required',
                'marca' => 'required',
                'modelo' => 'required',
                'serial' => 'required',
                'unidad_a' => 'required',
                'relacion' => 'required',
            ],
            [
                'n_reporte' => 'el numero de reporte es requerido',
                'marca' => 'La Especialidad es requerida requerido',
                'modelo' => 'fecha de reporte es requerido',
                'serial' => 'Grado es requerida',
                'unidad_a' => 'Categoria es requerida',
                'relacion' => 'nombres es requerido',
            ]
        );

        try {

            $data = new ModelArmamento();
            $data->n_reporte = $request->n_reporte;
            $data->marca = $request->marca;
            $data->modelo = $request->modelo;
            $data->serial = $request->serial;
            $data->unidad = $request->unidad_a;
            $data->situacion = $request->relacion ;
            $data->save();

            return redirect()->route('dres.view')->with('success', 'Se ha cargado  el Armamento exitosamente');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }
    public function equipos(Request $request)
    { 
        $this->validate(
            $request,
            [
                'n_reporte' => 'required',
                'tipo' => 'required',
                'modelo' => 'required',
                'serial' => 'required',
            ],
            [
                'n_reporte' => 'el numero de reporte es requerido',
                'tipo' => 'La Especialidad es requerida requerido',
                'modelo' => 'fecha de reporte es requerido',
                'serial' => 'Grado es requerida',
            ]
        );

        try {

            $data = new ModelEquipos();
         
            $data->n_reporte = $request->n_reporte;
            $data->tipo = $request->tipo;
            $data->modelo = $request->modelo;
            $data->siglas = $request->serial;
            $data->save();

            return redirect()->route('dres.view')->with('success', 'Se ha cargado el equipo  exitosamente');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }
    public function reporteDress(Request $request)
    {
        $this->validate($request, [
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ], [
            'fecha_inicio.required' => 'La fecha de inicio es requerida',
            'fecha_fin.required' => 'La fecha de fin es requerida',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio',
        ]);

     

        //switch ($reporte) {
        //    case 1:
            $complementoTitulo = "REPORTE";
            $datos = ModelReporteDres::select('*')
                ->whereBetween('fecha_reporte', [$request->fecha_inicio, $request->fecha_fin])
                ->get();
          /*      if($grado_militar!=='0'){
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
        }*/
        if(count($datos)>0){
            \Session::flash('success','Reporte Ejecutado con exito !');
            $titulo = 'REPORTE DRES';

            $nombre_archivo = sprintf('Reporte %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
            $data = compact('titulo', 'datos');
            return Excel::download(new reportedress($data), $nombre_archivo);
        }else {
            return redirect()->back()->with('error', 'No hay Datos para generar el informe');
        }

    }
    public function excel()
    {
        $ubicaciones= Ubicaciones::all();
        return view('dress.reporte.reportes',compact('ubicaciones'));
    }

    public function datos(Request $request)
    {
        // Obtener la cédula proporcionada en la solicitud AJAX
$cedula = $request->input('cedula');

// Buscar el empleado en la base de datos por la cédula
$empleado = Nomina::where('cedula', $cedula)->first();

if ($empleado) {
    // Buscar los datos militares del empleado
    $datos = DatosMilitares::where('codigo_empleado', $empleado->codigo_empleado)->first();

    if ($datos) {
        // Buscar la categoría militar relacionada
        $categoria = CategoriasMilitares::where('codigo_categoria', $datos->codigo_categoria)->first();
        $especialidad = EspecialidadesMilitares::where('codigo_especialidad', $datos->codigo_especialidad1)->first();
        $grado = GradosMilitares::where('codigo_grado', $empleado->grado_militar)->first();
        $sexo = Empleado::where('codigo_empleado', $empleado->codigo_empleado)->first();

        if ($categoria) {
            // Verificar si la especialidad está vacía
            $especialidadDescripcion = $especialidad ? $especialidad->descripcion : 'NO POSEE ESEPCIALIDAD REGISTADA';

            // Convertir el valor del sexo
            $sexoDescripcion = ($sexo->sexo === 'M') ? 'MASCULINO' : 'FEMENINO';

            // Devolver los datos del empleado en formato JSON
            return response()->json([
                'nombre1' => $empleado->nombre1,
                'nombre2' => $empleado->nombre2,
                'apellido1' => $empleado->apellido1,
                'apellido2' => $empleado->apellido2,
                'categoria' => $categoria->descripcion,
                'especialidad' => $especialidadDescripcion,
                'grado' => $grado->descripcion,
                'sexo' => $sexoDescripcion,
                // Agrega más campos si es necesario
            ]);
        } else {
            // Si no se encuentra la categoría, devolver un error
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }
    } else {
        // Si no se encuentran los datos militares, devolver un error
        return response()->json(['error' => 'Datos militares no encontrados'], 404);
    }
} else {
    // Si no se encuentra el empleado, devolver un error
    return response()->json(['error' => 'Empleado no encontrado'], 404);
}
}
}
