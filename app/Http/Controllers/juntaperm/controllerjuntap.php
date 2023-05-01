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
use App\Models\FuncionTripulante;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Movimientos;

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
    public function indexPersonalMilitarasc()
    {
        $funcionEmpleado = FuncionTripulante::get();
        return view(
            'juntap.personalm.index',
            compact(
                'funcionEmpleado'
            )
        );
    }
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



    public function ofic($categoria, $ofi)
    {
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
                    ->orderBy('empleados.cedula')
                    ->get();

                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }

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
                    ->orderBy('empleados.cedula')
                    ->get();
                //  return $empleados->get();
                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }

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
                    ->orderBy('empleados.cedula')
                    ->get();
                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }



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


                // dd($categoria);
                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                    // dd($empleados);

                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }



                break;
            case '050':


                $grado = 'TENIENTE CORONEL';
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
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }


                break;
            case '060':
                $grado = 'MAYOR';

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
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }
                break;
            case '070':
                $grado = 'CAPITAN';

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
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }

                break;

            case '080':

                $grado = 'PRIMER TENIENTE';

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
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }
                break;
            case '090':

                $grado = 'TENIENTE';
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
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }
                break;
            default:
                $empleados = false;

                return  $empleados;
                break;
        }
    }
    public function ofic_dic($categoria, $ofi)
    {
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
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }

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
                //  return $empleados->get();
                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }

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
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }



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


                // dd($categoria);
                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                    // dd($empleados);

                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }



                break;
            case '050':


                $grado = 'TENIENTE CORONEL';
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
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }


                break;
            case '060':
                $grado = 'MAYOR';

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
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }
                break;
            case '070':
                $grado = 'CAPITAN';

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
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }

                break;

            case '080':

                $grado = 'PRIMER TENIENTE';

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
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }
                break;
            case '090':

                $grado = 'TENIENTE';
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
                    return $empleados;
                } else {
                    $empleados = false;



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                }
                break;
            default:
                $empleados = false;

                return  $empleados;
                break;
        }
    }
    public function ascreporte($periodo, $categoria, $ofi, $tropap)
    {

        ini_set('max_execution_time', 300);


        $empleados = [];
        $datos = "";
        $complementoTitulo = '';
        $grado = '';



        switch ($periodo) {

            case 'julio':

                switch ($categoria) {
                    case '4':
                        $complementoTitulo = "OFICIALES DE COMANDO EN EL GRADO DE ";
                        /*  switch ($ofi) {
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
                                    ->orderBy('empleados.cedula')
                                    ->get();

                                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }

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
                                    ->orderBy('empleados.cedula')
                                    ->get();
                                //  return $empleados->get();
                                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }

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
                                    ->orderBy('empleados.cedula')
                                    ->get();
                                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }



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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }



                                break;
                            case '050':


                                $grado = 'TENIENTE CORONEL';
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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }


                                break;
                            case '060':
                                $grado = 'MAYOR';

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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                            case '070':
                                $grado = 'CAPITAN';

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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }

                                break;

                            case '080':

                                $grado = 'PRIMER TENIENTE';

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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                            case '090':

                                $grado = 'TENIENTE';
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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                            default:
                                $empleados = false;

                                return  $empleados;
                                break;
                        }
 */

                        return $this->ofic($categoria, $ofi);
                        break;

                    case '5':
                        $complementoTitulo = "OFICIALES DE TECNICOS EN EL GRADO DE ";
                        /*
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
*/


                        return $this->ofic($categoria, $ofi);

                        break;

                    case '7':

                        $complementoTitulo = "OFICIALES DE TROPA EN EL GRADO DE ";
                        /*
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
*/
                        return $this->ofic($categoria, $ofi);

                        break;
                    case '6':
                        $complementoTitulo = "OFICIALES ASIMILADOS TECNICOS EN EL GRADO DE ";
                        /*
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
                        }*/

                        return $this->ofic($categoria, $ofi);
                        break;
                    case '2':
                        $complementoTitulo = "OFICIALES ASIMILADOS EN EL GRADO DE ";
                        /*
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
                        }*/
                        return $this->ofic($categoria, $ofi);
                        break;








                    case '8':


                        $complementoTitulo = "TROPA PROFESIONAL EN LA JERARQUIA DE ";

                        switch ($tropap) {
                            case '420':

                                $grado = 'SARGENTO AYUDANTE';


                                $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                                    ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                                    ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                                    ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                                    ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                                    ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                                    ->where('datos_militares.codigo_categoria', $categoria)
                                    ->where('nomina.grado_militar', '=', $tropap)
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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;

                            case '430':

                                $grado = 'SARGENTO MAYOR DE PRIMERA';
                                $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                                    ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                                    ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                                    ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                                    ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                                    ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                                    ->where('datos_militares.codigo_categoria', $categoria)
                                    ->where('nomina.grado_militar', '=', $tropap)
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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;

                            case '440':
                                $grado = 'SARGENTO MAYOR DE SEGUNDA';

                                $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                                    ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                                    ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                                    ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                                    ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                                    ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                                    ->where('datos_militares.codigo_categoria', $categoria)
                                    ->where('nomina.grado_militar', '=', $tropap)
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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                            case '450':
                                $grado = 'SARGENTO MAYOR DE TERCERA';
                                $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                                    ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                                    ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                                    ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                                    ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                                    ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                                    ->where('datos_militares.codigo_categoria', $categoria)
                                    ->where('nomina.grado_militar', '=', $tropap)
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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                            case '460':


                                $grado = 'SARGENTO PRIMERO';

                                $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                                    ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                                    ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                                    ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                                    ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                                    ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                                    ->where('datos_militares.codigo_categoria', $categoria)
                                    ->where('nomina.grado_militar', '=', $tropap)
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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                            case '470':
                                $grado = 'SARGENTO SEGUNDO';
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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;


                            default:
                                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                        }


                        break;


                    default:
                        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                            return $empleados;
                        } else {
                            $empleados = false;



                            return  $empleados;
                            //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                        }
                        break;
                }

                break;


            case 'diciembre':

                switch ($categoria) {

                    case '7':

                        /*
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
                                    ->orderBy('empleados.cedula')
                                    ->get();

                                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }

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
                                    ->orderBy('empleados.cedula')
                                    ->get();
                                //  return $empleados->get();
                                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }

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
                                    ->orderBy('empleados.cedula')
                                    ->get();
                                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }



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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }



                                break;
                            case '050':


                                $grado = 'TENIENTE CORONEL';
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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }


                                break;
                            case '060':
                                $grado = 'MAYOR';

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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                            case '070':
                                $grado = 'CAPITAN';

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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }

                                break;

                            case '080':

                                $grado = 'PRIMER TENIENTE';

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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                            case '090':

                                $grado = 'TENIENTE';
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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                            default:
                                $empleados = false;

                                return  $empleados;
                                break;
                        }*/

                        return $this->ofic_dic($categoria, $ofi);
                        break;
                    case '6':

                        /*
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
                                    ->orderBy('empleados.cedula')
                                    ->get();

                                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }

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
                                    ->orderBy('empleados.cedula')
                                    ->get();
                                //  return $empleados->get();
                                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }

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
                                    ->orderBy('empleados.cedula')
                                    ->get();
                                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }



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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }



                                break;
                            case '050':


                                $grado = 'TENIENTE CORONEL';
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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }


                                break;
                            case '060':
                                $grado = 'MAYOR';

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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                            case '070':
                                $grado = 'CAPITAN';

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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }

                                break;

                            case '080':

                                $grado = 'PRIMER TENIENTE';

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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                            case '090':

                                $grado = 'TENIENTE';
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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                            default:
                                $empleados = false;

                                return  $empleados;
                                break;
                        }*/
                        return $this->ofic_dic($categoria, $ofi);
                        break;
                    case '2':
                        /*
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
                                    ->orderBy('empleados.cedula')
                                    ->get();

                                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }

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
                                    ->orderBy('empleados.cedula')
                                    ->get();
                                //  return $empleados->get();
                                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }

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
                                    ->orderBy('empleados.cedula')
                                    ->get();
                                if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }



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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }



                                break;
                            case '050':


                                $grado = 'TENIENTE CORONEL';
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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }


                                break;
                            case '060':
                                $grado = 'MAYOR';

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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                            case '070':
                                $grado = 'CAPITAN';

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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }

                                break;

                            case '080':

                                $grado = 'PRIMER TENIENTE';

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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                            case '090':

                                $grado = 'TENIENTE';
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
                                    return $empleados;
                                } else {
                                    $empleados = false;



                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                                }
                                break;
                            default:
                                $empleados = false;

                                return  $empleados;
                                break;
                        }*/
                        return $this->ofic_dic($categoria, $ofi);
                        break;

                    default:
                        $empleados = false;

                        return  $empleados;
                        break;
                }
        } //





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
        $ofi = $request->input('select_gradoOF');
        $coma = 4;
        /*
        $periodo = $request->input('select_periodo');
        $categoria = $request->input('select_categoria');
       
        $tropap = $request->input('select_TP');
        // $empleados = [];
        $empleados = collect();
        $datos = "";
        
        $complementoTitulo = "OFICIALES DE COMANDO EN EL GRADO DE ";
        $grado = 'MAYOR GENERAL';
     */
        $categoria = $request->input('select_categoria');

        $ofi = $request->input('select_gradoOF');
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

        if (isset($empleados) && is_object($empleados) && $empleados->count() > 0) {


            $view = view('juntap.reportes.reporteascPDF', compact('empleados'))->render();

            // Crear una instancia de Dompdf con opciones
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');
            $pdf = new Dompdf($pdfOptions);

            // Cargar el contenido HTML al PDF
            $pdf->loadHTML($view);

            // Generar el PDF
            $pdf->render();


            $fileName = 'ReportePersonalMilitarTentativoAscenso' . date('Y-m-d_H-i-s') . '.pdf';


            // Descargar el PDF
            return $pdf->stream($fileName);
            //return $pdf->stream();

            /*
            $view = view('reporte_pdf', compact('empleados'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream();
            
            
             $pdf = new Dompdf();
                 $options = new Options();
                  $options->set('isRemoteEnabled', true); // Habilitar acceso a archivos remotos (opcional)
                 $pdf->setOptions($options);
                  $view = view('reporte_pdf', compact('empleados'))->render();
             $pdf->loadHTML($view);
                return $pdf->stream(); */
        } else {
            $empleados = false;



            return  $empleados;




            //return response()->json(['message' => 'No se encontraron empleados.'], 404);

        }
    }

    public function personalMilitarasc(Request $request)
    {
        $empleados = Empleado::where('empleados.situacion', 'A');
        $empleados->join('nomina', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado');
        $empleados->join('tipos_empleados', 'tipos_empleados.tipo_emp', '=', 'nomina.tipo_emp');
        $empleados->join('ubicaciones', 'ubicaciones.codigo_ubicacion', '=', 'nomina.codigo_ubicacion');
        $empleados->join('grados_militares', 'grados_militares.codigo_grado', '=', 'nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP']);
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
        $datatable = Datatables::of($empleados)
            ->addColumn('actions', 'juntap.personalm._actions')
            ->rawColumns(['actions']);


        return $datatable->make(true);
    }
    /*
    public function ascenderPersonalMilitar(Request $request)
    {
        $empleado = Empleado::where('id', $request->id)->first();
        $nomina = Nomina::where('codigo_empleado', $empleado->codigo_empleado)->first();

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
    }*/

    public function ascDataPersonalMilitar(Request $request)
    {

        $data = Nomina::where('codigo_empleado', $request->id)->get();

        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
           // ->where('nomina.codigo_empleado', '=',$data->codigo_empleado)
           ->whereIn('nomina.codigo_empleado', $data->pluck('codigo_empleado'))
            ->where('empleados.situacion', 'A')
            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])


            ->select(
                'empleados.codigo_empleado',
                'empleados.cedula as cedula',
                'empleados.nombre1 as nombre1',
                'empleados.apellido1 as apellido1',
                'grados_militares.descripcion as grado_militar',
                'grados_militares.grado_a_ascender as grado_ascender',

            )

            //->get();
            ->first();
        return response()->json(
            [
                'success' => true,
                'message' => 'Data',
                'data' => $data,
                'haveFuncion' => $empleados
                //    'funcionTripulante' => $funcionEmpleado,
                // 'idsFuncion' => $idsFuncion
            ]
        );

        /*
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


*/
    }




    public function descargarEmpleados(Request $request)
    {

        //$mensaje = null;

        $periodo = $request->input('periodo');
        $categoria = $request->input('select_categoria');
        $ofi = $request->input('select_gradoOF');
        $tropap = $request->input('select_TP');
        $tipo = $request->input('select_tipo');
        // $empleados = [];
        $empleados = collect();



        // $empleados = $this->ascreporter2($request);
        $empleados = $this->ascreporte($periodo, $categoria, $ofi, $tropap);
        // $empleados = $this->ascreporter2($coma, $ofi);
        if ($empleados) {

            // dd($tipo);

            if ($tipo == "excel") {




                $nombre_archivo = sprintf('ReportePersonalMilitarTentativoAscenso %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));

                $titulo = 'REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO ';

                // $file= Excel::download(new juntapExport($empleados, $titulo), $nombre_archivo);

                return Excel::download(new juntapExport($empleados, $titulo), $nombre_archivo);
                //return $mensaje;
                // Retorna un mensaje JSON si no hay resultados

            } else {

                // dd($empleados);
                $view = view('juntap.reportes.reporteascPDF', compact('empleados'))->render();

                // Crear una instancia de Dompdf con opciones
                $pdfOptions = new Options();
                $pdfOptions->set('defaultFont', 'Arial');
                $pdf = new Dompdf($pdfOptions);

                // Cargar el contenido HTML al PDF
                $pdf->loadHTML($view);

                // Generar el PDF
                $pdf->render();


                $fileName = 'ReportePersonalMilitarTentativoAscenso' . date('Y-m-d_H-i-s') . '.pdf';


                // Descargar el PDF
                return $pdf->stream($fileName);
            }
        } else {

            // $mensaje = 'No Se Encontraron Registros.';
            //dd($mensaje);
            //return redirect()->back()->with('mensaje', $mensaje);
            $mensaje = "No Se Encontraron Registros.";
            // return view('juntap.reportes.reporteascenso')->with('mensaje', $mensaje);
            // return echo "<script>mostrarMensaje('$mensaje');</script>";
            return view('juntap.reportes.reporteascenso', ['mensaje' => $mensaje]);
        }
    }

    /*

$nombre_archivo = sprintf('ReportePersonalMilitarTentativoAscenso %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
            $titulo = 'REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO ';
            $path = storage_path('app/public/') . $nombre_archivo;
            Excel::store(new juntapExport($empleados, $titulo), $path);
            $url = asset('storage/' . $nombre_archivo);
    
            $response = [
                'success' => true,
                'url' => $url
            ];
            return response()->json($response);





 $nombre_archivo = sprintf('ReportePersonalMilitarTentativoAscenso %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));

            $titulo = 'REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO ';
            
            return Excel::download(new juntapExport($empleados, $titulo), $nombre_archivo);

$nombre_archivo = sprintf('ReportePersonalMilitarTentativoAscenso %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
            $titulo = 'REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO ';

            $excel = new juntapExport($empleados, $titulo);
            $excel_file_path = storage_path('app/' . $nombre_archivo);
            $excel->storeAs('public', $nombre_archivo);
            $url = url('storage/' . $nombre_archivo);

            $response = [
                'success' => true,
                'url' => $url
            ];
            return response()->json($response);


            $titulo = 'REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO ';
        $nombre_archivo = sprintf('ReportePersonalMilitarTentativoAscenso %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
        $excel = Excel::download(new juntapExport($empleados, $titulo), $nombre_archivo);

        return response()->json([
            'success' => true,
            'url' => $excel->getFileUrl(),
        ]);
            
        $nombre_archivo = sprintf('ReportePersonalMilitarTentativoAscenso %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
        $titulo = 'REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO ';

        $excel= Excel::download(new juntapExport($empleados, $titulo), $nombre_archivo);
        return response($excel, 200)
        ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
        ->header('Content-Disposition', 'attachment;filename="' . $nombre_archivo . '"');

*/









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







   if ($empleados == false) {

            $mensaje = 'No Se Encontraron Registros.';
            $response = [

                'success' => false,
                'message' => $mensaje
            ];
            return response()->json($response);
            // Retorna un mensaje JSON si no hay resultados
        } else {
            $nombre_archivo = sprintf('ReportePersonalMilitarTentativoAscenso %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
            $titulo = 'REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO ';
            $headers = array(
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            );
        
            return response()->streamDownload(function() use ($empleados, $titulo) {
                $writer = \Maatwebsite\Excel\Facades\Excel::create($titulo, function($excel) use ($empleados) {
                    $excel->sheet('Datos', function($sheet) use ($empleados) {
                        $sheet->fromArray($empleados);
                    });
                })->store('xlsx', false, true);
        
                readfile($writer);
            }, $nombre_archivo, $headers);
           

            
        }
      */
}
