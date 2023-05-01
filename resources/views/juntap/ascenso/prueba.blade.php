









{{-- MODAL FUNCION EMPLEADO --}}
<div class="modal fade" id="modal-view-ascenso_personal" tabindex="-1" role="dialog" aria-labelledby="egresarTitle" aria-hidden="true">
    <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ascenso Personal Militar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <input class="codigo_empleado_funcion" name="codigo_empleado_funcion" id="codigo_empleado_funcion" type="hidden" value="">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Orden de Merito</label>
                                
                                <input  type="Number" class="form-control" name="OM" class="om"  >
                                <input  type="text" class="form-control nombre_empleado" value="" id="nombre_empleado" disabled>
                                
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Orden de Merito Total</label>

                                <input type="Number" class="form-control" name="OMT" class="omt" >
                                
                                <input  type="text" class="form-control cedula_empleado" value="" id="cedula_empleado" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Seleccionar Función</label>
                                <select class="form-control funcion select2" id="funcion" name="funcion[]" multiple="multiple" required>
                                    {{--<option value="">Seleccione...</option>
                                    @foreach($funcionEmpleado as $data) 
                                        <option value="{{$data->id}}">{{$data->funcion}}</option>
                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="haveFuncion">
                        <label class='col-form-label showLabel' hidden="true">Ascenso del Personal Militar</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn bg-gradient-danger close-modal" data-bs-dismiss="modal" disabled="false">Atras</a>
                    <a class="btn bg-gradient-success enviar_funcion" disabled="false">Confirmar</a>
                </div>
            </form>
        </div>
    </div>
</div>

















<?php

namespace App\Http\Controllers\juntaperm;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\juntapExport;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Empleado;
use App\Models\GradosMilitares;
use App\Models\Nomina;

class controllerjuntap extends Controller
{
    public function juntap()
    {
        return view('juntap.ascenso.index');
    } //

    public function indexreporte()
    {
        return view('juntap.reportes.index');
    } //


    public function reportenasc()
    {
        return view('juntap.reportes.reporteascenso');
    } //

    public function ascjulio()
    {
        return view('juntap.ascenso.julio');
    } //

    public function ascdiciembre()
    {
        return view('juntap.ascenso.diciembre');
    } //

    public function asccategoria()
    {
        return view('juntap.ascenso.categoria');
    } //

    public function ascselect(Request $request)
    {

        ini_set('max_execution_time', 300);

        $periodo = $request->input('select_periodo');

        $categoria = $request->input('select_categoria');

        $empleados = [];


        switch ($periodo) {
            case 'julio':

                switch ($categoria) {
                    case 'comando':
                        return view('juntap.ascenso.julio.comando');
                        break;

                    case 'tecnico':
                        return view('juntap.ascenso.julio.tecnico');
                        break;
                    case 'ofitropa':
                        return view('juntap.ascenso.julio.ofitropa');
                        break;
                    case 'asimiladotec':
                        return view('juntap.ascenso.julio.asitecnico');
                        break;
                    case 'asimilado':
                        return view('juntap.ascenso.julio.asimilado');
                        break;
                    case 'tropaprofesional':
                        return view('juntap.ascenso.julio.tropap');
                        break;


                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }

                break;


            case 'diciembre':

                switch ($categoria) {

                    case 'ofitropa':
                        return view('juntap.ascenso.diciembre.ofitropa');
                        break;
                    case 'asimiladotec':
                        return view('juntap.ascenso.diciembre.asitecnico');
                        break;
                    case 'asimilado':
                        return view('juntap.ascenso.diciembre.asimilado');
                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }
                break;

            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                // return response()->json("no funciona");
                break;
        }
    } //


    public function ascender_julio(Request $request)
    {
        $codigo_empleado = $request->input('codigo_empleado');
        $cedula = $request->input('cedula');
        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');
        $grado_militar = $request->input('grado_militar');
        $demerito = $request->input('demerito');
        $OM = $request->input('OM');
        $OMT = $request->input('OMT');
        $grado_ascender = $request->input('grado_ascender');
        $gd = $request->input('gd');

        // Obtener la fecha actual y establecer el día de ascenso en el 5 de julio
        $ano_actual = date('Y');
        $fecha_ascenso = "$ano_actual-07-05";

        $data = [];
        $ascendidos = 0; // Contador de empleados ascendidos exitosamente

        foreach ($gd as $index => $value) {
            if ($value == '1') {
                $codigo = $codigo_empleado[$index];

                // Editar la tabla "datos_militares"
                DB::table('datos_militares')
                    ->where('codigo_empleado', $codigo)
                    ->update([
                        'fecha_ultimo_ascenso' => $fecha_ascenso,
                        'orden_merito' => $OM[$index],
                        'total_orden_merito' => $OMT[$index]
                    ]);

                // Obtener el código de grado a ascender
                $codigo_grado = DB::table('grados_militares')
                    ->where('descripcion', $grado_ascender[$index])
                    ->pluck('codigo_grado')
                    ->first();

                // Editar la tabla "nomina"
                $result = DB::table('nomina')
                    ->where('codigo_empleado', $codigo)
                    ->update(['grado_militar' => $codigo_grado]);

                if ($result) {
                    $data[] = [
                        'codigo_empleado' => $codigo,
                        'mensaje' => 'Empleado ascendido exitosamente'
                    ];
                    $ascendidos++; // Incrementar el contador de empleados ascendidos
                } else {
                    $data[] = [
                        'codigo_empleado' => $codigo,
                        'mensaje' => 'Error al ascender el empleado'
                    ];
                }
            }
        }

        $total_empleados = count($gd); // Número total de empleados seleccionados
        $mensaje = ''; // Inicializar el mensaje

        if ($ascendidos >= 1) {
            $mensaje = 'Ascenso exitoso para todos los empleados seleccionados';
            $response = [
                'data' => $data,
                'success' => true,
                'message' => $mensaje
            ];
        } else {
            $mensaje = 'No se pudo ascender a todos los empleados seleccionados';
            $response = [
                'data' => $data,
                'success' => false,
                'message' => $mensaje
            ];
        }



        return response()->json($response);
    }

    public function ascender_diciembre(Request $request)
    {
        $codigo_empleado = $request->input('codigo_empleado');
        $cedula = $request->input('cedula');
        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');
        $grado_militar = $request->input('grado_militar');
        $demerito = $request->input('demerito');
        $OM = $request->input('OM');
        $OMT = $request->input('OMT');
        $grado_ascender = $request->input('grado_ascender');
        $gd = $request->input('gd');

        // Obtener la fecha actual y establecer el día de ascenso en el 5 de julio
        $ano_actual = date('Y');
        $fecha_ascenso = "$ano_actual-12-10";

        $data = [];
        $ascendidos = 0; // Contador de empleados ascendidos exitosamente

        foreach ($gd as $index => $value) {
            if ($value == '1') {
                $codigo = $codigo_empleado[$index];

                // Editar la tabla "datos_militares"
                DB::table('datos_militares')
                    ->where('codigo_empleado', $codigo)
                    ->update([
                        'fecha_ultimo_ascenso' => $fecha_ascenso,
                        'orden_merito' => $OM[$index],
                        'total_orden_merito' => $OMT[$index]
                    ]);

                // Obtener el código de grado a ascender
                $codigo_grado = DB::table('grados_militares')
                    ->where('descripcion', $grado_ascender[$index])
                    ->pluck('codigo_grado')
                    ->first();

                // Editar la tabla "nomina"
                $result = DB::table('nomina')
                    ->where('codigo_empleado', $codigo)
                    ->update(['grado_militar' => $codigo_grado]);

                if ($result) {
                    $data[] = [
                        'codigo_empleado' => $codigo,
                        'mensaje' => 'Empleado ascendido exitosamente'
                    ];
                    $ascendidos++; // Incrementar el contador de empleados ascendidos
                } else {
                    $data[] = [
                        'codigo_empleado' => $codigo,
                        'mensaje' => 'Error al ascender el empleado'
                    ];
                }
            }
        }

        $total_empleados = count($gd); // Número total de empleados seleccionados
        $mensaje = ''; // Inicializar el mensaje

        if ($ascendidos >= 1) {
            $mensaje = 'Ascenso exitoso para todos los empleados seleccionados';
            $response = [
                'data' => $data,
                'success' => true,
                'message' => $mensaje
            ];
        } else {
            $mensaje = 'No se pudo ascender a todos los empleados seleccionados';
            $response = [
                'data' => $data,
                'success' => false,
                'message' => $mensaje
            ];
        }



        return response()->json($response);
    }

    public function select_diciembre_ofitropa(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');

        $empleados = [];


        switch ($categoria) {
            case 7:

                switch ($grado) {
                    case '15':




                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',

                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {

                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '020':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;

                    case '030':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '040':


                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 12
                                           WHEN naturaleza = 2 THEN 15
                                           WHEN naturaleza = 3 THEN 20
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;


                    case '050':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 10
                                           WHEN naturaleza = 2 THEN 13
                                           WHEN naturaleza = 3 THEN 18
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '060':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 8
                                           WHEN naturaleza = 2 THEN 11
                                           WHEN naturaleza = 3 THEN 16
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                    case '070':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 6
                                           WHEN naturaleza = 2 THEN 9
                                           WHEN naturaleza = 3 THEN 14
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '080':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 01");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 4
                                           WHEN naturaleza = 2 THEN 7
                                           WHEN naturaleza = 3 THEN 12
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '090':

                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 2
                                           WHEN naturaleza = 2 THEN 5
                                           WHEN naturaleza = 3 THEN 10
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                // return response()->json("no funciona");
                break;
        }
    }

    public function select_diciembre_asitecnico(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');

        $empleados = [];


        switch ($categoria) {
            case 6:

                switch ($grado) {
                    case '15':




                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',

                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {

                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '020':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;

                    case '030':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '040':


                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 12
                                           WHEN naturaleza = 2 THEN 15
                                           WHEN naturaleza = 3 THEN 20
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;


                    case '050':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 10
                                           WHEN naturaleza = 2 THEN 13
                                           WHEN naturaleza = 3 THEN 18
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '060':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 8
                                           WHEN naturaleza = 2 THEN 11
                                           WHEN naturaleza = 3 THEN 16
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                    case '070':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 6
                                           WHEN naturaleza = 2 THEN 9
                                           WHEN naturaleza = 3 THEN 14
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '080':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 4
                                           WHEN naturaleza = 2 THEN 7
                                           WHEN naturaleza = 3 THEN 12
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '090':

                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 2
                                           WHEN naturaleza = 2 THEN 5
                                           WHEN naturaleza = 3 THEN 10
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                // return response()->json("no funciona");
                break;
        }
    }

    public function select_diciembre_asimilado(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');

        $empleados = [];


        switch ($categoria) {
            case 2:

                switch ($grado) {
                    case '15':




                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',

                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {

                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '020':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;

                    case '030':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '040':


                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 12
                                           WHEN naturaleza = 2 THEN 15
                                           WHEN naturaleza = 3 THEN 20
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;


                    case '050':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 10
                                           WHEN naturaleza = 2 THEN 13
                                           WHEN naturaleza = 3 THEN 18
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '060':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 8
                                           WHEN naturaleza = 2 THEN 11
                                           WHEN naturaleza = 3 THEN 16
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                    case '070':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 6
                                           WHEN naturaleza = 2 THEN 9
                                           WHEN naturaleza = 3 THEN 14
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '080':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 4
                                           WHEN naturaleza = 2 THEN 7
                                           WHEN naturaleza = 3 THEN 12
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '090':

                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 2
                                           WHEN naturaleza = 2 THEN 5
                                           WHEN naturaleza = 3 THEN 10
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                // return response()->json("no funciona");
                break;
        }
    }

    public function select_julio_comando(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');

        $empleados = [];


        switch ($categoria) {
            case 4:

                switch ($grado) {
                    case '15':




                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            //  ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',

                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {

                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '020':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;

                    case '030':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '040':


                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 12
                                           WHEN naturaleza = 2 THEN 15
                                           WHEN naturaleza = 3 THEN 20
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;


                    case '050':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 10
                                           WHEN naturaleza = 2 THEN 13
                                           WHEN naturaleza = 3 THEN 18
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '060':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 8
                                           WHEN naturaleza = 2 THEN 11
                                           WHEN naturaleza = 3 THEN 16
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                    case '070':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 6
                                           WHEN naturaleza = 2 THEN 9
                                           WHEN naturaleza = 3 THEN 14
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '080':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 4
                                           WHEN naturaleza = 2 THEN 7
                                           WHEN naturaleza = 3 THEN 12
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '090':

                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 2
                                           WHEN naturaleza = 2 THEN 5
                                           WHEN naturaleza = 3 THEN 10
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                // return response()->json("no funciona");
                break;
        }
    }
    public function select_julio_tecnico(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');

        $empleados = [];


        switch ($categoria) {
            case 5:

                switch ($grado) {
                    case '15':




                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',

                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {

                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '020':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;

                    case '030':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '040':


                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 12
                                           WHEN naturaleza = 2 THEN 15
                                           WHEN naturaleza = 3 THEN 20
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;


                    case '050':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 10
                                           WHEN naturaleza = 2 THEN 13
                                           WHEN naturaleza = 3 THEN 18
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '060':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 8
                                           WHEN naturaleza = 2 THEN 11
                                           WHEN naturaleza = 3 THEN 16
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                    case '070':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 6
                                           WHEN naturaleza = 2 THEN 9
                                           WHEN naturaleza = 3 THEN 14
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '080':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 4
                                           WHEN naturaleza = 2 THEN 7
                                           WHEN naturaleza = 3 THEN 12
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '090':

                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 2
                                           WHEN naturaleza = 2 THEN 5
                                           WHEN naturaleza = 3 THEN 10
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                // return response()->json("no funciona");
                break;
        }
    }
    public function select_julio_ofitropa(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');

        $empleados = [];


        switch ($categoria) {
            case 7:

                switch ($grado) {
                    case '15':




                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',

                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {

                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '020':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;

                    case '030':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '040':


                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 12
                                           WHEN naturaleza = 2 THEN 15
                                           WHEN naturaleza = 3 THEN 20
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;


                    case '050':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 10
                                           WHEN naturaleza = 2 THEN 13
                                           WHEN naturaleza = 3 THEN 18
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '060':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 8
                                           WHEN naturaleza = 2 THEN 11
                                           WHEN naturaleza = 3 THEN 16
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                    case '070':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 6
                                           WHEN naturaleza = 2 THEN 9
                                           WHEN naturaleza = 3 THEN 14
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '080':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 4
                                           WHEN naturaleza = 2 THEN 7
                                           WHEN naturaleza = 3 THEN 12
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '090':

                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 2
                                           WHEN naturaleza = 2 THEN 5
                                           WHEN naturaleza = 3 THEN 10
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                // return response()->json("no funciona");
                break;
        }
    }

    public function select_julio_asitecnico(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');

        $empleados = [];


        switch ($categoria) {
            case 6:

                switch ($grado) {
                    case '15':




                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',

                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {

                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '020':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;

                    case '030':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '040':


                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 12
                                           WHEN naturaleza = 2 THEN 15
                                           WHEN naturaleza = 3 THEN 20
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;


                    case '050':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 10
                                           WHEN naturaleza = 2 THEN 13
                                           WHEN naturaleza = 3 THEN 18
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '060':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 8
                                           WHEN naturaleza = 2 THEN 11
                                           WHEN naturaleza = 3 THEN 16
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                    case '070':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 6
                                           WHEN naturaleza = 2 THEN 9
                                           WHEN naturaleza = 3 THEN 14
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '080':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 4
                                           WHEN naturaleza = 2 THEN 7
                                           WHEN naturaleza = 3 THEN 12
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '090':

                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 2
                                           WHEN naturaleza = 2 THEN 5
                                           WHEN naturaleza = 3 THEN 10
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                // return response()->json("no funciona");
                break;
        }
    }
    public function select_julio_asimilado(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');

        $empleados = [];


        switch ($categoria) {
            case 2:

                switch ($grado) {
                    case '15':




                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',

                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {

                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '020':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;

                    case '030':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '040':


                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 12
                                           WHEN naturaleza = 2 THEN 15
                                           WHEN naturaleza = 3 THEN 20
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;


                    case '050':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 10
                                           WHEN naturaleza = 2 THEN 13
                                           WHEN naturaleza = 3 THEN 18
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '060':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 8
                                           WHEN naturaleza = 2 THEN 11
                                           WHEN naturaleza = 3 THEN 16
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                    case '070':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 6
                                           WHEN naturaleza = 2 THEN 9
                                           WHEN naturaleza = 3 THEN 14
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '080':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 4
                                           WHEN naturaleza = 2 THEN 7
                                           WHEN naturaleza = 3 THEN 12
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '090':

                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 2
                                           WHEN naturaleza = 2 THEN 5
                                           WHEN naturaleza = 3 THEN 10
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                // return response()->json("no funciona");
                break;
        }
    }
    public function select_julio_tropap(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');

        $empleados = [];


        switch ($categoria) {
            case 8:

                switch ($grado) {



                    case '420':


                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 7
                                           WHEN naturaleza = 2 THEN 8
                                           WHEN naturaleza = 3 THEN 9
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;


                    case '430':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 6
                                           WHEN naturaleza = 2 THEN 7
                                           WHEN naturaleza = 3 THEN 8
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '440':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 5
                                           WHEN naturaleza = 2 THEN 6
                                           WHEN naturaleza = 3 THEN 7
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                    case '450':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 4
                                           WHEN naturaleza = 2 THEN 5
                                           WHEN naturaleza = 3 THEN 6
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '460':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 3
                                           WHEN naturaleza = 2 THEN 4
                                           WHEN naturaleza = 3 THEN 5
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '470':

                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                       CASE
                                           WHEN naturaleza = 1 THEN 2
                                           WHEN naturaleza = 2 THEN 3
                                           WHEN naturaleza = 3 THEN 4
                                           ELSE 0
                                       END
                                   ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                       (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                       FROM (
                                           SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                           FROM intelectuales 
                                           WHERE cedula = empleados.cedula
                                           GROUP BY cedula
                                       ) AS consulta1
                                       WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                // return response()->json("no funciona");
                break;
        }
    }

    public function select(Request $request)
    {
        ini_set('max_execution_time', 300);
        $empleados = [];
        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');

        switch ($categoria) {
            case 7:

                switch ($grado) {
                    case '15':




                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',

                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {

                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '020':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;

                    case '030':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '040':


                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 12
                                      WHEN naturaleza = 2 THEN 15
                                      WHEN naturaleza = 3 THEN 20
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;


                    case '050':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 10
                                      WHEN naturaleza = 2 THEN 13
                                      WHEN naturaleza = 3 THEN 18
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '060':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 8
                                      WHEN naturaleza = 2 THEN 11
                                      WHEN naturaleza = 3 THEN 16
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                    case '070':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 6
                                      WHEN naturaleza = 2 THEN 9
                                      WHEN naturaleza = 3 THEN 14
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '080':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 4
                                      WHEN naturaleza = 2 THEN 7
                                      WHEN naturaleza = 3 THEN 12
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '090':

                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 2
                                      WHEN naturaleza = 2 THEN 5
                                      WHEN naturaleza = 3 THEN 10
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }

                break;

            case 5:

                switch ($grado) {
                    case '15':




                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',

                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {

                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '020':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;

                    case '030':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '040':


                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 12
                                      WHEN naturaleza = 2 THEN 15
                                      WHEN naturaleza = 3 THEN 20
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;


                    case '050':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 10
                                      WHEN naturaleza = 2 THEN 13
                                      WHEN naturaleza = 3 THEN 18
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '060':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 8
                                      WHEN naturaleza = 2 THEN 11
                                      WHEN naturaleza = 3 THEN 16
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                    case '070':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 6
                                      WHEN naturaleza = 2 THEN 9
                                      WHEN naturaleza = 3 THEN 14
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '080':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 4
                                      WHEN naturaleza = 2 THEN 7
                                      WHEN naturaleza = 3 THEN 12
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '090':

                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 2
                                      WHEN naturaleza = 2 THEN 5
                                      WHEN naturaleza = 3 THEN 10
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }




                break;

            case 7:

                switch ($grado) {
                    case '15':




                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',

                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {

                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '020':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;

                    case '030':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '040':


                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 12
                                      WHEN naturaleza = 2 THEN 15
                                      WHEN naturaleza = 3 THEN 20
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;


                    case '050':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 10
                                      WHEN naturaleza = 2 THEN 13
                                      WHEN naturaleza = 3 THEN 18
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '060':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 8
                                      WHEN naturaleza = 2 THEN 11
                                      WHEN naturaleza = 3 THEN 16
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                    case '070':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 6
                                      WHEN naturaleza = 2 THEN 9
                                      WHEN naturaleza = 3 THEN 14
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '080':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 4
                                      WHEN naturaleza = 2 THEN 7
                                      WHEN naturaleza = 3 THEN 12
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '090':

                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 2
                                      WHEN naturaleza = 2 THEN 5
                                      WHEN naturaleza = 3 THEN 10
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }

                break;
            case 6:
                switch ($grado) {
                    case '15':




                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',

                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {

                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '020':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;

                    case '030':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '040':


                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 12
                                      WHEN naturaleza = 2 THEN 15
                                      WHEN naturaleza = 3 THEN 20
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;


                    case '050':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 10
                                      WHEN naturaleza = 2 THEN 13
                                      WHEN naturaleza = 3 THEN 18
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '060':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 8
                                      WHEN naturaleza = 2 THEN 11
                                      WHEN naturaleza = 3 THEN 16
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                    case '070':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 6
                                      WHEN naturaleza = 2 THEN 9
                                      WHEN naturaleza = 3 THEN 14
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '080':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 4
                                      WHEN naturaleza = 2 THEN 7
                                      WHEN naturaleza = 3 THEN 12
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '090':

                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 2
                                      WHEN naturaleza = 2 THEN 5
                                      WHEN naturaleza = 3 THEN 10
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }


                break;
            case 2:

                switch ($grado) {
                    case '15':




                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',

                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {

                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '020':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;

                    case '030':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->select(

                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                            )
                            ->orderBy('empleados.cedula')
                            ->get();


                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {
                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                        }
                        break;
                    case '040':


                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 12
                                      WHEN naturaleza = 2 THEN 15
                                      WHEN naturaleza = 3 THEN 20
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;


                    case '050':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 10
                                      WHEN naturaleza = 2 THEN 13
                                      WHEN naturaleza = 3 THEN 18
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '060':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 8
                                      WHEN naturaleza = 2 THEN 11
                                      WHEN naturaleza = 3 THEN 16
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                    case '070':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 6
                                      WHEN naturaleza = 2 THEN 9
                                      WHEN naturaleza = 3 THEN 14
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '080':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 4
                                      WHEN naturaleza = 2 THEN 7
                                      WHEN naturaleza = 3 THEN 12
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '090':

                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 2
                                      WHEN naturaleza = 2 THEN 5
                                      WHEN naturaleza = 3 THEN 10
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }

                break;
            case 8:
                switch ($grado) {
                    case '420':



                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 7
                                      WHEN naturaleza = 2 THEN 8
                                      WHEN naturaleza = 3 THEN 9
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '430':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1095")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 6
                                      WHEN naturaleza = 2 THEN 7
                                      WHEN naturaleza = 3 THEN 8
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;

                    case '440':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 5
                                      WHEN naturaleza = 2 THEN 6
                                      WHEN naturaleza = 3 THEN 7
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '450':


                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 4
                                      WHEN naturaleza = 2 THEN 5
                                      WHEN naturaleza = 3 THEN 6
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;


                    case '460':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 1460")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 3
                                      WHEN naturaleza = 2 THEN 4
                                      WHEN naturaleza = 3 THEN 5
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }
                        break;
                    case '470':
                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where('datos_militares.codigo_categoria', $categoria)
                            ->where('nomina.grado_militar', '=', $grado)
                            ->where('empleados.situacion', 'A')
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")

                            ->select(
                                'empleados.codigo_empleado',
                                'empleados.cedula as cedula',
                                'empleados.nombre1 as nombre1',
                                'empleados.apellido1 as apellido1',
                                'grados_militares.descripcion as grado_militar',
                                'grados_militares.grado_a_ascender as grado_ascender',
                                DB::raw("(SELECT IFNULL(SUM(
                                  CASE
                                      WHEN naturaleza = 1 THEN 2
                                      WHEN naturaleza = 2 THEN 3
                                      WHEN naturaleza = 3 THEN 4
                                      ELSE 0
                                  END
                              ), 0) FROM datos_boleta WHERE cedula = empleados.cedula) as punto"),
                                DB::raw("(SELECT 
                                  (consulta1.calificacion_total - punto) / consulta1.numero_calificaciones 
                                  FROM (
                                      SELECT cedula, SUM(notatotal) AS calificacion_total, COUNT(*) AS numero_calificaciones 
                                      FROM intelectuales 
                                      WHERE cedula = empleados.cedula
                                      GROUP BY cedula
                                  ) AS consulta1
                                  WHERE consulta1.cedula = empleados.cedula) AS demerito")
                            )
                            ->orderBy('empleados.cedula')
                            ->get();

                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return response()->json($empleados);
                        } else {

                            $mensaje = 'No se encontraron empleados.';
                            $response = [

                                'success' => false,
                                'message' => $mensaje
                            ];
                            return response()->json($response);
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);
                        }

                        break;

                    default:
                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                        // return response()->json("no funciona");
                        break;
                }



                break;

            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                // return response()->json("no funciona");
                break;
        }
    }
    public function ascreporte(Request $request)
    {

        ini_set('max_execution_time', 300);

        $periodo = $request->input('select_periodo');

        $categoria = $request->input('select_categoria');
        $tipo = $request->input('select_tipo');
        $ofi = $request->input('select_gradoOF');

        $tropap = $request->input('select_TP');
        $empleados = [];
        $datos = "";
        $complementoTitulo = '';
        $grado = '';

        switch ($tipo) {

            case 'excel':

                switch ($periodo) {

                    case 'julio':

                        switch ($categoria) {
                            case '4':
                                $complementoTitulo = "OFICIALES DE COMANDO EN EL GRADO DE ";
                                switch ($ofi) {
                                    case '015':
                                        $grado = 'MAYOR GENERAL';

                                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                                            ->where('datos_militares.codigo_categoria', $categoria)
                                            ->where('nomina.grado_militar', '=', $ofi)
                                            ->where('empleados.situacion', 'A')
                                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                                            ->where(function ($query) {
                                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                            })
                                            ->select(
                                                'empleados.codigo_empleado',
                                                'empleados.cedula as cedula',
                                                'empleados.nombre1 as nombre1',
                                                'empleados.apellido1 as apellido1',
                                                'grados_militares.descripcion as grado_militar',
                                                'grados_militares.grado_a_ascender as grado_ascender',
                                            )
                                            ->orderBy('empleados.cedula');
                                       return $empleados->get();

                                        break;

                                    case '020':
                                        $grado = 'GENERAL DIVISION';


                                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                                            ->where('datos_militares.codigo_categoria', $categoria)
                                            ->where('nomina.grado_militar', '=', $ofi)
                                            ->where('empleados.situacion', 'A')
                                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                                            ->where(function ($query) {
                                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                            })
                                            ->select(
                                                'empleados.codigo_empleado',
                                                'empleados.cedula as cedula',
                                                'empleados.nombre1 as nombre1',
                                                'empleados.apellido1 as apellido1',
                                                'grados_militares.descripcion as grado_militar',
                                                'grados_militares.grado_a_ascender as grado_ascender',
                                            )
                                            ->orderBy('empleados.cedula');
                                            return $empleados->get();
                                        break;

                                    case '030':

                                        $grado = 'GENERAL BRIGADA';

                                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                                            ->where('datos_militares.codigo_categoria', $categoria)
                                            ->where('nomina.grado_militar', '=', $ofi)
                                            ->where('empleados.situacion', 'A')
                                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                                            ->where(function ($query) {
                                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                            })
                                            ->select(
                                                'empleados.codigo_empleado',
                                                'empleados.cedula as cedula',
                                                'empleados.nombre1 as nombre1',
                                                'empleados.apellido1 as apellido1',
                                                'grados_militares.descripcion as grado_militar',
                                                'grados_militares.grado_a_ascender as grado_ascender',
                                            )
                                            ->orderBy('empleados.cedula');
                                            return $empleados->get();


                                        break;
                                    case '040':
                                        $grado = 'CORONEL';



                                        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                                            ->where('datos_militares.codigo_categoria', $categoria)
                                            ->where('nomina.grado_militar', '=', $ofi)
                                            ->where('empleados.situacion', 'A')
                                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
                                            ->where(function ($query) {
                                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                            })
                                            ->select(
                                                'empleados.codigo_empleado',
                                                'grados_militares.descripcion as grado_militar',
                                                'empleados.cedula as cedula',
                                                'empleados.nombre1 as nombre1',
                                                'empleados.apellido1 as apellido1',
                                                'grados_militares.descripcion as grado_militar',
                                                'grados_militares.grado_a_ascender as grado_ascender',
                                            )
                                            ->orderBy('empleados.cedula')
                                            ->get();

                                            return $empleados;


                                        break;
                                    case '050':


                                        $grado = 'TENIENTE CORONEL';


                                        break;
                                    case '060':
                                        $grado = 'MAYOR';



                                        break;
                                    case '070':
                                        $grado = 'CAPITAN';



                                        break;

                                    case '080':

                                        $grado = 'PRIMER TENIENTE';

                                        break;
                                    case '090':

                                        $grado = 'TENIENTE';

                                        break;
                                    default:
                                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                                        // return response()->json("no funciona");
                                        break;
                                }








                                break;

                            case '5':
                                $complementoTitulo = "OFICIALES DE TECNICOS EN EL GRADO DE ";
                                switch ($ofi) {
                                    case '015':
                                        $grado = 'MAYOR GENERAL';







                                        break;

                                    case '020':
                                        $grado = 'GENERAL DIVISION';


                                        break;

                                    case '030':

                                        $grado = 'GENERAL BRIGADA';


                                        break;
                                    case '040':
                                        $grado = 'CORONEL';




                                        break;
                                    case '050':


                                        $grado = 'TENIENTE CORONEL';


                                        break;
                                    case '060':
                                        $grado = 'MAYOR';



                                        break;
                                    case '070':
                                        $grado = 'CAPITAN';



                                        break;

                                    case '080':

                                        $grado = 'PRIMER TENIENTE';

                                        break;
                                    case '090':

                                        $grado = 'TENIENTE';

                                        break;
                                    default:
                                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                                        // return response()->json("no funciona");
                                        break;
                                }

                                break;

                            case '7':
                                $complementoTitulo = "OFICIALES DE TROPA EN EL GRADO DE ";
                                switch ($ofi) {
                                    case '015':
                                        $grado = 'MAYOR GENERAL';







                                        break;

                                    case '020':
                                        $grado = 'GENERAL DIVISION';


                                        break;

                                    case '030':

                                        $grado = 'GENERAL BRIGADA';


                                        break;
                                    case '040':
                                        $grado = 'CORONEL';




                                        break;
                                    case '050':


                                        $grado = 'TENIENTE CORONEL';


                                        break;
                                    case '060':
                                        $grado = 'MAYOR';



                                        break;
                                    case '070':
                                        $grado = 'CAPITAN';



                                        break;

                                    case '080':

                                        $grado = 'PRIMER TENIENTE';

                                        break;
                                    case '090':

                                        $grado = 'TENIENTE';

                                        break;
                                    default:
                                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                                        // return response()->json("no funciona");
                                        break;
                                }
                                break;
                            case '6':
                                $complementoTitulo = "OFICIALES ASIMILADOS TECNICOS EN EL GRADO DE ";
                                switch ($ofi) {
                                    case '015':
                                        $grado = 'MAYOR GENERAL';







                                        break;

                                    case '020':
                                        $grado = 'GENERAL DIVISION';


                                        break;

                                    case '030':

                                        $grado = 'GENERAL BRIGADA';


                                        break;
                                    case '040':
                                        $grado = 'CORONEL';




                                        break;
                                    case '050':


                                        $grado = 'TENIENTE CORONEL';


                                        break;
                                    case '060':
                                        $grado = 'MAYOR';



                                        break;
                                    case '070':
                                        $grado = 'CAPITAN';



                                        break;

                                    case '080':

                                        $grado = 'PRIMER TENIENTE';

                                        break;
                                    case '090':

                                        $grado = 'TENIENTE';

                                        break;
                                    default:
                                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                                        // return response()->json("no funciona");
                                        break;
                                }
                                break;
                            case '2':
                                $complementoTitulo = "OFICIALES ASIMILADOS EN EL GRADO DE ";
                                switch ($ofi) {
                                    case '015':
                                        $grado = 'MAYOR GENERAL';







                                        break;

                                    case '020':
                                        $grado = 'GENERAL DIVISION';


                                        break;

                                    case '030':

                                        $grado = 'GENERAL BRIGADA';


                                        break;
                                    case '040':
                                        $grado = 'CORONEL';




                                        break;
                                    case '050':


                                        $grado = 'TENIENTE CORONEL';


                                        break;
                                    case '060':
                                        $grado = 'MAYOR';



                                        break;
                                    case '070':
                                        $grado = 'CAPITAN';



                                        break;

                                    case '080':

                                        $grado = 'PRIMER TENIENTE';

                                        break;
                                    case '090':

                                        $grado = 'TENIENTE';

                                        break;
                                    default:
                                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                                        // return response()->json("no funciona");
                                        break;
                                }
                                break;


                            case '8':


                                $complementoTitulo = "TROPA PROFESIONAL EN LA JERARQUIA DE ";

                                switch ($tropap) {
                                    case '420':

                                        $grado = 'SARGENTO AYUDANTE';



                                        break;

                                    case '430':

                                        $grado = 'SARGENTO MAYOR DE PRIMERA';

                                        break;

                                    case '440':
                                        $grado = 'SARGENTO MAYOR DE SEGUNDA';
                                        break;
                                    case '450':
                                        $grado = 'SARGENTO MAYOR DE TERCERA';
                                        break;
                                    case '460':
                                        $grado = 'SARGENTO PRIMERO';
                                        break;
                                    case '470':
                                        $grado = 'SARGENTO SEGUNDO';
                                        break;


                                    default:
                                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                                        // return response()->json("no funciona");
                                        break;
                                }


                                break;


                            default:
                                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                                // return response()->json("no funciona");
                                break;
                        }

                        break;


                    case 'diciembre':

                        switch ($categoria) {

                            case 'ofitropa':
                                switch ($ofi) {
                                    case '015':
                                        $grado = 'MAYOR GENERAL';







                                        break;

                                    case '020':
                                        $grado = 'GENERAL DIVISION';


                                        break;

                                    case '030':

                                        $grado = 'GENERAL BRIGADA';


                                        break;
                                    case '040':
                                        $grado = 'CORONEL';




                                        break;
                                    case '050':


                                        $grado = 'TENIENTE CORONEL';


                                        break;
                                    case '060':
                                        $grado = 'MAYOR';



                                        break;
                                    case '070':
                                        $grado = 'CAPITAN';



                                        break;

                                    case '080':

                                        $grado = 'PRIMER TENIENTE';

                                        break;
                                    case '090':

                                        $grado = 'TENIENTE';

                                        break;
                                    default:
                                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                                        // return response()->json("no funciona");
                                        break;
                                }
                                break;
                            case 'asimiladotec':
                                switch ($ofi) {
                                    case '015':
                                        $grado = 'MAYOR GENERAL';







                                        break;

                                    case '020':
                                        $grado = 'GENERAL DIVISION';


                                        break;

                                    case '030':

                                        $grado = 'GENERAL BRIGADA';


                                        break;
                                    case '040':
                                        $grado = 'CORONEL';




                                        break;
                                    case '050':


                                        $grado = 'TENIENTE CORONEL';


                                        break;
                                    case '060':
                                        $grado = 'MAYOR';



                                        break;
                                    case '070':
                                        $grado = 'CAPITAN';



                                        break;

                                    case '080':

                                        $grado = 'PRIMER TENIENTE';

                                        break;
                                    case '090':

                                        $grado = 'TENIENTE';

                                        break;
                                    default:
                                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                                        // return response()->json("no funciona");
                                        break;
                                }
                                break;
                            case 'asimilado':
                                switch ($ofi) {
                                    case '015':
                                        $grado = 'MAYOR GENERAL';







                                        break;

                                    case '020':
                                        $grado = 'GENERAL DIVISION';


                                        break;

                                    case '030':

                                        $grado = 'GENERAL BRIGADA';


                                        break;
                                    case '040':
                                        $grado = 'CORONEL';




                                        break;
                                    case '050':


                                        $grado = 'TENIENTE CORONEL';


                                        break;
                                    case '060':
                                        $grado = 'MAYOR';



                                        break;
                                    case '070':
                                        $grado = 'CAPITAN';



                                        break;

                                    case '080':

                                        $grado = 'PRIMER TENIENTE';

                                        break;
                                    case '090':

                                        $grado = 'TENIENTE';

                                        break;
                                    default:
                                        // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                                        // return response()->json("no funciona");
                                        break;
                                }
                                break;

                            default:
                                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                                // return response()->json("no funciona");
                                break;
                        }



                        $titulo = 'REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO' . $complementoTitulo . " " . $grado;

                        $nombre_archivo = sprintf('ReportePersonalMilitarTentativoAscenso %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
                        $data = compact('titulo', 'datos');

                        return Excel::download(new PersonalMilitarExport($data), $nombre_archivo);
                } //

                break;

            case 'pdf':





                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores

                // return response()->json("no funciona");
                break;
        }
    }

    public function ascreporter(Request $request)
    {

        ini_set('max_execution_time', 300);

        $periodo = $request->input('select_periodo');

        $categoria = $request->input('select_categoria');

        $ofi = $request->input('select_gradoOF');

        $tropap = $request->input('select_TP');
        $empleados = [];
        $datos = "";









        $complementoTitulo = "OFICIALES DE COMANDO EN EL GRADO DE ";

        $grado = 'MAYOR GENERAL';

        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
            ->where('datos_militares.codigo_categoria', $categoria)
            ->where('nomina.grado_militar', '=', $ofi)
            ->where('empleados.situacion', 'A')
            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
            ->where(function ($query) {
                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
            })
            ->select(
                'empleados.codigo_empleado',
                'empleados.cedula as cedula',
                'empleados.nombre1 as nombre1',
                'empleados.apellido1 as apellido1',
                'grados_militares.descripcion as grado_militar',
                'grados_militares.grado_a_ascender as grado_ascender',
            )
            ->orderBy('empleados.cedula');
        $datos = $empleados->get();
    }





    public function ascreporter2(Request $request)
    {
        ini_set('max_execution_time', 600);

        $periodo = $request->input('select_periodo');
        $categoria = $request->input('select_categoria');
        $ofi = $request->input('select_gradoOF');
        $tropap = $request->input('select_TP');
        // $empleados = [];
        $empleados = collect();
        $datos = "";
        $coma = 4;
        $complementoTitulo = "OFICIALES DE COMANDO EN EL GRADO DE ";
        $grado = 'MAYOR GENERAL';

        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
            ->where('datos_militares.codigo_categoria', $coma)
            ->where('nomina.grado_militar', '=', $ofi)
            ->where('empleados.situacion', 'A')
            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
            ->whereRaw("DATEDIFF(NOW(), datos_militares.fecha_ultimo_ascenso) > 730")
            ->where(function ($query) {
                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
            })
            ->select(
                'empleados.codigo_empleado',
                'empleados.cedula as cedula',
                'empleados.nombre1 as nombre1',
                'empleados.apellido1 as apellido1',
                'grados_militares.descripcion as grado_militar',
                'grados_militares.grado_a_ascender as grado_ascender',
            )
            ->orderBy('empleados.cedula')
            ->get();
       

        // $empleados = $empleados->toArray(); // convertir a array

        return $empleados; // Devuelve solo el título


    }



    public function descargarEmpleados(Request $request)
    {
        $empleados = $this->ascreporte($request);
        
        $nombre_archivo = sprintf('ReportePersonalMilitarTentativoAscenso %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
        $titulo = 'REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO ';

        return Excel::download(new juntapExport($empleados, $titulo), $nombre_archivo);
    }
    /*
     return dd( $empleados);


           $callback = function($excel) use ($empleados) {
                $excel->sheet('nombre_hoja', function($sheet) use ($empleados) {
                    $sheet->fromArray($empleados->toArray());
                });
            };
        
            $fileName = 'nombre_archivo.xlsx';
            return Excel::download($callback, $fileName);
            
            


    
$callback = function ($excel) use ($empleados) {
            $excel->sheet('nombre_hojas', function ($sheet) use ($empleados) {
                $sheet->fromArray($empleados->toArray());
            });
        };

        $fileName = 'nombre_archivos.xlsx';
     
        Excel::store($callback, $fileName);

        return response()->download(storage_path('app/' . $fileName));*/

    //  return $datatable = Datatables::of($empleados)->make(true);
    //$datatable = Datatables::of($empleados)->make(true);
    // return $datatable->toJson();
    // return view('juntap.ascenso.julio', compact('empleados'));



    /*
    Excel::create('nombre_archivo', function($excel) use ($datos) {
        $excel->sheet('nombre_hoja', function($sheet) use ($datos) {
            $sheet->fromArray($datos->toArray());
        });
        })->export('xlsx');
        return Excel::create('nombre_archivo', function($excel) use ($datos) {
            $excel->sheet('nombre_hoja', function($sheet) use ($datos) {
                $sheet->fromArray($datos->toArray());
            });
        })->download('xlsx');
        return Excel::download('nombre_archivo.xlsx', function($excel) use ($datos) {
            $excel->sheet('nombre_hoja', function($sheet) use ($datos) {
                $sheet->fromArray($datos->toArray());
            });
        });
        $callback = function($excel) use ($datos) {
            $excel->sheet('nombre_hoja', function($sheet) use ($datos) {
                $sheet->fromArray($datos->toArray());
            });
        };
        
        return Excel::download($callback, 'nombre_archivo.xlsx');*/
    /*
    $titulo = 'REPORTE DE PERSONAL MILITAR '. $complementoTitulo;
    
    $nombre_archivo = sprintf('ReportePersonalMilitar %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
    $data = compact('titulo', 'datos');
    
    return Excel::download(new PersonalMilitarExport($data), $nombre_archivo);*/
    //$nombre=Nombres::where("nombre","like",$request->select."%")->get();


    //return view('juntap.ascenso.julio'); 



    /*    
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






    select
    $valorSeleccionado = $request->input('valorSeleccionado');

// Aquí puedes hacer lo que necesites con el valor seleccionado, por ejemplo:
switch ($valorSeleccionado) {
    case 1:
        $resultado = 'Has seleccionado la opción 1';
        break;
    case 2:
        $resultado = 'Has seleccionado la opción 2';
        break;
    case 3:
        $resultado = 'Has seleccionado la opción 3';
        break;
    default:
        $resultado = 'No se ha seleccionado ninguna opción';
        break;
}

return $resultado;
      */
}



















@extends('layouts.user_type.auth')
@section('title', 'Personal Militar No Profesional')
@section('content')
@push('plugins-css')
<link href="{{ asset('vendor/datatables/dataTables.checkboxes.css') }}" rel="stylesheet">
<style>
    label.error {
        color: red;
        font-size: 1rem;
        display: block;
        margin-top: 5px;
    }

    input.error {
        border: 1px dashed red;
        font-weight: 300;
        color: red;
    }
</style>
@endpush
@if (count($errors) > 0)
<div class="alert alert-danger mx-4" role="alert">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if ($message = Session::get('success'))
<div class="alert alert-success mx-4" role="alert">
    <span class="text-white">{{ $message }}</span>
</div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Personal a Graduarse por Categoria</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('sireh.personal-militar-noprof.index') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="card-body">
                            <div class="card card-body border card-plain border-radius-lg bg-gray-100">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                                                Oficiales de Comando
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                               <form name="form_comando"  id="form_comando" class="form-graduar"
                                                    
                                                    >
                                                   
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-3">
                                                          
                                                            <div class="form-group">
                                                                <h6 for="Grado">Grado: <small></small></h6>
                                                                <select class="form-select" name="select_comando1" id="select_comando1"aria-label="Default select example">
                                                                    <option selected>Seleccionar...</option>
                                                                    <option value="15">MY</option>
                                                                    <option value="020">GD</option>
                                                                    <option value="030">GB</option>
                                                                    <option value="040">CNEL</option>
                                                                    <option value="050">TCNEL</option>
                                                                    <option value="060">MAY</option>
                                                                    <option value="070">CAP</option>
                                                                    <option value="080">PTTE</option>
                                                                    <option value="090">TTE</option>
                                                                  </select>  </div>
                                                        </div>
                                                        <div class="col-3">
                                                       
                                                            <div class="form-group">
                                                                <input type="hidden" name="categoria" value="1">
                                                        <input type="hidden" id="tabla" value="1">   

                                                                <button type="submit" class="btn btn-primary btn-sm mb-0 ">Ejecutar</button>
                                                              </form>
                                                                {{--

                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                        
                                                        --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_resuelto">Reporte Ascenso: <small></small></h6>
                                                                <button name="reporte" id="reporte"   type="button" class="btn btn-outline-primary" >Reporte</button>
                                                            </div>
                                                        </div>
                                                        
                                                    
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-graduar">Graduar</button>
                                                        </div>
                                                        
                                                    </div>

 
                                                 
                                                
                                               
                                                <table id="tabla-empleados" class="table table-sm table-bordered table-hover w-100 nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Código de empleado</th>
                                                            <th>Cédula</th>
                                                            <th>Nombre</th>
                                                            <th>Grado militar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>

                                              
                                          
                                         
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                Oficiales Técnicos Medicina 
                                            </button>
                                        </h2>
                                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="graduar"  id="graduar_2" class="form-graduar"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.graduar')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="numero_resuelto">Numero de Resuelto:</h6>
                                                                <input type="text" class="form-control" name="numero_resuelto" id="numero_resuelto" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_resuelto">Fecha de Resuelto: <small></small></h6>
                                                                <input name="fecha_resuelto" id="fecha_resuelto" type="date" class="form-control fecha" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="categoria" value="tecnico">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-graduar">Graduar</button>
                                                        </div>
                                                        <input type="hidden" id="tabla" value="2">
                                                    </div>
                                                    <table id="table2" class="table table-sm table-bordered table-hover w-100 nowrap" >
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Cedula</th>
                                                                <th>Jerarquia</th>
                                                                <th>Nombres y Apellidos </th>
                                                                <th>Nuevo Tipo Empleado</th>
                                                                <th>Grado a Ascender</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </form>        
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                Oficiales Técnicos de Salud
                                            </button>
                                        </h2>
                                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="graduar"  id="graduar_3" class="form-graduar"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.graduar')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="numero_resuelto">Numero de Resuelto:</h6>
                                                                <input type="text" class="form-control" name="numero_resuelto" id="numero_resuelto" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_resuelto">Fecha de Resuelto: <small></small></h6>
                                                                <input name="fecha_resuelto" id="fecha_resuelto" type="date" class="form-control fecha" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="categoria" value="tecnico">
                                                    </form>
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-graduar">Graduar</button>
                                                        </div>
                                                        <input type="hidden" id="tabla" value="3">
                                                    </div>
                                                
                                                    <table id="table3" class="table table-sm table-bordered table-hover w-100 nowrap" >
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Cedula</th>
                                                                <th>Jerarquia</th>
                                                                <th>Nombres y Apellidos </th>
                                                                <th>Nuevo Tipo Empleado</th>
                                                                <th>Grado a Ascender</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingFour">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                                Oficiales Técnicos
                                            </button>
                                        </h2>
                                        <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="graduar"  id="graduar_4" class="form-graduar"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.graduar')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="numero_resuelto">Numero de Resuelto:</h6>
                                                                <input type="text" class="form-control" name="numero_resuelto" id="numero_resuelto" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_resuelto">Fecha de Resuelto: <small></small></h6>
                                                                <input name="fecha_resuelto" id="fecha_resuelto" type="date" class="form-control fecha" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="categoria" value="tecnico">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-graduar">Graduar</button>
                                                        </div>
                                                        <input type="hidden" id="tabla" value="4">
                                                    </div>
                                                    <table id="table4" class="table table-sm table-bordered table-hover w-100 nowrap" >
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Cedula</th>
                                                                <th>Jerarquia</th>
                                                                <th>Nombres y Apellidos </th>
                                                                <th>Nuevo Tipo Empleado</th>
                                                                <th>Grado a Ascender</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingFive">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                                                Oficiales de Tropa
                                            </button>
                                        </h2>
                                        <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="graduar"  id="graduar_5" class="form-graduar"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.graduar')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="numero_resuelto">Numero de Resuelto:</h6>
                                                                <input type="text" class="form-control" name="numero_resuelto" id="numero_resuelto" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_resuelto">Fecha de Resuelto: <small></small></h6>
                                                                <input name="fecha_resuelto" id="fecha_resuelto" type="date" class="form-control fecha" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="categoria" value="tropa">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-graduar">Graduar</button>
                                                        </div>
                                                        <input type="hidden" id="tabla" value="5">
                                                    </div>
                                                    <table id="table5" class="table table-sm table-bordered table-hover w-100 nowrap" >
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Cedula</th>
                                                                <th>Jerarquia</th>
                                                                <th>Nombres y Apellidos </th>
                                                                <th>Nuevo Tipo Empleado</th>
                                                                <th>Grado a Ascender</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingSix">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                                                Oficiales Asimilados
                                            </button>
                                        </h2>
                                        <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="graduar"  id="graduar_6" class="form-graduar"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.graduar')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="numero_resuelto">Numero de Resuelto:</h6>
                                                                <input type="text" class="form-control" name="numero_resuelto" id="numero_resuelto" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_resuelto">Fecha de Resuelto: <small></small></h6>
                                                                <input name="fecha_resuelto" id="fecha_resuelto" type="date" class="form-control fecha" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="categoria" value="asimilado">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-graduar">Graduar</button>
                                                        </div>
                                                        <input type="hidden" id="tabla" value="6">
                                                    </div>
                                                    <table id="table6" class="table table-sm table-bordered table-hover w-100 nowrap" >
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Cedula</th>
                                                                <th>Jerarquia</th>
                                                                <th>Nombres y Apellidos </th>
                                                                <th>Nuevo Tipo Empleado</th>
                                                                <th>Grado a Ascender</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingSeven">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                                                Tropa Profesional
                                            </button>
                                        </h2>
                                        <div id="flush-collapseSeven" class="accordion-collapse collapse" aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="graduar"  id="graduar_7" class="form-graduar"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.graduar')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="numero_resuelto">Numero de Resuelto:</h6>
                                                                <input type="text" class="form-control" name="numero_resuelto" id="numero_resuelto" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_resuelto">Fecha de Resuelto: <small></small></h6>
                                                                <input name="fecha_resuelto" id="fecha_resuelto" type="date" class="form-control fecha" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="categoria" value="trop_prof">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-graduar">Graduar</button>
                                                        </div>
                                                        <input type="hidden" id="tabla" value="7">
                                                    </div>
                                                    <table id="table7" class="table table-sm table-bordered table-hover w-100 nowrap" >
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Cedula</th>
                                                                <th>Jerarquia</th>
                                                                <th>Nombres y Apellidos </th>
                                                                <th>Nuevo Tipo Empleado</th>
                                                                <th>Grado a Ascender</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('plugins-js')
    <script src="{{ asset('vendor/datatables/dataTables.checkboxes.min.js') }}" ></script>
    
    
@endpush
@section('scripts')
@parent



<script >
    
    $(document).ready(function() {
        $('#form_comando').submit(function(event) {
            event.preventDefault();
            var select_comando1 = $('select[name="select_comando1"]').val();
            var categoria= $('input[name="categoria"]').val();
            $.ajax({
                type: 'GET',
                url: '{{ route('api.juntap.ascenso.julio') }}',
                data: {select_comando1: select_comando1, categoria: categoria},
                dataType: 'json',
                success: function(registros) {
                    var registros = Object.values(registros);
                    $('#tabla_empleados tbody').empty();
                    registros.forEach(function(registro) {
                        var row = '<tr>' +
                                  '<td>' + registro.codigo_empleado + '</td>' +
                                  '<td>' + registro.cedula + '</td>' +
                                  '<td>' + registro.nombre1 + '</td>' +
                                  '<td>' + registro.apellido1 + '</td>' +
                                  '<td>' + registro.grado_militar + '</td>' +
                                  '</tr>';
                        $('#tabla_empleados tbody').append(row);
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });

</script>



@endsection