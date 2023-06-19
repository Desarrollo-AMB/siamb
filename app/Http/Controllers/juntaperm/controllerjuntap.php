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
use App\Models\DatosMilitares;
use App\Models\FuncionTripulante;
use Dompdf\Dompdf;
use Dompdf\Options;
use Barryvdh\DomPDF\PDF;
use App\Models\Movimientos;

use App\Models\User;
use App\Models\EmpleadosOtroComponente;
use App\Models\TiposEmpleado;
use App\Models\Estados;
use App\Models\Ubicaciones;
use App\Models\UbicacionDetallada;
use App\Models\Nivel;
use App\Models\Cargos;
use App\Models\Universidades;
use App\Models\Profesion;
use App\Models\EspecialidadesMilitares;
use App\Models\EstudiosRealizados;
use App\Models\Ciudades;
use App\Models\CategoriasMilitares;
use App\Models\PromocionesMilitares;
use App\Models\Cursos;
use App\Models\CursosRealizados;
use App\Models\IntelectualesCivil;
use App\Models\TipoDeBaja;
use App\Models\Egresos;
use App\Models\EmpleadoFuncion;
use App\Models\HistoricoAscensos;
use App\Exports\PersonalMilitarExport;
use App\Exports\PersonalMilitarEnFormacionExport;
use Intervention\Image\Facades\Image;
use Exception;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\PdfMerger;
use DateTime;


class controllerjuntap extends Controller
{


        /**
     * Recupera y devuelve una vista para la página 'juntap.ascenso.index'.
     *
     * @return Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function juntap()
    {
        return view('juntap.ascenso.index');
    } //
    /**
     * Muestra la vista del índice de informes.
     *
     * @return \Illuminate\Contracts\View\View
     */

    public function indexreporte()
    {
        return view('juntap.reportes.index');
    } //

/**
 * Muestra la vista para el informe 'reporteascenso'.
 *
 * @return \Illuminate\Contracts\View\View
 */


    public function reportenasc()
    {
        return view('juntap.reportes.reporteascenso');
    } 

/**
 * Devuelve una vista para la página 'julio' de la sección 'ascenso' del proyecto 'juntap'.
 *
 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
 */

    public function ascjulio()
    {
        return view('juntap.ascenso.julio');
    } 



/**
 * Recupera la vista diciembre para la página de ascenso.
 *
 * @return Illuminate\Contracts\View\View
 */


    public function ascdiciembre()
    {
        return view('juntap.ascenso.diciembre');
    } //
    /**
* Recupera y devuelve la vista para la página "juntap.ascenso.index".
*
* @return Illuminate\Contracts\View\View
*/

    public function asccategoria()
    {
        return view('juntap.ascenso.index');
    } //
    public function asc_fichas()
    {
        return view('juntap.personalm.index_fichas');
    } 
    
    public function asc_select_fichas(Request $request)
    {

        ini_set('max_execution_time', 300);

        $periodo = $request->input('select_periodo');

        $categoria = $request->input('select_categoria');

        $empleados = [];


        switch ($periodo) {
            case 'julio':

                switch ($categoria) {
                    case 'comando':
                        return view('juntap.personalm.julio.comando');
                        break;

                    case 'tecnico':
                        return view('juntap.personalm.julio.tecnico');
                        break;
                    case 'ofitropa':
                        return view('juntap.personalm.julio.ofitropa');
                        break;
                    case 'asimiladotec':
                        return view('juntap.personalm.julio.asitecnico');
                        break;
                    case 'asimilado':
                        return view('juntap.personalm.julio.asimilado');
                        break;
                    case 'tropaprofesional':
                        return view('juntap.personalm.julio.tropap');
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
                        return view('juntap.personalm.diciembre.ofitropa');
                        break;
                    case 'asimiladotec':
                        return view('juntap.personalm.diciembre.asitecnico');
                        break;
                    case 'asimilado':
                        return view('juntap.personalm.diciembre.asimilado');
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
    
    
    
    //
   /**
 * Muestra la página de índice del personal militarasc.
 *
* @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
 */

   
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
 
/**
 * Muestra la página de índice para el personal civil.
 *
 * @return Illuminate\View\View
 */


    public function indexPersonalCivil()
    {
        $cursos = Cursos::all();
        return view(
            'sireh.personal.civil.index',
            compact(
                'cursos'
            )
        );
    }

    public function indexPersonalMilitarNoProf()
    {
        return view('sireh.personal.militar_noprof.index');
    }


    /**
     * Una función que selecciona y devuelve una vista basada en el valor de entrada de select_periodo y select_categoria.
     *
     * @param Request $request El objeto de solicitud enviado por el cliente
     * @return mixed La vista seleccionada basada en el valor de entrada de select_periodo y select_categoria
     */

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
    /**
     * Recibe los datos de una solicitud y llama a la función 'ascender_julio'
     * para devolver su respuesta.
     *
     * @param Request $request los datos enviados en la solicitud
     * @throws None
     * @return mixed la respuesta de la función 'ascender_julio'
     */
    public function recibir_datos_ascenso_julio(Request $request)
    {
        $data = $request->all(); // Obtener los datos enviados en la solicitud
        // dd($data);
        // Llamar a la función 'ascender_julio' y pasarle los datos
        $response = $this->ascender_julio(new Request($data));

        return $response; // Devolver la respuesta de la función 'ascender_julio'
    }



    /**
     * Esta función actualiza el rango militar y la fecha del último ascenso de los empleados
     * según los datos recibidos. También actualiza el orden de mérito y el orden de mérito total
     * de cada empleado y almacena la información del ascenso en la base de datos. Finalmente, 
     * devuelve una respuesta JSON con el resultado de la operación.
     *
     * @param Request $request El objeto de solicitud HTTP que contiene los datos de ascenso
     * @throws None
     * @return Illuminate\Http\JsonResponse Una respuesta JSON con el resultado de la operación
     */


    public function ascender_julio(Request $request)
    {
        $data = $request->all();

        // Obtener la fecha actual y establecer el día de ascenso en el 5 de julio


        //dd(count($data));
        $ascendidos = 0; // Contador de empleados ascendidos exitosamente
        $resuelto = $data['resuelto'];
        // foreach ($codigo_empleado as $index => $value) {

        for ($i = 1; $i < count($data); $i++) {


            if (isset($data['gd' . $i]) == 'on') {
                $codigo = $data['codigo_empleado' . $i];
                $fecha = $data['fecha' . $i];
                // Editar la tabla "datos_militares"
                DB::table('datos_militares')
                    ->where('codigo_empleado', $codigo)
                    ->update([
                        'fecha_ultimo_ascenso' => $fecha,
                        'orden_merito' => $data['OM' . $i],
                        'total_orden_merito' => $data['OMT' . $i]
                    ]);

                // Obtener el código de grado a ascender
                $codigo_grado = DB::table('grados_militares')
                    ->where('descripcion', $data['grado_ascender' . $i])
                    ->pluck('codigo_grado')
                    ->first();

                // Editar la tabla "nomina"
                $result = DB::table('nomina')
                    ->where('codigo_empleado', $codigo)
                    ->update(['grado_militar' => $codigo_grado]);

                $om = $data['OM' . $i];
                $omt = $data['OMT' . $i];

                DB::table('historico_ascensos')->insert([
                    'codigo_empleado' => $codigo,
                    'codigo_grado' => $codigo_grado,
                    'fecha_ascenso' => $fecha,
                    'orden_merito_ascenso' => $om,
                    'total_orden_merito_ascenso' => $omt,
                    'orden_merito_junta' => $om,
                    'total_orden_merito_junta' => $omt,
                    'resolucion' => $resuelto
                ]);


                $data_ascenso = [];




                if ($result) {

                    $data_ascenso[] = [
                        'codigo_empleado' => $codigo,
                        'mensaje' => 'Empleado Ascendido Exitosamente'
                    ];
                    $ascendidos++; // Incrementar el contador de empleados ascendidos
                } else {
                    $data_ascenso[] = [
                        'codigo_empleado' => $codigo,
                        'mensaje' => 'Error al Ascender el Empleado'
                    ];
                }
            }
        }
        //}                 

        // $total_empleados = count($gd); // Número total de empleados seleccionados
        $mensaje = ''; // Inicializar el mensaje

        if ($ascendidos >= 1) {
            $mensaje = 'Ascenso Exitoso para los [' . $ascendidos . '] Empleados Seleccionados';
            $response = [
                'data' => $data_ascenso,
                'success' => true,
                'message' => $mensaje
            ];
        } else {
            $mensaje = 'No se Pudo Ascender a Todos los Empleados Seleccionados';
            $response = [
                'data' => $data_ascenso,
                'success' => false,
                'message' => $mensaje
            ];
        }



        return response()->json($response);
    }
    /**
     * Actualiza los datos militares y de nómina para los empleados que han sido seleccionados para ascenso.
     *
     * @param Request $request El objeto de solicitud que contiene los datos del empleado.
     * @return \Illuminate\Http\JsonResponse Devuelve la respuesta en formato JSON.
     */

    public function ascender_diciembre(Request $request)
    {
        $data = $request->all();

        // Obtener la fecha actual y establecer el día de ascenso en el 5 de julio


        //dd(count($data));
        $ascendidos = 0; // Contador de empleados ascendidos exitosamente
        $resuelto = $data['resuelto'];
        // foreach ($codigo_empleado as $index => $value) {

        for ($i = 1; $i < count($data); $i++) {


            if (isset($data['gd' . $i]) == 'on') {
                $codigo = $data['codigo_empleado' . $i];
                $fecha = $data['fecha' . $i];
                // Editar la tabla "datos_militares"
                DB::table('datos_militares')
                    ->where('codigo_empleado', $codigo)
                    ->update([
                        'fecha_ultimo_ascenso' => $fecha,
                        'orden_merito' => $data['OM' . $i],
                        'total_orden_merito' => $data['OMT' . $i]
                    ]);

                // Obtener el código de grado a ascender
                $codigo_grado = DB::table('grados_militares')
                    ->where('descripcion', $data['grado_ascender' . $i])
                    ->pluck('codigo_grado')
                    ->first();

                // Editar la tabla "nomina"
                $result = DB::table('nomina')
                    ->where('codigo_empleado', $codigo)
                    ->update(['grado_militar' => $codigo_grado]);

                $om = $data['OM' . $i];
                $omt = $data['OMT' . $i];

                DB::table('historico_ascensos')->insert([
                    'codigo_empleado' => $codigo,
                    'codigo_grado' => $codigo_grado,
                    'fecha_ascenso' => $fecha,
                    'orden_merito_ascenso' => $om,
                    'total_orden_merito_ascenso' => $omt,
                    'orden_merito_junta' => $om,
                    'total_orden_merito_junta' => $omt,
                    'resolucion' => $resuelto
                ]);


                $data_ascenso = [];




                if ($result) {
                    $data_ascenso[] = [
                        'codigo_empleado' => $codigo,
                        'mensaje' => 'Empleado Ascendido Exitosamente'
                    ];
                    $ascendidos++; // Incrementar el contador de empleados ascendidos
                } else {
                    $data_ascenso[] = [
                        'codigo_empleado' => $codigo,
                        'mensaje' => 'Error al Ascender el Empleado'
                    ];
                }
            }
        }
        //}                 

        // $total_empleados = count($gd); // Número total de empleados seleccionados
        $mensaje = ''; // Inicializar el mensaje

        if ($ascendidos >= 1) {
            $mensaje = 'Ascenso Exitoso para los [' . $ascendidos . '] Empleados Seleccionados';
            $response = [
                'data' => $data_ascenso,
                'success' => true,
                'message' => $mensaje
            ];
        } else {
            $mensaje = 'No se Pudo Ascender a Todos los Empleados Seleccionados';
            $response = [
                'data' => $data_ascenso,
                'success' => false,
                'message' => $mensaje
            ];
        }



        return response()->json($response);
    }

   /**
       * 
       * Esta funcion recibe una solicitud y realiza operaciones en funcion de los datos recibidos. Se establece un limite de tiempo 
       * de ejecucion, se obtienen los valores del formulario enviado y realiza una comsulta en la base de datos utilizando una serie de uniones 
       * y condiciones para obtener una lista de empleados guardadas. Luego, se devuelve una respuesta JSON con los detalles de los empleados
       * si se ha encontrado al menos uno. De lo contrario, se devuelve un mensaje de error. 

      *
      * @param Request $request la solicitud HTTP entrante.
     * @return JsonResponse la respuesta JSON que contiene los empleados o un mensaje de error.
     */
    
   

    public function select_diciembre_ofitropa(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');
        $fecha = $request->input('fecha');
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            //  ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")


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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                        $mensaje = 'Error al Encontrar Empleados.';
                        $response = [

                            'success' => false,
                            'message' => $mensaje
                        ];
                        return response()->json($response);
                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores
                $mensaje = 'Error al Encontrar Empleados.';
                $response = [

                    'success' => false,
                    'message' => $mensaje
                ];
                return response()->json($response);
                // return response()->json("no funciona");


                break;
        }
    }
/**
       * 
       * Esta funcion recibe una solicitud y realiza operaciones en funcion de los datos recibidos. Se establece un limite de tiempo 
       * de ejecucion, se obtienen los valores del formulario enviado y realiza una comsulta en la base de datos utilizando una serie de uniones 
       * y condiciones para obtener una lista de empleados guardadas. Luego, se devuelve una respuesta JSON con los detalles de los empleados
       * si se ha encontrado al menos uno. De lo contrario, se devuelve un mensaje de error. 

      *
      * @param Request $request la solicitud HTTP entrante.
     * @return JsonResponse la respuesta JSON que contiene los empleados o un mensaje de error.
     */
    public function select_diciembre_asitecnico(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');
        $fecha = $request->input('fecha');
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            //  ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")


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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                        $mensaje = 'Error al Encontrar Empleados.';
                        $response = [

                            'success' => false,
                            'message' => $mensaje
                        ];
                        return response()->json($response);
                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores
                $mensaje = 'Error al Encontrar Empleados.';
                $response = [

                    'success' => false,
                    'message' => $mensaje
                ];
                return response()->json($response);
                // return response()->json("no funciona");


                break;
        }
    }
/**
       * 
       * Esta funcion recibe una solicitud y realiza operaciones en funcion de los datos recibidos. Se establece un limite de tiempo 
       * de ejecucion, se obtienen los valores del formulario enviado y realiza una comsulta en la base de datos utilizando una serie de uniones 
       * y condiciones para obtener una lista de empleados guardadas. Luego, se devuelve una respuesta JSON con los detalles de los empleados
       * si se ha encontrado al menos uno. De lo contrario, se devuelve un mensaje de error. 

      *
      * @param Request $request la solicitud HTTP entrante.
     * @return JsonResponse la respuesta JSON que contiene los empleados o un mensaje de error.
     */
    public function select_diciembre_asimilado(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');
        $fecha = $request->input('fecha');
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            //  ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")


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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                        $mensaje = 'Error al Encontrar Empleados.';
                        $response = [

                            'success' => false,
                            'message' => $mensaje
                        ];
                        return response()->json($response);
                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores
                $mensaje = 'Error al Encontrar Empleados.';
                $response = [

                    'success' => false,
                    'message' => $mensaje
                ];
                return response()->json($response);
                // return response()->json("no funciona");


                break;
        }
    }
/**
       * 
       * Esta funcion recibe una solicitud y realiza operaciones en funcion de los datos recibidos. Se establece un limite de tiempo 
       * de ejecucion, se obtienen los valores del formulario enviado y realiza una comsulta en la base de datos utilizando una serie de uniones 
       * y condiciones para obtener una lista de empleados guardadas. Luego, se devuelve una respuesta JSON con los detalles de los empleados
       * si se ha encontrado al menos uno. De lo contrario, se devuelve un mensaje de error. 

      *
      * @param Request $request la solicitud HTTP entrante.
     * @return JsonResponse la respuesta JSON que contiene los empleados o un mensaje de error.
     */
    public function select_julio_comando(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');
        $fecha = $request->input('fecha');
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            //  ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")


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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                        $mensaje = 'Error al Encontrar Empleados.';
                        $response = [

                            'success' => false,
                            'message' => $mensaje
                        ];
                        return response()->json($response);
                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores
                $mensaje = 'Error al Encontrar Empleados.';
                $response = [

                    'success' => false,
                    'message' => $mensaje
                ];
                return response()->json($response);
                // return response()->json("no funciona");


                break;
        }
    }
    /**
       * 
       * Esta funcion recibe una solicitud y realiza operaciones en funcion de los datos recibidos. Se establece un limite de tiempo 
       * de ejecucion, se obtienen los valores del formulario enviado y realiza una comsulta en la base de datos utilizando una serie de uniones 
       * y condiciones para obtener una lista de empleados guardadas. Luego, se devuelve una respuesta JSON con los detalles de los empleados
       * si se ha encontrado al menos uno. De lo contrario, se devuelve un mensaje de error. 

      *
      * @param Request $request la solicitud HTTP entrante.
     * @return JsonResponse la respuesta JSON que contiene los empleados o un mensaje de error.
     */
    public function select_julio_tecnico(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');
        $fecha = $request->input('fecha');
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            //  ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")


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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                        $mensaje = 'Error al Encontrar Empleados.';
                        $response = [

                            'success' => false,
                            'message' => $mensaje
                        ];
                        return response()->json($response);
                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores
                $mensaje = 'Error al Encontrar Empleados.';
                $response = [

                    'success' => false,
                    'message' => $mensaje
                ];
                return response()->json($response);
                // return response()->json("no funciona");


                break;
        }
    }
    /**
       * 
       * Esta funcion recibe una solicitud y realiza operaciones en funcion de los datos recibidos. Se establece un limite de tiempo 
       * de ejecucion, se obtienen los valores del formulario enviado y realiza una comsulta en la base de datos utilizando una serie de uniones 
       * y condiciones para obtener una lista de empleados guardadas. Luego, se devuelve una respuesta JSON con los detalles de los empleados
       * si se ha encontrado al menos uno. De lo contrario, se devuelve un mensaje de error. 

      *
      * @param Request $request la solicitud HTTP entrante.
     * @return JsonResponse la respuesta JSON que contiene los empleados o un mensaje de error.
     */
    public function select_julio_ofitropa(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');
        $fecha = $request->input('fecha');
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            //  ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")


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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                        $mensaje = 'Error al Encontrar Empleados.';
                        $response = [

                            'success' => false,
                            'message' => $mensaje
                        ];
                        return response()->json($response);
                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores
                $mensaje = 'Error al Encontrar Empleados.';
                $response = [

                    'success' => false,
                    'message' => $mensaje
                ];
                return response()->json($response);
                // return response()->json("no funciona");


                break;
        }
    }
/**
       * 
       * Esta funcion recibe una solicitud y realiza operaciones en funcion de los datos recibidos. Se establece un limite de tiempo 
       * de ejecucion, se obtienen los valores del formulario enviado y realiza una comsulta en la base de datos utilizando una serie de uniones 
       * y condiciones para obtener una lista de empleados guardadas. Luego, se devuelve una respuesta JSON con los detalles de los empleados
       * si se ha encontrado al menos uno. De lo contrario, se devuelve un mensaje de error. 

      *
      * @param Request $request la solicitud HTTP entrante.
     * @return JsonResponse la respuesta JSON que contiene los empleados o un mensaje de error.
     */
    public function select_julio_asitecnico(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');
        $fecha = $request->input('fecha');
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            //  ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")


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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                        $mensaje = 'Error al Encontrar Empleados.';
                        $response = [

                            'success' => false,
                            'message' => $mensaje
                        ];
                        return response()->json($response);
                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores
                $mensaje = 'Error al Encontrar Empleados.';
                $response = [

                    'success' => false,
                    'message' => $mensaje
                ];
                return response()->json($response);
                // return response()->json("no funciona");


                break;
        }
    }
    /**
       * 
       * Esta funcion recibe una solicitud y realiza operaciones en funcion de los datos recibidos. Se establece un limite de tiempo 
       * de ejecucion, se obtienen los valores del formulario enviado y realiza una comsulta en la base de datos utilizando una serie de uniones 
       * y condiciones para obtener una lista de empleados guardadas. Luego, se devuelve una respuesta JSON con los detalles de los empleados
       * si se ha encontrado al menos uno. De lo contrario, se devuelve un mensaje de error. 

      *
      * @param Request $request la solicitud HTTP entrante.
     * @return JsonResponse la respuesta JSON que contiene los empleados o un mensaje de error.
     */
    public function select_julio_asimilado(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');
        $fecha = $request->input('fecha');
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            //  ->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")


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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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
                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                        $mensaje = 'Error al Encontrar Empleados.';
                        $response = [

                            'success' => false,
                            'message' => $mensaje
                        ];
                        return response()->json($response);
                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores
                $mensaje = 'Error al Encontrar Empleados.';
                $response = [

                    'success' => false,
                    'message' => $mensaje
                ];
                return response()->json($response);
                // return response()->json("no funciona");


                break;
        }
    }
    /**
       * 
       * Esta funcion recibe una solicitud y realiza operaciones en funcion de los datos recibidos. Se establece un limite de tiempo 
       * de ejecucion, se obtienen los valores del formulario enviado y realiza una comsulta en la base de datos utilizando una serie de uniones 
       * y condiciones para obtener una lista de empleados guardadas. Luego, se devuelve una respuesta JSON con los detalles de los empleados
       * si se ha encontrado al menos uno. De lo contrario, se devuelve un mensaje de error. 

      *
      * @param Request $request la solicitud HTTP entrante.
     * @return JsonResponse la respuesta JSON que contiene los empleados o un mensaje de error.
     */
    public function select_julio_tropap(Request $request)
    {
        ini_set('max_execution_time', 300);

        $grado = $request->input('select_comando1');

        $categoria = $request->input('categoria');
        $fecha = $request->input('fecha');
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")

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

                            $mensaje = 'No Se Encontraron Empleados.';
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
                        $mensaje = 'Error al Encontrar Empleados.';
                        $response = [

                            'success' => false,
                            'message' => $mensaje
                        ];
                        return response()->json($response);
                        // return response()->json("no funciona");
                        break;
                }




                break;
            default:
                // código a ejecutar si $valor no coincide con ninguna de las opciones anteriores
                $mensaje = 'Error al Encontrar Empleados.';
                $response = [

                    'success' => false,
                    'message' => $mensaje
                ];
                return response()->json($response);
                // return response()->json("no funciona");


                break;
        }
    }

 /*   public function select(Request $request)
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")


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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")


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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")


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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")


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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")


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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
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
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereRaw("MONTH(fecha_graduacion) = 7")


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

*/

    /**
     * Esta función se utiliza para realizar el ascenso militar de un empleado.
     *
     * @param Request $request La instancia de la solicitud HTTP.
     * @throws None.
     * @return \Illuminate\Http\JsonResponse La instancia de respuesta actualizada.
     */

   
    public function ascender_personal(Request $request)
    {
        // $data = $request->all();

        $select_ofi = $request->input('select_ofi');

        $select_tropap = $request->input('select_tropap');
        $codigo_empleado = $request->input('codigo_empleado');

        $grado_empleado = $request->input('grado_empleado');
        $om = $request->input('om');
        $omt = $request->input('omt');
        $fecha = $request->input('fecha');
        $resuelto = $request->input('resuelto');
        $select_just = $request->input('select_just');
        $justif = $request->input('justif');
        $reconoc = $request->input('reconoc');
        $fecha_reconoc = $request->input('fecha_reconoc');






        if ($select_ofi == '') {

            if ($select_just == 'no') {

                DB::table('datos_militares')
                    ->where('codigo_empleado', $codigo_empleado)
                    ->update([
                        'fecha_ultimo_ascenso' => $fecha,
                        'orden_merito' => $om,
                        'total_orden_merito' => $omt
                    ]);


                $desc_grado = DB::table('grados_militares')
                    ->where('codigo_grado', $select_tropap)
                    ->pluck('descripcion')
                    ->first();

                // Editar la tabla "nomina"
                $result = DB::table('nomina')
                    ->where('codigo_empleado', $codigo_empleado)
                    ->update(['grado_militar' => $select_tropap]);


                DB::table('historico_ascensos')->insert([
                    'codigo_empleado' => $codigo_empleado,
                    'codigo_grado' => $select_tropap,
                    'fecha_ascenso' => $fecha,
                    'orden_merito_ascenso' => $om,
                    'total_orden_merito_ascenso' => $omt,
                    'orden_merito_junta' => $om,
                    'total_orden_merito_junta' => $omt,
                    'resolucion' => $resuelto
                ]);
                if ($result) {
                    $mensaje = 'Ascenso Exitoso para el Empleado con el Código: [' . $codigo_empleado . ']';
                    $response = [
                        'data' => $mensaje,
                        'success' => true,
                        //'message' => $mensaje
                    ]; // Incrementar el contador de empleados ascendidos
                } else {
                    $mensaje = 'Error al Ascender el Empleado con el Código: [' . $codigo_empleado . ']';
                    $response = [
                        'data' => $mensaje,
                        'success' => false,
                        // 'message' => $mensaje
                    ];
                }
            } else {

                DB::table('datos_militares')
                    ->where('codigo_empleado', $codigo_empleado)
                    ->update([
                        'fecha_ultimo_ascenso' => $fecha,
                        'orden_merito' => $om,
                        'total_orden_merito' => $omt
                    ]);


                $desc_grado = DB::table('grados_militares')
                    ->where('codigo_grado', $select_tropap)
                    ->pluck('siglas')
                    ->first();

                // Editar la tabla "nomina"
                $result = DB::table('nomina')
                    ->where('codigo_empleado', $codigo_empleado)
                    ->update(['grado_militar' => $select_tropap]);


                DB::table('historico_ascensos')->insert([
                    'codigo_empleado' => $codigo_empleado,
                    'codigo_grado' => $select_tropap,
                    'fecha_ascenso' => $fecha,
                    'orden_merito_ascenso' => $om,
                    'total_orden_merito_ascenso' => $omt,
                    'orden_merito_junta' => $om,
                    'total_orden_merito_junta' => $omt,
                    'resolucion' => $resuelto,
                    'años_reconocidos' => $reconoc,
                    'resol_años_reconoc' => $resuelto,
                    'fec_resol_años_reconc' => $fecha_reconoc,
                    'justificacion' => $justif,
                    'grado_reconocido' => $desc_grado
                ]);


                if ($result) {
                    $mensaje = 'Ascenso Exitoso para el Empleado con el Código: [' . $codigo_empleado . ']';
                    $response = [
                        'data' => $mensaje,
                        'success' => true,
                        //'message' => $mensaje
                    ]; // Incrementar el contador de empleados ascendidos
                } else {
                    $mensaje = 'Error al Ascender el Empleado con el Código: [' . $codigo_empleado . ']';
                    $response = [
                        'data' => $mensaje,
                        'success' => false,
                        // 'message' => $mensaje
                    ];
                }
            }
        } else {

          

            if ($select_just == 'no') {

                DB::table('datos_militares')
                    ->where('codigo_empleado', $codigo_empleado)
                    ->update([
                        'fecha_ultimo_ascenso' => $fecha,
                        'orden_merito' => $om,
                        'total_orden_merito' => $omt
                    ]);


                $codigo_grado = DB::table('grados_militares')
                    ->where('descripcion', $select_ofi)
                    ->pluck('codigo_grado')
                    ->first();

                // Editar la tabla "nomina"
                $result = DB::table('nomina')
                    ->where('codigo_empleado', $codigo_empleado)
                    ->update(['grado_militar' => $select_ofi]);


                DB::table('historico_ascensos')->insert([
                    'codigo_empleado' => $codigo_empleado,
                    'codigo_grado' => $select_ofi,
                    'fecha_ascenso' => $fecha,
                    'orden_merito_ascenso' => $om,
                    'total_orden_merito_ascenso' => $omt,
                    'orden_merito_junta' => $om,
                    'total_orden_merito_junta' => $omt,
                    'resolucion' => $resuelto
                ]);

                if ($result) {
                    $mensaje = 'Ascenso Exitoso para el Empleado con el Código: [' . $codigo_empleado . ']';
                    $response = [
                        'data' => $mensaje,
                        'success' => true,
                        //'message' => $mensaje
                    ]; // Incrementar el contador de empleados ascendidos
                } else {
                    $mensaje = 'Error al Ascender el Empleado con el Código: [' . $codigo_empleado . ']';
                    $response = [
                        'data' => $mensaje,
                        'success' => false,
                        // 'message' => $mensaje
                    ];
                }
            } else {
                DB::table('datos_militares')
                    ->where('codigo_empleado', $codigo_empleado)
                    ->update([
                        'fecha_ultimo_ascenso' => $fecha,
                        'orden_merito' => $om,
                        'total_orden_merito' => $omt
                    ]);


                $desc_grado = DB::table('grados_militares')
                    ->where('codigo_grado', $select_ofi)
                    ->pluck('siglas')
                    ->first();

                // Editar la tabla "nomina"
                $result = DB::table('nomina')
                    ->where('codigo_empleado', $codigo_empleado)
                    ->update(['grado_militar' => $select_ofi]);


                DB::table('historico_ascensos')->insert([
                    'codigo_empleado' => $codigo_empleado,
                    'codigo_grado' => $select_ofi,
                    'fecha_ascenso' => $fecha,
                    'orden_merito_ascenso' => $om,
                    'total_orden_merito_ascenso' => $omt,
                    'orden_merito_junta' => $om,
                    'total_orden_merito_junta' => $omt,
                    'resolucion' => $resuelto,
                    'años_reconocidos' => $reconoc,
                    'resol_años_reconoc' => $resuelto,
                    'fec_resol_años_reconc' => $fecha_reconoc,
                    'justificacion' => $justif,
                    'grado_reconocido' => $desc_grado
                ]);


                if ($result) {
                    $mensaje = 'Ascenso Exitoso para el Empleado con el Código: [' . $codigo_empleado . ']';
                    $response = [
                        'data' => $mensaje,
                        'success' => true,
                        //'message' => $mensaje
                    ]; // Incrementar el contador de empleados ascendidos
                } else {
                    $mensaje = 'Error al Ascender el Empleado con el Código: [' . $codigo_empleado . ']';
                    $response = [
                        'data' => $mensaje,
                        'success' => false,
                        // 'message' => $mensaje
                    ];
                }


                //}                 

                // $total_empleados = count($gd); // Número total de empleados seleccionados

            }
        }




        return response()->json($response);
    }

    public function cambio_categoria_personal(Request $request)
    {
        // $data = $request->all();

        $select_ofi_cat = $request->input('select_ofi_cat');
        $select_categoria = $request->input('select_categoria');

        $codigo_empleado_cat = $request->input('codigo_empleado_cat');

        $grado_empleado_cat = $request->input('grado_empleado_cat');
        $om_cat = $request->input('om_cat');
        $omt_cat = $request->input('omt_cat');
        $fecha_cat = $request->input('fecha_cat');
        $resuelto_cat = $request->input('resuelto_cat');

        $select_tp_cat = $request->input('select_tp_cat');

//dd($select_ofi_cat);

if($select_ofi_cat == null){

    $result =  DB::table('datos_militares')
            ->where('codigo_empleado', $codigo_empleado_cat)
            ->update([
                'codigo_categoria' => $select_categoria,
                'fecha_ultimo_ascenso' => $fecha_cat,
                'orden_merito' => $om_cat,
                'total_orden_merito' => $omt_cat
            ]);


        $desc_grado = DB::table('grados_militares')
            ->where('codigo_grado', $select_tp_cat)
            ->pluck('siglas')
            ->first();

        // Editar la tabla "nomina"
        $result11 =  DB::table('nomina')
            ->where('codigo_empleado', $codigo_empleado_cat)
            ->update(['grado_militar' => $select_tp_cat]);
//dd($result11);

        DB::table('historico_ascensos')->insert([
            'codigo_empleado' => $codigo_empleado_cat,
            'codigo_grado' => $select_tp_cat,
            'fecha_ascenso' => $fecha_cat,
            'orden_merito_ascenso' => $om_cat,
            'total_orden_merito_ascenso' => $omt_cat,
            'orden_merito_junta' => $om_cat,
            'total_orden_merito_junta' => $omt_cat,
            'resolucion' => $resuelto_cat

        ]);

    }else{



        $result =   DB::table('datos_militares')
            ->where('codigo_empleado', $codigo_empleado_cat)
            ->update([
                'codigo_categoria' => $select_categoria,
                'fecha_ultimo_ascenso' => $fecha_cat,
                'orden_merito' => $om_cat,
                'total_orden_merito' => $omt_cat
            ]);


        $desc_grado = DB::table('grados_militares')
            ->where('codigo_grado', $select_ofi_cat)
            ->pluck('siglas')
            ->first();

        // Editar la tabla "nomina"
       $res=  DB::table('nomina')
            ->where('codigo_empleado', $codigo_empleado_cat)
            ->update(['grado_militar' => $select_ofi_cat]);
//dd($res);

        DB::table('historico_ascensos')->insert([
            'codigo_empleado' => $codigo_empleado_cat,
            'codigo_grado' => $select_ofi_cat,
            'fecha_ascenso' => $fecha_cat,
            'orden_merito_ascenso' => $om_cat,
            'total_orden_merito_ascenso' => $omt_cat,
            'orden_merito_junta' => $om_cat,
            'total_orden_merito_junta' => $omt_cat,
            'resolucion' => $resuelto_cat

        ]);




    }
        if ($result) {
            $mensaje = 'Cambio de Categoria Exitoso para el Empleado con el Código: [' . $codigo_empleado_cat . ']';
            $response = [
                'data' => $mensaje,
                'success' => true,
                //'message' => $mensaje
            ]; // Incrementar el contador de empleados ascendidos
        } else {
            $mensaje = 'Error Cambio de Categoria del Empleado con el Código: [' . $codigo_empleado_cat . ']';
            $response = [
                'data' => $mensaje,
                'success' => false,
                // 'message' => $mensaje
            ];
        }







        return response()->json($response);





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
            ->where(function ($query) {
                $query->where('empleados.situacion', 'A')
                    ->orWhere('empleados.situacion', 'S');
            })
            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
            ->where(function ($query) {
                $query->where('empleados.situacion', 'A')
                    ->orWhere('empleados.situacion', 'S');
            })
            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

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
       // $empleados = Empleado::where('empleados.situacion', 'A');




       $empleados = Empleado::where(function ($query) {
        $query->where('nomina.situacion', 'A')
            ->orWhere('nomina.situacion', 'S');
    });
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


    public function ascDataPersonalMilitar(Request $request)
    {

        $id = $request->input('id');
        $id_array = explode(',', $id);
        $data = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
           // ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
            // ->where('nomina.codigo_empleado', '=',$data->codigo_empleado)
            ->whereIn('nomina.codigo_empleado', $id_array)
            ->where(function ($query) {
                $query->where('empleados.situacion', 'A')
                    ->orWhere('empleados.situacion', 'S');
            })
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
        // dd($data);
        return response()->json(
            [
                'success' => true,
                'message' => 'Data',
                'data' => $data,
                //'haveFuncion' => $empleados
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


    public function ofic($categoria, $ofi, $fecha)
    {
        try {
            ini_set('max_execution_time', 3600);
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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',
                        )
                        ->orderBy('empleados.cedula')
                        ->get()
                        ->toArray();



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);



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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',
                        )
                        ->orderBy('empleados.cedula')
                        ->get()
                        ->toArray();
                    //  return $empleados->get();


                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);



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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',
                        )
                        ->orderBy('empleados.cedula')
                        ->get()
                        ->toArray();


                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);





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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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
                        ->get()
                        ->toArray();


                    // dd($categoria);


                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);





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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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
                        ->get()
                        ->toArray();



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);




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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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
                        ->get()
                        ->toArray();



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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
                        ->get()
                        ->toArray();



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);



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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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
                        ->get()
                        ->toArray();



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")


                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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
                        ->get()
                        ->toArray();





                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


                    break;
                default:

                    break;
            }
        } catch (\Exception $e) {
            $mensaje = "Error en la consulta: " . $e->getMessage();
            return $mensaje;
        }
    }
    public function ofic_pdf($categoria, $ofi, $fecha)
    {
        try {
            ini_set('max_execution_time', 3600);
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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',
                        )
                        ->orderBy('empleados.cedula')
                        ->get();



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);



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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',
                        )
                        ->orderBy('empleados.cedula')
                        ->get();
                    //  return $empleados->get();


                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);



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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',
                        )
                        ->orderBy('empleados.cedula')
                        ->get();


                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);





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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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


                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);





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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);




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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);



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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 9");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")


                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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





                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


                    break;
                default:

                    break;
            }
        } catch (\Exception $e) {
            $mensaje = "Error en la consulta: " . $e->getMessage();
            return $mensaje;
        }
    }
    public function ofic_dic($categoria, $ofi, $fecha)
    {
        try {
            ini_set('max_execution_time', 3600);
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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',
                        )
                        ->orderBy('empleados.cedula')
                        ->get()
                        ->toArray();




                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);



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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',
                        )
                        ->orderBy('empleados.cedula')
                        ->get()
                        ->toArray();
                    //  return $empleados->get();


                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);



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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',
                        )
                        ->orderBy('empleados.cedula')
                        ->get()
                        ->toArray();



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);





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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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
                        ->get()
                        ->toArray();


                    // dd($categoria);


                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);




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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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
                        ->get()
                        ->toArray();




                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);




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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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
                        ->get()
                        ->toArray();



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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
                        ->get()
                        ->toArray();




                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);



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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")


                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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
                        ->get()
                        ->toArray();




                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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
                        ->get()
                        ->toArray();






                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                    break;
                default:

                    break;
            }
        } catch (\Exception $e) {
            $mensaje = "Error en la consulta: " . $e->getMessage();
            return $mensaje;
        }
    }
    public function ofic_dic_pdf($categoria, $ofi, $fecha)
    {
        try {
            ini_set('max_execution_time', 3600);
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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',
                        )
                        ->orderBy('empleados.cedula')
                        ->get();




                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);



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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',
                        )
                        ->orderBy('empleados.cedula')
                        ->get();
                    //  return $empleados->get();


                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);



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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])

                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',
                        )
                        ->orderBy('empleados.cedula')
                        ->get();



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);





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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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


                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);




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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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




                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);




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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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



                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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




                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);



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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")


                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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




                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

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
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")

                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
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






                    return  $empleados;
                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);

                    break;
                default:

                    break;
            }
        } catch (\Exception $e) {
            $mensaje = "Error en la consulta: " . $e->getMessage();
            return $mensaje;
        }
    }
    public function ascreporte_pdf($periodo, $categoria, $ofi, $tropap, $fecha)
    {
        try {
            ini_set('max_execution_time', 3600);


            $empleados = [];
            $datos = "";
            $complementoTitulo = '';
            $grado = '';



            switch ($periodo) {

                case 'julio':

                    switch ($categoria) {
                        case '4':


                            return $this->ofic_pdf($categoria, $ofi, $fecha);
                            break;

                        case '5':
                            $complementoTitulo = "OFICIALES DE TECNICOS EN EL GRADO DE ";



                            return $this->ofic_pdf($categoria, $ofi, $fecha);

                            break;

                        case '7':

                            $complementoTitulo = "OFICIALES DE TROPA EN EL GRADO DE ";

                            return $this->ofic_pdf($categoria, $ofi, $fecha);

                            break;
                        case '6':
                            $complementoTitulo = "OFICIALES ASIMILADOS TECNICOS EN EL GRADO DE ";


                            return $this->ofic_pdf($categoria, $ofi, $fecha);
                            break;
                        case '2':
                            $complementoTitulo = "OFICIALES ASIMILADOS EN EL GRADO DE ";

                            return $this->ofic_pdf($categoria, $ofi, $fecha);
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
                                        ->where(function ($query) {
                                            $query->where('empleados.situacion', 'A')
                                                ->orWhere('empleados.situacion', 'S');
                                        })
                                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                        ->where(function ($query) {
                                            $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                        })
                                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")


                                        ->select(
                                            'empleados.codigo_empleado',
                                            'datos_militares.codigo_categoria as categoria',
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




                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                                        ->where(function ($query) {
                                            $query->where('empleados.situacion', 'A')
                                                ->orWhere('empleados.situacion', 'S');
                                        })
                                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                        ->where(function ($query) {
                                            $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                        })
                                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

                                        ->select(
                                            'empleados.codigo_empleado',
                                            'datos_militares.codigo_categoria as categoria',
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




                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                                        ->where(function ($query) {
                                            $query->where('empleados.situacion', 'A')
                                                ->orWhere('empleados.situacion', 'S');
                                        })
                                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                        ->where(function ($query) {
                                            $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                        })
                                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

                                        ->select(
                                            'empleados.codigo_empleado',
                                            'datos_militares.codigo_categoria as categoria',
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




                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                                        ->where(function ($query) {
                                            $query->where('empleados.situacion', 'A')
                                                ->orWhere('empleados.situacion', 'S');
                                        })
                                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                        ->where(function ($query) {
                                            $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                        })
                                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")


                                        ->select(
                                            'empleados.codigo_empleado',
                                            'datos_militares.codigo_categoria as categoria',
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




                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                                        ->where(function ($query) {
                                            $query->where('empleados.situacion', 'A')
                                                ->orWhere('empleados.situacion', 'S');
                                        })
                                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                        ->where(function ($query) {
                                            $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                        })
                                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")



                                        ->select(
                                            'empleados.codigo_empleado',
                                            'datos_militares.codigo_categoria as categoria',
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




                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                                        ->where(function ($query) {
                                            $query->where('empleados.situacion', 'A')
                                                ->orWhere('empleados.situacion', 'S');
                                        })
                                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                        ->where(function ($query) {
                                            $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                        })
                                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")


                                        ->select(
                                            'empleados.codigo_empleado',
                                            'datos_militares.codigo_categoria as categoria',
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



                                    return $empleados;

                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


                                    break;


                                default:


                                    break;
                            }


                            break;


                        default:

                            break;
                    }

                    break;


                case 'diciembre':

                    switch ($categoria) {

                        case '7':


                            return $this->ofic_dic_pdf($categoria, $ofi, $fecha);
                            break;
                        case '6':


                            return $this->ofic_dic_pdf($categoria, $ofi, $fecha);
                            break;
                        case '2':

                            return $this->ofic_dic_pdf($categoria, $ofi, $fecha);
                            break;

                        default:

                            break;
                    }
            } //



        } catch (\Exception $e) {
            $mensaje = "Error en la consulta: " . $e->getMessage();
            return $mensaje;
        }
    }

    public function ascreporte($periodo, $categoria, $ofi, $tropap, $fecha)
    {
        try {
            ini_set('max_execution_time', 3600);


            $empleados = [];
            $datos = "";
            $complementoTitulo = '';
            $grado = '';



            switch ($periodo) {

                case 'julio':

                    switch ($categoria) {
                        case '4':


                            return $this->ofic($categoria, $ofi, $fecha);
                            break;

                        case '5':
                            $complementoTitulo = "OFICIALES DE TECNICOS EN EL GRADO DE ";



                            return $this->ofic($categoria, $ofi, $fecha);

                            break;

                        case '7':

                            $complementoTitulo = "OFICIALES DE TROPA EN EL GRADO DE ";

                            return $this->ofic($categoria, $ofi, $fecha);

                            break;
                        case '6':
                            $complementoTitulo = "OFICIALES ASIMILADOS TECNICOS EN EL GRADO DE ";


                            return $this->ofic($categoria, $ofi, $fecha);
                            break;
                        case '2':
                            $complementoTitulo = "OFICIALES ASIMILADOS EN EL GRADO DE ";

                            return $this->ofic($categoria, $ofi, $fecha);
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
                                        ->where(function ($query) {
                                            $query->where('empleados.situacion', 'A')
                                                ->orWhere('empleados.situacion', 'S');
                                        })
                                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                        ->where(function ($query) {
                                            $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                        })
                                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")


                                        ->select(
                                            'empleados.codigo_empleado',
                                            'datos_militares.codigo_categoria as categoria',
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
                                        ->get()
                                        ->toArray();




                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                                        ->where(function ($query) {
                                            $query->where('empleados.situacion', 'A')
                                                ->orWhere('empleados.situacion', 'S');
                                        })
                                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                        ->where(function ($query) {
                                            $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                        })
                                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 4 YEAR)")

                                        ->select(
                                            'empleados.codigo_empleado',
                                            'datos_militares.codigo_categoria as categoria',
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
                                        ->get()
                                        ->toArray();




                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                                        ->where(function ($query) {
                                            $query->where('empleados.situacion', 'A')
                                                ->orWhere('empleados.situacion', 'S');
                                        })
                                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                        ->where(function ($query) {
                                            $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                        })
                                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")

                                        ->select(
                                            'empleados.codigo_empleado',
                                            'datos_militares.codigo_categoria as categoria',
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
                                        ->get()
                                        ->toArray();




                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                                        ->where(function ($query) {
                                            $query->where('empleados.situacion', 'A')
                                                ->orWhere('empleados.situacion', 'S');
                                        })
                                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                        ->where(function ($query) {
                                            $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                        })
                                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")


                                        ->select(
                                            'empleados.codigo_empleado',
                                            'datos_militares.codigo_categoria as categoria',
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
                                        ->get()
                                        ->toArray();




                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                                        ->where(function ($query) {
                                            $query->where('empleados.situacion', 'A')
                                                ->orWhere('empleados.situacion', 'S');
                                        })
                                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                        ->where(function ($query) {
                                            $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                        })
                                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 5 YEAR)")



                                        ->select(
                                            'empleados.codigo_empleado',
                                            'datos_militares.codigo_categoria as categoria',
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
                                        ->get()
                                        ->toArray();




                                    return  $empleados;
                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


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
                                        ->where(function ($query) {
                                            $query->where('empleados.situacion', 'A')
                                                ->orWhere('empleados.situacion', 'S');
                                        })
                                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                                        ->where(function ($query) {
                                            $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                                ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                                        })
                                        ->whereRaw("datos_militares.fecha_ultimo_ascenso <= DATE_SUB('$fecha', INTERVAL 3 YEAR)")


                                        ->select(
                                            'empleados.codigo_empleado',
                                            'datos_militares.codigo_categoria as categoria',
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
                                        ->get()
                                        ->toArray();



                                    return $empleados;

                                    //return response()->json(['message' => 'No se encontraron empleados.'], 404);


                                    break;


                                default:


                                    break;
                            }


                            break;


                        default:

                            break;
                    }

                    break;


                case 'diciembre':

                    switch ($categoria) {

                        case '7':


                            return $this->ofic_dic($categoria, $ofi, $fecha);
                            break;
                        case '6':


                            return $this->ofic_dic($categoria, $ofi, $fecha);
                            break;
                        case '2':

                            return $this->ofic_dic($categoria, $ofi, $fecha);
                            break;

                        default:

                            break;
                    }
            } //



        } catch (\Exception $e) {
            $mensaje = "Error en la consulta: " . $e->getMessage();
            return $mensaje;
        }
    }
    public function cat_reporte($periodo, $fecha, $categoria)
    {

        try {
            ini_set('max_execution_time', 3600);


            $empleados = [];
            $datos = "";
            $complementoTitulo = '';
            $grado = '';


            if ($periodo == "diciembre") {

                if ($categoria == 8) {


                    $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                        ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                        ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                        ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                        ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                        ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->whereIn('datos_militares.codigo_categoria', [$categoria])
                        ->whereIn('nomina.grado_militar', [420, 430, 440, 450, 460, 470])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")

                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->where(function ($query) use ($fecha) {
                            $query->whereRaw("DATEDIFF('$fecha', datos_militares.fecha_ultimo_ascenso) >= CASE
                WHEN nomina.grado_militar IN (470) THEN 3*365
                WHEN nomina.grado_militar IN (460,450,440) THEN 5*365
                WHEN nomina.grado_militar IN (430,420) THEN 4*365
                ELSE 0
            END");
                        })
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',

                            DB::raw("(SELECT IFNULL(SUM(
    CASE
    
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 470 THEN 2
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 470 THEN 3
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 470 THEN 4
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 460 THEN 3
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 460 THEN 4
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 460 THEN 5
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 450 THEN 4
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 450 THEN 5
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 450 THEN 6
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 440 THEN 5
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 440 THEN 6
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 440 THEN 7
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 430 THEN 6
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 430 THEN 7
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 430 THEN 8
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 420 THEN 7
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 420 THEN 8
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 420 THEN 9
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


                        ->get()
                        ->toArray();


                    return $empleados;
                } else {
                    //  $empleados = Nomina::select('empleados.codigo_empleado', 'empleados.cedula AS cedula', 'datos_militares.codigo_categoria AS categoria', 'empleados.nombre1 AS nombre1', 'empleados.apellido1 AS apellido1', 'grados_militares.descripcion AS grado_militar', 'grados_militares.grado_a_ascender AS grado_ascender', 'datos_militares.fecha_ultimo_ascenso AS fecha_ult', 'datos_militares.fecha_graduacion AS fecha_grad')


                    $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                        ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                        ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                        ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                        ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                        ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')

                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->whereIn('datos_militares.codigo_categoria', [$categoria])
                        ->whereIn('nomina.grado_militar', [15, 20, 30, 40, 50, 60, 70, 80, 90])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->where(function ($query) use ($fecha) {
                            $query->whereRaw("DATEDIFF('$fecha', datos_militares.fecha_ultimo_ascenso) >= CASE
    WHEN nomina.grado_militar IN (090,030, 020, 15) THEN 3*365
    WHEN nomina.grado_militar IN (080,070) THEN 5*365
    WHEN nomina.grado_militar IN (060,050, 040) THEN 4*365
    ELSE 0
    END");
                        })
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',

                            DB::raw("(SELECT IFNULL(SUM(
    CASE
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 090 THEN 2
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 090 THEN 5
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 090 THEN 10
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 080 THEN 4
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 080 THEN 7
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 080 THEN 12
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 070 THEN 6
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 070 THEN 9
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 070 THEN 14
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 060 THEN 8
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 060 THEN 11
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 060 THEN 16
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 050 THEN 10
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 050 THEN 13
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 050 THEN 18
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 040 THEN 12
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 040 THEN 15
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 040 THEN 20
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


                        ->get()
                        ->toArray();


                    return $empleados;
                }
            } else {
                if ($categoria == 8) {


                    $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                        ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                        ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                        ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                        ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                        ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->whereIn('datos_militares.codigo_categoria', [$categoria])
                        ->whereIn('nomina.grado_militar', [420, 430, 440, 450, 460, 470])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                        })
                        ->where(function ($query) use ($fecha) {
                            $query->whereRaw("DATEDIFF('$fecha', datos_militares.fecha_ultimo_ascenso) >= CASE
            WHEN nomina.grado_militar IN (470) THEN 3*365
            WHEN nomina.grado_militar IN (460,450,440) THEN 5*365
            WHEN nomina.grado_militar IN (430,420) THEN 4*365
            ELSE 0
        END");
                        })
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',

                            DB::raw("(SELECT IFNULL(SUM(
CASE

WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 470 THEN 2
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 470 THEN 3
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 470 THEN 4
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 460 THEN 3
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 460 THEN 4
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 460 THEN 5
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 450 THEN 4
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 450 THEN 5
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 450 THEN 6
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 440 THEN 5
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 440 THEN 6
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 440 THEN 7
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 430 THEN 6
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 430 THEN 7
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 430 THEN 8
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 420 THEN 7
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 420 THEN 8
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 420 THEN 9
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


                        ->get()
                        ->toArray();


                    return $empleados;
                } else {
                    //  $empleados = Nomina::select('empleados.codigo_empleado', 'empleados.cedula AS cedula', 'datos_militares.codigo_categoria AS categoria', 'empleados.nombre1 AS nombre1', 'empleados.apellido1 AS apellido1', 'grados_militares.descripcion AS grado_militar', 'grados_militares.grado_a_ascender AS grado_ascender', 'datos_militares.fecha_ultimo_ascenso AS fecha_ult', 'datos_militares.fecha_graduacion AS fecha_grad')


                    $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                        ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                        ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                        ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                        ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                        ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')

                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->whereIn('datos_militares.codigo_categoria', [$categoria])
                        ->whereIn('nomina.grado_militar', [15, 20, 30, 40, 50, 60, 70, 80, 90])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 6");
                        })
                        ->where(function ($query) use ($fecha) {
                            $query->whereRaw("DATEDIFF('$fecha', datos_militares.fecha_ultimo_ascenso) >= CASE
WHEN nomina.grado_militar IN (090,030, 020, 15) THEN 3*365
WHEN nomina.grado_militar IN (080,070) THEN 5*365
WHEN nomina.grado_militar IN (060,050, 040) THEN 4*365
ELSE 0
END");
                        })
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',

                            DB::raw("(SELECT IFNULL(SUM(
CASE
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 090 THEN 2
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 090 THEN 5
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 090 THEN 10
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 080 THEN 4
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 080 THEN 7
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 080 THEN 12
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 070 THEN 6
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 070 THEN 9
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 070 THEN 14
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 060 THEN 8
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 060 THEN 11
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 060 THEN 16
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 050 THEN 10
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 050 THEN 13
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 050 THEN 18
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 040 THEN 12
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 040 THEN 15
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 040 THEN 20
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


                        ->get()
                        ->toArray();


                    return $empleados;
                }
            }
        } catch (\Exception $e) {
            $mensaje = "Error en la consulta: " . $e->getMessage();
            return $mensaje;
        }

        //dd($empleados);

        //completar consulta 
        /*

    ->orderBy('empleados.cedula')
            ->get()
            ->toArray();



        DB::statement('CREATE TEMPORARY TABLE empleados_temporal_excel (
            codigo_empleado INT,
            cedula VARCHAR(50),
            nombre1 VARCHAR(50),
            apellido1 VARCHAR(50),
            grado_militar VARCHAR(50),
            grado_ascender VARCHAR(50),
            punto INT,
            demerito FLOAT
        )');

        DB::table('empleados_temporal_excel')->insert($empleados);


        //dd($empleados);




        // Loop through all the pages of results

        // Retrieve the current page of results
        $empleados_temporal = DB::table('empleados_temporal_excel')->get();
        // Rest of the query
*/


        // Generate the PDF report for the current page
        // ...


    }
    public function cat_reporte_pdf($periodo, $fecha, $categoria)
    {

        try {
            ini_set('max_execution_time', 3600);


            $empleados = [];
            $datos = "";
            $complementoTitulo = '';
            $grado = '';


            if ($periodo == "diciembre") {

                if ($categoria == 8) {


                    $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                        ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                        ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                        ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                        ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                        ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->whereIn('datos_militares.codigo_categoria', [$categoria])
                        ->whereIn('nomina.grado_militar', [420, 430, 440, 450, 460, 470])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")

                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->where(function ($query) use ($fecha) {
                            $query->whereRaw("DATEDIFF('$fecha', datos_militares.fecha_ultimo_ascenso) >= CASE
                WHEN nomina.grado_militar IN (470) THEN 3*365
                WHEN nomina.grado_militar IN (460,450,440) THEN 5*365
                WHEN nomina.grado_militar IN (430,420) THEN 4*365
                ELSE 0
            END");
                        })
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',

                            DB::raw("(SELECT IFNULL(SUM(
    CASE
    
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 470 THEN 2
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 470 THEN 3
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 470 THEN 4
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 460 THEN 3
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 460 THEN 4
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 460 THEN 5
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 450 THEN 4
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 450 THEN 5
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 450 THEN 6
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 440 THEN 5
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 440 THEN 6
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 440 THEN 7
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 430 THEN 6
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 430 THEN 7
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 430 THEN 8
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 420 THEN 7
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 420 THEN 8
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 420 THEN 9
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


                        ->get();


                    return $empleados;
                } else {
                    //  $empleados = Nomina::select('empleados.codigo_empleado', 'empleados.cedula AS cedula', 'datos_militares.codigo_categoria AS categoria', 'empleados.nombre1 AS nombre1', 'empleados.apellido1 AS apellido1', 'grados_militares.descripcion AS grado_militar', 'grados_militares.grado_a_ascender AS grado_ascender', 'datos_militares.fecha_ultimo_ascenso AS fecha_ult', 'datos_militares.fecha_graduacion AS fecha_grad')


                    $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                        ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                        ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                        ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                        ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                        ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')

                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->whereIn('datos_militares.codigo_categoria', [$categoria])
                        ->whereIn('nomina.grado_militar', [15, 20, 30, 40, 50, 60, 70, 80, 90])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                        })
                        ->where(function ($query) use ($fecha) {
                            $query->whereRaw("DATEDIFF('$fecha', datos_militares.fecha_ultimo_ascenso) >= CASE
    WHEN nomina.grado_militar IN (090,030, 020, 15) THEN 3*365
    WHEN nomina.grado_militar IN (080,070) THEN 5*365
    WHEN nomina.grado_militar IN (060,050, 040) THEN 4*365
    ELSE 0
    END");
                        })
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',

                            DB::raw("(SELECT IFNULL(SUM(
    CASE
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 090 THEN 2
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 090 THEN 5
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 090 THEN 10
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 080 THEN 4
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 080 THEN 7
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 080 THEN 12
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 070 THEN 6
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 070 THEN 9
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 070 THEN 14
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 060 THEN 8
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 060 THEN 11
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 060 THEN 16
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 050 THEN 10
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 050 THEN 13
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 050 THEN 18
    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 040 THEN 12
    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 040 THEN 15
    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 040 THEN 20
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


                        ->get();


                    return $empleados;
                }
            } else {
                if ($categoria == 8) {


                    $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                        ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                        ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                        ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                        ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                        ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->whereIn('datos_militares.codigo_categoria', [$categoria])
                        ->whereIn('nomina.grado_militar', [420, 430, 440, 450, 460, 470])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                        })
                        ->where(function ($query) use ($fecha) {
                            $query->whereRaw("DATEDIFF('$fecha', datos_militares.fecha_ultimo_ascenso) >= CASE
            WHEN nomina.grado_militar IN (470) THEN 3*365
            WHEN nomina.grado_militar IN (460,450,440) THEN 5*365
            WHEN nomina.grado_militar IN (430,420) THEN 4*365
            ELSE 0
        END");
                        })
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',

                            DB::raw("(SELECT IFNULL(SUM(
CASE

WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 470 THEN 2
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 470 THEN 3
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 470 THEN 4
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 460 THEN 3
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 460 THEN 4
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 460 THEN 5
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 450 THEN 4
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 450 THEN 5
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 450 THEN 6
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 440 THEN 5
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 440 THEN 6
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 440 THEN 7
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 430 THEN 6
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 430 THEN 7
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 430 THEN 8
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 420 THEN 7
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 420 THEN 8
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 420 THEN 9
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


                        ->get();


                    return $empleados;
                } else {
                    //  $empleados = Nomina::select('empleados.codigo_empleado', 'empleados.cedula AS cedula', 'datos_militares.codigo_categoria AS categoria', 'empleados.nombre1 AS nombre1', 'empleados.apellido1 AS apellido1', 'grados_militares.descripcion AS grado_militar', 'grados_militares.grado_a_ascender AS grado_ascender', 'datos_militares.fecha_ultimo_ascenso AS fecha_ult', 'datos_militares.fecha_graduacion AS fecha_grad')


                    $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                        ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                        ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                        ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                        ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                        ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')

                        ->where(function ($query) {
                            $query->where('empleados.situacion', 'A')
                                ->orWhere('empleados.situacion', 'S');
                        })
                        ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                        ->whereIn('datos_militares.codigo_categoria', [$categoria])
                        ->whereIn('nomina.grado_militar', [15, 20, 30, 40, 50, 60, 70, 80, 90])
                        ->where(function ($query) {
                            $query->whereRaw("MONTH(fecha_graduacion) = 7")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                                ->orWhereRaw("MONTH(fecha_graduacion) = 6");
                        })
                        ->where(function ($query) use ($fecha) {
                            $query->whereRaw("DATEDIFF('$fecha', datos_militares.fecha_ultimo_ascenso) >= CASE
WHEN nomina.grado_militar IN (090,030, 020, 15) THEN 3*365
WHEN nomina.grado_militar IN (080,070) THEN 5*365
WHEN nomina.grado_militar IN (060,050, 040) THEN 4*365
ELSE 0
END");
                        })
                        ->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',

                            DB::raw("(SELECT IFNULL(SUM(
CASE
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 090 THEN 2
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 090 THEN 5
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 090 THEN 10
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 080 THEN 4
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 080 THEN 7
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 080 THEN 12
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 070 THEN 6
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 070 THEN 9
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 070 THEN 14
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 060 THEN 8
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 060 THEN 11
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 060 THEN 16
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 050 THEN 10
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 050 THEN 13
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 050 THEN 18
WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 040 THEN 12
WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 040 THEN 15
WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 040 THEN 20
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


                        ->get();


                    return $empleados;
                }
            }
        } catch (\Exception $e) {
            $mensaje = "Error en la consulta: " . $e->getMessage();
            return $mensaje;
        }

        //dd($empleados);

        //completar consulta 
        /*

    ->orderBy('empleados.cedula')
            ->get()
            ->toArray();



        DB::statement('CREATE TEMPORARY TABLE empleados_temporal_excel (
            codigo_empleado INT,
            cedula VARCHAR(50),
            nombre1 VARCHAR(50),
            apellido1 VARCHAR(50),
            grado_militar VARCHAR(50),
            grado_ascender VARCHAR(50),
            punto INT,
            demerito FLOAT
        )');

        DB::table('empleados_temporal_excel')->insert($empleados);


        //dd($empleados);




        // Loop through all the pages of results

        // Retrieve the current page of results
        $empleados_temporal = DB::table('empleados_temporal_excel')->get();
        // Rest of the query
*/


        // Generate the PDF report for the current page
        // ...


    }
    public function todo_reporte($periodo, $fecha)
    {
        try {
            ini_set('max_execution_time', 3600);


            $empleados = [];
            $datos = "";
            $complementoTitulo = '';
            $grado = '';




            //  $empleados = Nomina::select('empleados.codigo_empleado', 'empleados.cedula AS cedula', 'datos_militares.codigo_categoria AS categoria', 'empleados.nombre1 AS nombre1', 'empleados.apellido1 AS apellido1', 'grados_militares.descripcion AS grado_militar', 'grados_militares.grado_a_ascender AS grado_ascender', 'datos_militares.fecha_ultimo_ascenso AS fecha_ult', 'datos_militares.fecha_graduacion AS fecha_grad')
            if ($periodo == 'diciembre') {

                $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                    ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                    ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                    ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                    ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                    ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')

                    ->where(function ($query) {
                        $query->where('empleados.situacion', 'A')
                            ->orWhere('empleados.situacion', 'S');
                    })
                    ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                    ->whereIn('datos_militares.codigo_categoria', [4, 5, 6, 7, 2])
                    ->whereIn('nomina.grado_militar', [15, 20, 30, 40, 50, 60, 70, 80, 90])
                    ->where(function ($query) {
                        $query->whereRaw("MONTH(fecha_graduacion) = 11")
                            ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                            ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                    })
                    ->where(function ($query) use ($fecha) {
                        $query->whereRaw("DATEDIFF('$fecha', datos_militares.fecha_ultimo_ascenso) >= CASE
        WHEN nomina.grado_militar IN (090,030, 020, 15) THEN 3*365
        WHEN nomina.grado_militar IN (080,070) THEN 5*365
        WHEN nomina.grado_militar IN (060,050, 040) THEN 4*365
        ELSE 0
    END");
                    })
                    ->select(
                        'empleados.codigo_empleado',
                        'datos_militares.codigo_categoria as categoria',
                        'empleados.cedula as cedula',
                        'empleados.nombre1 as nombre1',
                        'empleados.apellido1 as apellido1',
                        'grados_militares.descripcion as grado_militar',
                        'grados_militares.grado_a_ascender as grado_ascender',

                        DB::raw("(SELECT IFNULL(SUM(
            CASE
            WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 090 THEN 2
            WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 090 THEN 5
            WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 090 THEN 10
            WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 080 THEN 4
            WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 080 THEN 7
            WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 080 THEN 12
            WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 070 THEN 6
            WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 070 THEN 9
            WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 070 THEN 14
            WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 060 THEN 8
            WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 060 THEN 11
            WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 060 THEN 16
            WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 050 THEN 10
            WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 050 THEN 13
            WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 050 THEN 18
            WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 040 THEN 12
            WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 040 THEN 15
            WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 040 THEN 20
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

                    )->unionAll(function ($query) use ($fecha) {
                        $query->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',

                            DB::raw("(SELECT IFNULL(SUM(
                CASE
                WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 470 THEN 2
                WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 470 THEN 3
                WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 470 THEN 4
                WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 460 THEN 3
                WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 460 THEN 4
                WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 460 THEN 5
                WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 450 THEN 4
                WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 450 THEN 5
                WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 450 THEN 6
                WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 440 THEN 5
                WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 440 THEN 6
                WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 440 THEN 7
                WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 430 THEN 6
                WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 430 THEN 7
                WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 430 THEN 8
                WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 420 THEN 7
                WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 420 THEN 8
                WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 420 THEN 9
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
                            ->from('nomina')
                            ->join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereIn('datos_militares.codigo_categoria', [8])
                            ->whereIn('nomina.grado_militar', [420, 430, 440, 450, 460, 470])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 11")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 12")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 1");
                            })
                            ->where(function ($query) use ($fecha) {
                                $query->whereRaw("DATEDIFF('$fecha', datos_militares.fecha_ultimo_ascenso) >= CASE
                WHEN nomina.grado_militar IN (470) THEN 3*365
                WHEN nomina.grado_militar IN (460,450,440) THEN 5*365
                WHEN nomina.grado_militar IN (430,420) THEN 4*365
                ELSE 0
            END");
                            });
                    })
                    ->get()
                    ->toArray();
                return $empleados;
            } else {

                $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                    ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                    ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                    ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                    ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                    ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')

                    ->where(function ($query) {
                        $query->where('empleados.situacion', 'A')
                            ->orWhere('empleados.situacion', 'S');
                    })
                    ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                    ->whereIn('datos_militares.codigo_categoria', [4, 5, 6, 7, 2])
                    ->whereIn('nomina.grado_militar', [15, 20, 30, 40, 50, 60, 70, 80, 90])
                    ->where(function ($query) {
                        $query->whereRaw("MONTH(fecha_graduacion) = 7")
                            ->orWhereRaw("MONTH(fecha_graduacion) = 8")
                            ->orWhereRaw("MONTH(fecha_graduacion) = 6");
                    })
                    ->where(function ($query) use ($fecha) {
                        $query->whereRaw("DATEDIFF('$fecha', datos_militares.fecha_ultimo_ascenso) >= CASE
                WHEN nomina.grado_militar IN (090,030, 020, 15) THEN 3*365
                WHEN nomina.grado_militar IN (080,070) THEN 5*365
                WHEN nomina.grado_militar IN (060,050, 040) THEN 4*365
                ELSE 0
            END");
                    })
                    ->select(
                        'empleados.codigo_empleado',
                        'datos_militares.codigo_categoria as categoria',
                        'empleados.cedula as cedula',
                        'empleados.nombre1 as nombre1',
                        'empleados.apellido1 as apellido1',
                        'grados_militares.descripcion as grado_militar',
                        'grados_militares.grado_a_ascender as grado_ascender',

                        DB::raw("(SELECT IFNULL(SUM(
                    CASE
                    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 090 THEN 2
                    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 090 THEN 5
                    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 090 THEN 10
                    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 080 THEN 4
                    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 080 THEN 7
                    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 080 THEN 12
                    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 070 THEN 6
                    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 070 THEN 9
                    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 070 THEN 14
                    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 060 THEN 8
                    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 060 THEN 11
                    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 060 THEN 16
                    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 050 THEN 10
                    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 050 THEN 13
                    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 050 THEN 18
                    WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 040 THEN 12
                    WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 040 THEN 15
                    WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 040 THEN 20
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

                    )->unionAll(function ($query) use ($fecha) {
                        $query->select(
                            'empleados.codigo_empleado',
                            'datos_militares.codigo_categoria as categoria',
                            'empleados.cedula as cedula',
                            'empleados.nombre1 as nombre1',
                            'empleados.apellido1 as apellido1',
                            'grados_militares.descripcion as grado_militar',
                            'grados_militares.grado_a_ascender as grado_ascender',

                            DB::raw("(SELECT IFNULL(SUM(
                        CASE
                        WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 470 THEN 2
                        WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 470 THEN 3
                        WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 470 THEN 4
                        WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 460 THEN 3
                        WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 460 THEN 4
                        WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 460 THEN 5
                        WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 450 THEN 4
                        WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 450 THEN 5
                        WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 450 THEN 6
                        WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 440 THEN 5
                        WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 440 THEN 6
                        WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 440 THEN 7
                        WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 430 THEN 6
                        WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 430 THEN 7
                        WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 430 THEN 8
                        WHEN datos_boleta.naturaleza = 1 AND nomina.grado_militar = 420 THEN 7
                        WHEN datos_boleta.naturaleza = 2 AND nomina.grado_militar = 420 THEN 8
                        WHEN datos_boleta.naturaleza = 3 AND nomina.grado_militar = 420 THEN 9
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
                            ->from('nomina')
                            ->join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                            ->where(function ($query) {
                                $query->where('empleados.situacion', 'A')
                                    ->orWhere('empleados.situacion', 'S');
                            })
                            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                            ->whereIn('datos_militares.codigo_categoria', [8])
                            ->whereIn('nomina.grado_militar', [420, 430, 440, 450, 460, 470])
                            ->where(function ($query) {
                                $query->whereRaw("MONTH(fecha_graduacion) = 4")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 5")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 6")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 7")
                                    ->orWhereRaw("MONTH(fecha_graduacion) = 8");
                            })
                            ->where(function ($query) use ($fecha) {
                                $query->whereRaw("DATEDIFF('$fecha', datos_militares.fecha_ultimo_ascenso) >= CASE
                        WHEN nomina.grado_militar IN (470) THEN 3*365
                        WHEN nomina.grado_militar IN (460,450,440) THEN 5*365
                        WHEN nomina.grado_militar IN (430,420) THEN 4*365
                        ELSE 0
                    END");
                            });
                    })
                    ->get()
                    ->toArray();
                return $empleados;
            }
        } catch (\Exception $e) {
            // Manejo del error en la consulta
            $mensaje = "Error en la consulta: " . $e->getMessage();
            return $mensaje;
        }





        //dd($empleados);

        //completar consulta 
        /*

    ->orderBy('empleados.cedula')
            ->get()
            ->toArray();



        DB::statement('CREATE TEMPORARY TABLE empleados_temporal_excel (
            codigo_empleado INT,
            cedula VARCHAR(50),
            nombre1 VARCHAR(50),
            apellido1 VARCHAR(50),
            grado_militar VARCHAR(50),
            grado_ascender VARCHAR(50),
            punto INT,
            demerito FLOAT
        )');

        DB::table('empleados_temporal_excel')->insert($empleados);


        //dd($empleados);




        // Loop through all the pages of results

        // Retrieve the current page of results
        $empleados_temporal = DB::table('empleados_temporal_excel')->get();
        // Rest of the query
*/


        // Generate the PDF report for the current page
        // ...


    }

    public function descargarEmpleados(Request $request)
    {

        //$mensaje = null;
        $fecha = $request->input('fecha');
        $periodo = $request->input('periodo');
        $categoria = $request->input('select_categoria');
        $ofi = $request->input('select_gradoOF');
        $tropap = $request->input('select_gradoTP');
        $tipo = $request->input('select_tipo');
        $parte_todo = $request->input('parte_todo');
        // $empleados = [];
        $empleados = collect();



        // $empleados = $this->ascreporter2($request);

        // $empleados = $this->ascreporter2($coma, $ofi);
        //  if ($empleados) {

        // dd($tipo);

        if ($parte_todo == 'todo') {

            //  $empleados = $this->todo_reporte($periodo, $fecha);


            if ($tipo == "Seleccionar..." || $periodo == "Seleccionar..." || $fecha == null) {


                $mensaje = "Completar los Campos.";
                // return view('juntap.reportes.reporteascenso')->with('mensaje', $mensaje);
                // return echo "<script>mostrarMensaje('$mensaje');</script>";
                return view('juntap.reportes.reporteascenso', ['mensaje' => $mensaje]);
            } else {


                if($tipo =='pdf'){


                    $mensaje = "Error al Completar los Campos.";
                    // return view('juntap.reportes.reporteascenso')->with('mensaje', $mensaje);
                    // return echo "<script>mostrarMensaje('$mensaje');</script>";
                    return view('juntap.reportes.reporteascenso', ['mensaje' => $mensaje]);

                }else{


// dd($empleados);
$empleados = $this->todo_reporte($periodo, $fecha);
if (is_array($empleados) && count($empleados) == 0) {
    // Función para eliminar la columna 'puesto'

    // Eliminar la columna 'puesto' del arreglo "$empleados"


    $mensaje = "No se Encontraron los Registros.";
    // return view('juntap.reportes.reporteascenso')->with('mensaje', $mensaje);
    // return echo "<script>mostrarMensaje('$mensaje');</script>";
    return view('juntap.reportes.reporteascenso', ['mensaje' => $mensaje]);
} else if (is_string($empleados)) {

    return view('juntap.reportes.reporteascenso', ['mensaje_error' => $empleados]);
} else {


    if ($tipo == "excel") {




        // Función para eliminar la columna 'puesto'

        // Eliminar la columna 'puesto' del arreglo "$empleados"
        $empleados = array_map(function ($fila) {
            unset($fila['punto']);
            return $fila;
        }, $empleados);


        $empleados = collect($empleados);
        $nombre_archivo = sprintf('ReportePersonalMilitarTentativoAscenso %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));

        $titulo = 'REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO ';

        // $file= Excel::download(new juntapExport($empleados, $titulo), $nombre_archivo);

        return Excel::download(new juntapExport($empleados, $titulo), $nombre_archivo);
        //return $mensaje;
        // Retorna un mensaje JSON si no hay resultados

    } else {

        // dd($empleados);



        $mensaje = "Error al Completar los Campos.";
        // return view('juntap.reportes.reporteascenso')->with('mensaje', $mensaje);
        // return echo "<script>mostrarMensaje('$mensaje');</script>";
        return view('juntap.reportes.reporteascenso', ['mensaje' => $mensaje]);
    }
}


                }
                
            }
            /*


                // dd($empleados);
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadView('juntap.reportes.reporteascPDF', compact('empleados'));
              
                // Set the paper size and orientation
                $pdf->setPaper('letter', 'portrait');
              
                // Generate the PDF file and return it as a response
                return $pdf->download('reporte.pdf');


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


               */
        } else if ($parte_todo == 'cat') {




            if ($tipo == "Seleccionar..." || $periodo == "Seleccionar..." || $fecha == null || $categoria == "Seleccionar...") {


                $mensaje = "Completar los Campos.";
                // return view('juntap.reportes.reporteascenso')->with('mensaje', $mensaje);
                // return echo "<script>mostrarMensaje('$mensaje');</script>";
                return view('juntap.reportes.reporteascenso', ['mensaje' => $mensaje]);
            } else {

                // dd($empleados);
                $empleados = $this->cat_reporte($periodo, $fecha, $categoria);

                if (is_array($empleados) && count($empleados) == 0) {
                    // Función para eliminar la columna 'puesto'

                    // Eliminar la columna 'puesto' del arreglo "$empleados"


                    $mensaje = "No se Encontraron los Registros.";
                    // return view('juntap.reportes.reporteascenso')->with('mensaje', $mensaje);
                    // return echo "<script>mostrarMensaje('$mensaje');</script>";
                    return view('juntap.reportes.reporteascenso', ['mensaje' => $mensaje]);
                } else if (is_string($empleados)) {

                    return view('juntap.reportes.reporteascenso', ['mensaje_error' => $empleados]);
                } else {
                    if ($tipo == "excel") {



                        // Función para eliminar la columna 'puesto'

                        // Eliminar la columna 'puesto' del arreglo "$empleados"
                        $empleados = array_map(function ($fila) {
                            unset($fila['punto']);
                            return $fila;
                        }, $empleados);


                        $empleados = collect($empleados);
                        $nombre_archivo = sprintf('ReportePersonalMilitarTentativoAscenso %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));

                        $titulo = 'REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO ';

                        // $file= Excel::download(new juntapExport($empleados, $titulo), $nombre_archivo);

                        return Excel::download(new juntapExport($empleados, $titulo), $nombre_archivo);
                        //return $mensaje;
                        // Retorna un mensaje JSON si no hay resultados

                    } else if ($tipo == "pdf") {

                        // dd($empleados);



                        ini_set('max_execution_time', 3600);


                        $empleados = $this->cat_reporte_pdf($periodo, $fecha, $categoria);

                        //dd($empleados);


                        /*
                            $empleados = array_map(function ($fila) {
                                unset($fila['punto']);
                                return $fila;
                            }, $empleados);
    */
                        $pdf = \PDF::loadview('juntap.reportes.reporteascPDF', compact('empleados'))->setPaper('a4', 'landscape');
                        $fileName = 'ReportePersonalMilitarTentativoAscenso' . date('Y-m-d_H-i-s') . '.pdf';

                        return $pdf->download($fileName);
                    } else {

                        $mensaje = "Error al Completar los Campos.";
                        // return view('juntap.reportes.reporteascenso')->with('mensaje', $mensaje);
                        // return echo "<script>mostrarMensaje('$mensaje');</script>";
                        return view('juntap.reportes.reporteascenso', ['mensaje' => $mensaje]);
                    }
                }
            }
        } else if ($parte_todo == 'grado') {

            if ($tipo == "Seleccionar..." || $periodo == "Seleccionar..." || $fecha == null || $categoria == "Seleccionar...") {


                $mensaje = "Completar los Campos.";
                // return view('juntap.reportes.reporteascenso')->with('mensaje', $mensaje);
                // return echo "<script>mostrarMensaje('$mensaje');</script>";
                return view('juntap.reportes.reporteascenso', ['mensaje' => $mensaje]);
            } else  if ($ofi != "Seleccionar...") {




                $empleados = $this->ascreporte($periodo, $categoria, $ofi, $tropap, $fecha);



                if (is_array($empleados) && count($empleados) == 0) {
                    // Función para eliminar la columna 'puesto'

                    // Eliminar la columna 'puesto' del arreglo "$empleados"


                    $mensaje = "No se Encontraron los Registros.";
                    // return view('juntap.reportes.reporteascenso')->with('mensaje', $mensaje);
                    // return echo "<script>mostrarMensaje('$mensaje');</script>";
                    return view('juntap.reportes.reporteascenso', ['mensaje' => $mensaje]);
                } else if (is_string($empleados)) {

                    return view('juntap.reportes.reporteascenso', ['mensaje_error' => $empleados]);
                } else {



                    if ($tipo == "excel") {


                        $empleados = array_map(function ($fila) {
                            unset($fila['punto']);
                            return $fila;
                        }, $empleados);


                        $empleados = collect($empleados);

                        $nombre_archivo = sprintf('ReportePersonalMilitarTentativoAscenso %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));

                        $titulo = 'REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO ';

                        // $file= Excel::download(new juntapExport($empleados, $titulo), $nombre_archivo);

                        return Excel::download(new juntapExport($empleados, $titulo), $nombre_archivo);
                        //return $mensaje;
                        // Retorna un mensaje JSON si no hay resultados

                    } else if ($tipo == "pdf") {

                        // dd($empleados);



                        ini_set('max_execution_time', 3600);


                        $empleados = $this->ascreporte_pdf($periodo, $categoria, $ofi, $tropap, $fecha);

                        //dd($empleados);


                        /*
                        $empleados = array_map(function ($fila) {
                            unset($fila['punto']);
                            return $fila;
                        }, $empleados);
*/
                        $pdf = \PDF::loadview('juntap.reportes.reporteascPDF', compact('empleados'))->setPaper('a4', 'landscape');
                        $fileName = 'ReportePersonalMilitarTentativoAscenso' . date('Y-m-d_H-i-s') . '.pdf';

                        return $pdf->download($fileName);
                    } else {

                        $mensaje = "Error al Completar los Campos.";
                        // return view('juntap.reportes.reporteascenso')->with('mensaje', $mensaje);
                        // return echo "<script>mostrarMensaje('$mensaje');</script>";
                        return view('juntap.reportes.reporteascenso', ['mensaje' => $mensaje]);
                    }
                }













                // dd($empleados);) {

                //ofi seleccionar

            } else {


                if ($tropap != "Seleccionar...") {

                    $empleados = $this->ascreporte($periodo, $categoria, $ofi, $tropap, $fecha);

                    if (is_array($empleados) && count($empleados) == 0) {
                        // Función para eliminar la columna 'puesto'

                        // Eliminar la columna 'puesto' del arreglo "$empleados"


                        $mensaje = "No se Encontraron los Registros.";
                        // return view('juntap.reportes.reporteascenso')->with('mensaje', $mensaje);
                        // return echo "<script>mostrarMensaje('$mensaje');</script>";
                        return view('juntap.reportes.reporteascenso', ['mensaje' => $mensaje]);
                    } else if (is_string($empleados)) {

                        return view('juntap.reportes.reporteascenso', ['mensaje_error' => $empleados]);
                    } else {



                        if ($tipo == "excel") {






                            $empleados = $this->ascreporte($periodo, $categoria, $ofi, $tropap, $fecha);


                            // Función para eliminar la columna 'puesto'

                            // Eliminar la columna 'puesto' del arreglo "$empleados"
                            $empleados = array_map(function ($fila) {
                                unset($fila['punto']);
                                return $fila;
                            }, $empleados);


                            $empleados = collect($empleados);

                            $nombre_archivo = sprintf('ReportePersonalMilitarTentativoAscenso %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));

                            $titulo = 'REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO ';

                            // $file= Excel::download(new juntapExport($empleados, $titulo), $nombre_archivo);

                            return Excel::download(new juntapExport($empleados, $titulo), $nombre_archivo);
                            //return $mensaje;
                            // Retorna un mensaje JSON si no hay resultados

                        } else if ($tipo == "pdf") {

                            // dd($empleados);



                            ini_set('max_execution_time', 3600);




                            //dd($empleados);



                            $empleados = $this->ascreporte_pdf($periodo, $categoria, $ofi, $tropap, $fecha);
                            /*
  $empleados = array_map(function ($fila) {
                                unset($fila['punto']);
                                return $fila;
                            }, $empleados);
*/
                            $pdf = \PDF::loadview('juntap.reportes.reporteascPDF', compact('empleados'))->setPaper('a4', 'landscape');
                            $fileName = 'ReportePersonalMilitarTentativoAscenso' . date('Y-m-d_H-i-s') . '.pdf';

                            return $pdf->download($fileName);
                        } else {


                            $mensaje = "Error al Completar los Campos.";
                            // return view('juntap.reportes.reporteascenso')->with('mensaje', $mensaje);
                            // return echo "<script>mostrarMensaje('$mensaje');</script>";
                            return view('juntap.reportes.reporteascenso', ['mensaje' => $mensaje]);
                        }
                    }
                } else {


                    $mensaje = "Error al Completar los Campos.";
                    // return view('juntap.reportes.reporteascenso')->with('mensaje', $mensaje);
                    // return echo "<script>mostrarMensaje('$mensaje');</script>";
                    return view('juntap.reportes.reporteascenso', ['mensaje' => $mensaje]);
                }
            }











            //todo,cat,grado



        } else {


            $mensaje = "Error al Completar los Campos.";
            // return view('juntap.reportes.reporteascenso')->with('mensaje', $mensaje);
            // return echo "<script>mostrarMensaje('$mensaje');</script>";
            return view('juntap.reportes.reporteascenso', ['mensaje' => $mensaje]);
        }



















        //funcion


    }















    ///////////////////////////////////////////////////////aparicio/////////////////////////////






    public function ingresoPersonal()
    {
        $user_auth = auth()->user();

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

        return view(
            'sireh.personal.ingreso',
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
                'profesiones'
            )
        );
    }

    public function registraPersonal(Request $request)
    {

        $this->validate(
            $request,
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
            $codigo_empleado = Empleado::max('codigo_empleado') + 1;
            if ($request->file("foto")) {
                $ext = $request->file('foto')->getClientOriginalExtension();
                $file_name = 'empleado_' . $codigo_empleado . '.' . $ext;

                $path_foto = 'fotos/empleados/' . $file_name;
                if (file_exists($path_foto)) {
                    unlink($path_foto); // Eliminamos la imagen previa si existe.
                }
                Image::make($request->file('foto'))->save(public_path($path_foto));
            } else {
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

            if ($request->contingente) {
                $datos_militares = new DatosMilitares;
                $datos_militares->codigo_empleado = $empleado->codigo_empleado;
                $datos_militares->contingente = $request->contingente;
                $datos_militares->save();
            }
            if (!empty($request->universidad) || !empty($request->profesion)) {
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
        $user_auth = auth()->user();

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
        $historico_ascenso = HistoricoAscensos::all();
        $datos = Empleado::with(['nomina', 'datos_militares', 'estudios_realizados'])->find($id);

        return view(
            'sireh.personal.edit-ingreso',
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
                'profesiones'
            )
        );
    }

    public function updatePersonal(Empleado $empleado, Request $request)
    {

        $this->validate(
            $request,
            [
                'tipo_emp' => 'required',
                'cedula' => 'required|unique:empleados,cedula,' . $empleado->id,
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
            if ($request->file("foto")) {
                $ext = $request->file('foto')->getClientOriginalExtension();
                $file_name = 'empleado_' . $empleado->codigo_empleado . '.' . $ext;

                $path_foto = 'fotos/empleados/' . $file_name;
                if (file_exists($path_foto)) {
                    unlink($path_foto); // Eliminamos la imagen previa si existe.
                }
                //$path = $request->file("foto")->store($path);
                Image::make($request->file('foto'))->save(public_path($path_foto));
            } else {
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
                $empleado->foto = $path_foto;
            }
            $empleado->correo = $request->correo;
            $empleado->save();

            $nomina = Nomina::where('codigo_empleado', $empleado->codigo_empleado)->first();
            $nomina->cedula = $empleado->cedula;
            $nomina->tipo_emp = $request->tipo_emp;
            $nomina->codigo_ubicacion = $request->ubicacion;
            $nomina->fecha_ingreso = $request->fecha_ingreso;
            $nomina->codigo_cargo = !empty($request->cargo) ? $request->cargo : null;
            $nomina->grado_militar = !empty($request->grado_militar) ? $request->grado_militar : null;
            $nomina->cod_rac = !empty($request->cod_rac) ? $request->cod_rac : null;
            $nomina->cod_ubicacion_detallada = $request->ubicacion_det;
            $nomina->save();

            if ($request->contingente) {
                $datos_militares = DatosMilitares::where('codigo_empleado', $empleado->codigo_empleado)->first();
                $datos_militares->contingente = $request->contingente;
                $datos_militares->save();
            }
            if (!empty($request->universidad) || !empty($request->profesion)) {
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
        $nomina = Nomina::where('codigo_empleado', $empleado->codigo_empleado)->first();
        $nomina->delete();
        $datos_militares = DatosMilitares::where('codigo_empleado', $empleado->codigo_empleado)->first();
        $datos_militares->delete();
        $estudios_realizados = EstudiosRealizados::where('codigo_empleado', $empleado->codigo_empleado)->first();
        $estudios_realizados->delete();
        $empleado->delete();

        return redirect()->route('sireh.ingreso-personal.index')
            ->with('success', 'Eliminado satisfactoriamente');
    }

    public function activarIngreso(Empleado $empleado)
    {
        try {
            $empleado->situacion = 'A';
            $empleado->save();
            $nomina = Nomina::where('codigo_empleado', $empleado->codigo_empleado)->first();
            $nomina->situacion = 'A';
            $nomina->save();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }

    //Obtiene los empleados registrados aun sin activar el Ingreso, exclusivo por api para el Datatable
    public function empleadosInactivos(Request $request)
    {
        $empleados = Empleado::where('empleados.situacion', 'I');
        $empleados->join('nomina', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado');
        $empleados->join('tipos_empleados', 'tipos_empleados.tipo_emp', '=', 'nomina.tipo_emp');
        $empleados->join('ubicaciones', 'ubicaciones.codigo_ubicacion', '=', 'nomina.codigo_ubicacion');
        $empleados->leftJoin('cargos', 'cargos.codigo_cargo', '=', 'nomina.codigo_cargo');
        $empleados->leftJoin('grados_militares', 'grados_militares.codigo_grado', '=', 'nomina.grado_militar');
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
        $datatable = Datatables::of($empleados)
            ->addColumn('actions', 'sireh.personal._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    //Obtiene el personal militar, exclusivo por api para el Datatable
    public function personalMilitarJunta(Request $request)
    {

        $empleados = Empleado::where(function ($query) {
            $query->where('nomina.situacion', 'A')
                ->orWhere('nomina.situacion', 'S');
        });
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
            'ubicaciones.descripcion as ubicacion'
        );
        $datatable = Datatables::of($empleados)
            ->addColumn('actions', 'juntap.personalm._actions')
            ->rawColumns(['actions']);


        return $datatable->make(true);
    }

    //Obtiene el personal Civil, exclusivo por api para el Datatable
    public function personalCivil(Request $request)
    {
        $empleados = Empleado::where(function ($query) {
            $query->where('empleados.situacion', 'A')
                ->orWhere('empleados.situacion', 'S');
        });
        //$empleados = Empleado::where('empleados.situacion', '<>','');
        $empleados->join('nomina', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado');
        $empleados->join('tipos_empleados', 'tipos_empleados.tipo_emp', '=', 'nomina.tipo_emp');
        $empleados->join('ubicaciones', 'ubicaciones.codigo_ubicacion', '=', 'nomina.codigo_ubicacion');
        $empleados->join('cargos', 'cargos.codigo_cargo', '=', 'nomina.codigo_cargo');
        $empleados->whereNotIn('nomina.tipo_emp', ['MIL', 'TRP', 'ALI', 'MEF']);
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
        $datatable = Datatables::of($empleados)
            ->addColumn('actions', 'sireh.personal.civil._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    //Obtiene el personal militar no profesional, exclusivo por api para el Datatable
    public function personalMilitarNoProf(Request $request)
    {
        $empleados = Empleado::where(function ($query) {
            $query->where('empleados.situacion', 'A')
                ->orWhere('empleados.situacion', 'S');
        });
        $empleados->join('nomina', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado');
        $empleados->join('tipos_empleados', 'tipos_empleados.tipo_emp', '=', 'nomina.tipo_emp');
        $empleados->join('ubicaciones', 'ubicaciones.codigo_ubicacion', '=', 'nomina.codigo_ubicacion');
        $empleados->join('grados_militares', 'grados_militares.codigo_grado', '=', 'nomina.grado_militar');
        $empleados->whereIn('nomina.tipo_emp', ['ALI', 'MEF']);
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
            ->addColumn('actions', 'sireh.personal.militar_noprof._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    //Obtiene los empleados sin asociar Usuario, exclusivo por api para el Datatable
    public function empleadosSinUser(Request $request)
    {
        $empleados = Empleado::whereNull('user_id')->where('empleados.situacion', 'A');
        $empleados->join('nomina', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado');
        $empleados->join('tipos_empleados', 'tipos_empleados.tipo_emp', '=', 'nomina.tipo_emp');
        $empleados->join('ubicaciones', 'ubicaciones.codigo_ubicacion', '=', 'nomina.codigo_ubicacion');
        $empleados->join('cargos', 'cargos.codigo_cargo', '=', 'nomina.codigo_cargo');
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
        $datatable = Datatables::of($empleados)
            ->addColumn('actions', 'users._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    //Obtiene los empleados que no son del componente Aviacion sin asociar Usuario, exclusivo por api para el Datatable
    public function notEmpleadosSinUser(Request $request)
    {
        $empleados = EmpleadosOtroComponente::whereNull('user_id');
        $empleados->join('ubicaciones', 'ubicaciones.codigo_ubicacion', '=', 'empleados_otro_componente.codigo_ubicacion');
        $empleados->select(
            'empleados_otro_componente.id',
            'empleados_otro_componente.cedula',
            'empleados_otro_componente.nombre1',
            'empleados_otro_componente.nombre2',
            'empleados_otro_componente.apellido1',
            'empleados_otro_componente.apellido2',
            'ubicaciones.descripcion as ubicacion',
        );
        $datatable = Datatables::of($empleados)
            ->addColumn('actions', 'users._actions2')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function viewPersonalMilitarNoProf($id)
    {
        $user_auth = auth()->user();

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
        $datos = Empleado::with(['nomina', 'datos_militares', 'estudios_realizados'])->find($id);
        return view(
            'juntap.personalm.view',
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
                'datos_militares'
            )
        );
    }

    public function viewPersonalMilitar($id)
    {
        $user_auth = auth()->user();

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
        $historico_ascensos = HistoricoAscensos::all();
        $especialidades_militares = EspecialidadesMilitares::all();
        $datos = Empleado::with(['nomina', 'datos_militares'])->find($id);
        $empleado = Empleado::find($id);
        $codigo_empleado = $empleado->codigo_empleado;

        $categoriasPermitidas = [2, 4, 5, 6, 7, 8];

        $categoria = DB::table('datos_militares')
            ->where('codigo_empleado', $codigo_empleado)
            ->value('codigo_categoria');
            $fecha_ult = DB::table('datos_militares')
            ->where('codigo_empleado', $codigo_empleado)
            ->value('fecha_ultimo_ascenso');

        $grado = DB::table('nomina')
            ->where('codigo_empleado', $codigo_empleado)
            ->pluck('grado_militar')
            ->first();



if($grado==410 || $grado == 10){

 // El personal no está tentativo a ascender
 $empleados = 'false';
 // Tu lógica aquí
 $fechaAscenso=0;



}elseif(in_array($categoria, $categoriasPermitidas)){
    if (strtotime($fecha_ult) === false || $fecha_ult === "0000-00-00") {
        $empleados = 'null';
        $fechaAscenso=0;
    }else{

   
    if ($categoria == 8) {




        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
            ->where(function ($query) {
                $query->where('empleados.situacion', 'A')
                    ->orWhere('empleados.situacion', 'S');
            })
            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
            ->whereIn('datos_militares.codigo_categoria', [$categoria])
            ->whereIn('nomina.grado_militar', [$grado])
            ->where('empleados.codigo_empleado', $codigo_empleado)
            ->select('empleados.codigo_empleado', 'datos_militares.codigo_categoria AS categoria', 'empleados.cedula', 'empleados.nombre1', 'empleados.apellido1', 'grados_militares.descripcion AS grado_militar', 'grados_militares.grado_a_ascender AS grado_ascender')
            ->selectRaw('DATE_ADD(datos_militares.fecha_ultimo_ascenso, INTERVAL 
           CASE
               WHEN nomina.grado_militar IN (470) THEN 3
               WHEN nomina.grado_militar IN (460, 450, 440) THEN 5
               WHEN nomina.grado_militar IN (430, 420) THEN 4
               ELSE 0
           END YEAR) AS fecha_ascenso')
            ->first();

        if ($empleados == null) {

            $empleados = 'null';
            $fechaAscenso=0;



        } else {


            $fechaAscenso = $empleados->fecha_ascenso;





            //return response()->json(['ascenso' => 'true', 'mensaje' => $fechaAscenso]);


            $anioActual = date('Y'); // Obtener el año actual

            // Obtener el año de la fecha de ascenso
            $anioAscenso = date('Y', strtotime($fechaAscenso));

            if ($anioAscenso == $anioActual) {
                // El personal está tentativo a ascender este año
                $empleados = 'true';
                // Tu lógica aquí
            } elseif ($anioAscenso < $anioActual) {
                // El personal está tentativo a ascender también este año

                $fechaObj = new DateTime($fechaAscenso);

                // Actualizar el año
                $fechaObj->setDate($anioActual, $fechaObj->format('m'), $fechaObj->format('d'));

                // Obtener la nueva fecha modificada
                $nuevaFechaAsc = $fechaObj->format('Y-m-d');
                $fechaAscenso = $nuevaFechaAsc;

                $empleados = 'true';
                // Tu lógica aquí
            } elseif ($anioAscenso > $anioActual) {
                // El personal no está tentativo a ascender
                $empleados = 'false';
                // Tu lógica aquí

            }
        }
    } else {


        $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
            ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
            ->where(function ($query) {
                $query->where('empleados.situacion', 'A')
                    ->orWhere('empleados.situacion', 'S');
            })
            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
            ->whereIn('datos_militares.codigo_categoria', [$categoria])
            ->whereIn('nomina.grado_militar', [$grado])
            ->where('empleados.codigo_empleado', $codigo_empleado)
            ->select('empleados.codigo_empleado', 'datos_militares.codigo_categoria AS categoria', 'empleados.cedula', 'empleados.nombre1', 'empleados.apellido1', 'grados_militares.descripcion AS grado_militar', 'grados_militares.grado_a_ascender AS grado_ascender')
            ->selectRaw('DATE_ADD(datos_militares.fecha_ultimo_ascenso, INTERVAL 
           CASE
            WHEN nomina.grado_militar IN (090,030, 020, 15) THEN 3
            WHEN nomina.grado_militar IN (080,070) THEN 5
            WHEN nomina.grado_militar IN (060,050, 040) THEN 4
                ELSE 0
            END YEAR) AS fecha_ascenso')
            ->first();
        if ($empleados == null) {
$empleados = 'null';
    $fechaAscenso=0;
        } else {


            $fechaAscenso = $empleados->fecha_ascenso;


            //return response()->json(['ascenso' => 'true', 'mensaje' => $fechaAscenso]);


            $anioActual = date('Y'); // Obtener el año actual

            // Obtener el año de la fecha de ascenso
            $anioAscenso = date('Y', strtotime($fechaAscenso));

            if ($anioAscenso == $anioActual) {
                // El personal está tentativo a ascender este año
                $empleados = 'true';
                // Tu lógica aquí
            } elseif ($anioAscenso < $anioActual) {
                // El personal está tentativo a ascender también este año
                $fechaObj = new DateTime($fechaAscenso);

                // Actualizar el año
                $fechaObj->setDate($anioActual, $fechaObj->format('m'), $fechaObj->format('d'));

                // Obtener la nueva fecha modificada
                $nuevaFechaAsc = $fechaObj->format('Y-m-d');
                $fechaAscenso = $nuevaFechaAsc;
                $empleados = 'true';
                // Tu lógica aquí
            } elseif ($anioAscenso > $anioActual) {
                // El personal no está tentativo a ascender
                $empleados = 'false';
                // Tu lógica aquí

            }






        }


       

    }
}
}else{

    $empleados = 'null';
    $fechaAscenso=0;

    }


        return view(
            'juntap.personalm.view',

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
                'categorias_militares',
                'situaciones',
                'promociones_militares',
                'datos_militares',
                'especialidades_militares',
                'lateralidades',
                'historico_ascensos',
                'fechaAscenso',
                'empleados'
            )
        );
    }
    public function verificar_ascenso(Request $request)
    {

        try {

            $codigo_empleado = $request->input('codigoEmpleado');




            ini_set('max_execution_time', 3600);


            $empleados = [];
            $datos = "";
            $complementoTitulo = '';
            $grado = '';

            $fechaActual = date('Y-m-d');

            $categoria = DB::table('datos_militares')
                ->where('codigo_empleado', $codigo_empleado)
                ->pluck('codigo_categoria')
                ->first();

            $grado = DB::table('nomina')
                ->where('codigo_empleado', $codigo_empleado)
                ->pluck('grado_militar')
                ->first();

            if ($categoria == 8) {




                $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                    ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                    ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                    ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                    ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                    ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                    ->where(function ($query) {
                        $query->where('empleados.situacion', 'A')
                            ->orWhere('empleados.situacion', 'S');
                    })
                    ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                    ->whereIn('datos_militares.codigo_categoria', $categoria)
                    ->whereIn('nomina.grado_militar', $grado)
                    ->where('empleados.codigo_empleado', $codigo_empleado)
                    ->select('empleados.codigo_empleado', 'datos_militares.codigo_categoria AS categoria', 'empleados.cedula', 'empleados.nombre1', 'empleados.apellido1', 'grados_militares.descripcion AS grado_militar', 'grados_militares.grado_a_ascender AS grado_ascender')
                    ->selectRaw('DATE_ADD(datos_militares.fecha_ultimo_ascenso, INTERVAL 
        CASE
            WHEN nomina.grado_militar IN (470) THEN 3
            WHEN nomina.grado_militar IN (460, 450, 440) THEN 5
            WHEN nomina.grado_militar IN (430, 420) THEN 4
            ELSE 0
        END YEAR) AS fecha_ascenso')
                    ->first();

                $fechaAscenso = $empleados->fecha_ascenso;


                //return response()->json(['ascenso' => 'true', 'mensaje' => $fechaAscenso]);


                $anioActual = date('Y'); // Obtener el año actual

                // Obtener el año de la fecha de ascenso
                $anioAscenso = date('Y', strtotime($fechaAscenso));

                if ($anioAscenso == $anioActual) {
                    // El personal está tentativo a ascender este año
                    return $empleados = true;
                    // Tu lógica aquí
                } elseif ($anioAscenso < $anioActual) {
                    // El personal está tentativo a ascender también este año
                    return $empleados = true;
                    // Tu lógica aquí
                } elseif ($anioAscenso > $anioActual) {
                    // El personal no está tentativo a ascender
                    return $empleados = false;
                    // Tu lógica aquí

                }
            } else {
                $fecha = 0;
                $empleados = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                    ->join('tipos_empleados', 'nomina.tipo_emp', '=', 'tipos_empleados.tipo_emp')
                    ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
                    ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
                    ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
                    ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')

                    ->where('empleados.situacion', 'A')
                    ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                    ->whereIn('datos_militares.codigo_categoria', [$categoria])
                    ->whereIn('nomina.grado_militar', [15, 20, 30, 40, 50, 60, 70, 80, 90])

                    ->where(function ($query) use ($fecha) {
                        $query->whereRaw("DATEDIFF('$fecha', datos_militares.fecha_ultimo_ascenso) >= CASE
        WHEN nomina.grado_militar IN (090,030, 020, 15) THEN 3*365
        WHEN nomina.grado_militar IN (080,070) THEN 5*365
        WHEN nomina.grado_militar IN (060,050, 040) THEN 4*365
        ELSE 0
        END");
                    })
                    ->select(
                        'empleados.codigo_empleado',
                        'datos_militares.codigo_categoria as categoria',
                        'empleados.cedula as cedula',
                        'empleados.nombre1 as nombre1',
                        'empleados.apellido1 as apellido1',
                        'grados_militares.descripcion as grado_militar',
                        'grados_militares.grado_a_ascender as grado_ascender',

                    )


                    ->get()
                    ->toArray();



                return response()->json($empleados);
            }
        } catch (\Exception $e) {
            $mensaje = "Error en la consulta: " . $e->getMessage();

            return response()->json($mensaje);
        }
    }
    public function editPersonalMilitar($id)
    {
        $user_auth = auth()->user();

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
        $historico_ascensos = HistoricoAscensos::all();
        $promociones_militares = PromocionesMilitares::all();
        $datos = Empleado::with(['nomina', 'datos_militares', 'estudios_realizados'])->find($id);
        return view(
            'juntap.personalm.edit',
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
                'datos_militares',
                'categorias_militares',
                'situaciones',
                'promociones_militares',
                'lateralidades',
                'historico_ascensos'
            )
        );
    }

    public function updatePersonalMilitar(Request $request)
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
                'grado_militar.required' => 'El grado militar es requerido',
                'total_orden_merito.required' => 'El orden de merito total es requerido',
                'orden_merito.required' => 'El orden merito es requerido',







            ]
        );
        try {
            if ($request->file("foto")) {
                $ext = $request->file('foto')->getClientOriginalExtension();
                $file_name = 'empleado_' . $request->codigo_empleado . '.' . $ext;

                $path_foto = 'fotos/empleados/' . $file_name;
                if (file_exists($path_foto)) {
                    unlink($path_foto); // Eliminamos la imagen previa si existe.
                }
                Image::make($request->file('foto'))->save(public_path($path_foto));
            } else {
                $path_foto = null;
            }

            $empleado = Empleado::where('codigo_empleado', $request->codigo_empleado)->update([
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

            $nomina = Nomina::where('codigo_empleado', $request->codigo_empleado)->update([
                "cedula" => $request->cedula,
                "tipo_emp" => $request->tipo_emp,
                "grado_militar" => !empty($request->grado_militar) ? $request->grado_militar : null,
            ]);

            $datos_militares = DatosMilitares::where('codigo_empleado', $request->codigo_empleado)->update([
                "codigo_categoria" => $request->categoria,
                "codigo_promocion" => !empty($request->promocion) ? $request->promocion : null,
                "total_orden_merito" => $request->total_orden_merito,
                "orden_merito" => $request->orden_merito,
            ]);

            $movimiento = new Movimientos;
            $movimiento->codigo_empleado = $request->codigo_empleado;
            $movimiento->fecha_movimiento = date('Y-m-d');
            $movimiento->tipo_movimiento = 'Actualizacion de Datos Personales y Militares';
            $movimiento->tipo_emp_nuevo = $request->tipo_emp;
            $movimiento->codigo_grado = $request->grado_militar;
            $movimiento->fecha_ubicacion = $request->fecha_ubicacion;
            $movimiento->resol_ubicacion = $request->resolucion_ubicacion;
            $movimiento->codigo_cargo = $request->cargo;
            $movimiento->fecha_cargo = $request->fecha_cargo;
            $movimiento->resol_cargo = $request->resolucion_cargo;
            $movimiento->ubicacion_detallada = $request->ubicacion_detallada;

            $movimiento->save();

            return redirect()->route('juntap.personalm.view', [$request->id])->with('success', 'Se han actualizado los Datos del Profesional');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }

    public function cargosPersonalMilitar($id)
    {
        $user_auth = auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $cargos = Cargos::all();
        $grados_militares = GradosMilitares::all();
        $movimientos = Movimientos::all();
        $datos = Empleado::with(['nomina', 'movimientos'])->find($id);
        return view(
            'juntap.personalm.cargo',
            compact(
                'datos',
                'grados_militares',
                'user_auth',
                'tipos_emp',
                'ubicaciones',
                'ubicaciones_det',
                'cargos',
                'movimientos'
            )
        );
    }
    ///NO UTILIZO//
    public function updateCargosPersonalMilitar(Request $request)
    {

        $this->validate(
            $request,
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
            $nomina = Nomina::where('codigo_empleado', $request->codigo_empleado)->update([
                "codigo_cargo" => !empty($request->cargo) ? $request->cargo : 0,
                "fecha_inic_cargo" => !empty($request->fecha_inic_cargo) ? $request->fecha_inic_cargo : 0,
                "nro_resolucion_cargo" => !empty($request->nro_resolucion_cargo) ? $request->nro_resolucion_cargo : 0,
            ]);

            $nomina = Nomina::where('codigo_empleado', $request->codigo_empleado)->first();

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

            return redirect()->route('juntap.personalm.cargo', [$request->id])->with('success', 'Se ha actualizado el Cargo del Profesional');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }

    public function ubicacionesPersonalMilitar($id)
    {
        $user_auth = auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $cargos = Cargos::all();
        $grados_militares = GradosMilitares::all();
        $movimientos = Movimientos::all();
        $datos = Empleado::with(['nomina', 'movimientos'])->find($id);
        return view(
            'juntap.personalm.ubicacion',
            compact(
                'datos',
                'grados_militares',
                'user_auth',
                'tipos_emp',
                'ubicaciones',
                'ubicaciones_det',
                'cargos',
                'movimientos'
            )
        );
    }

    public function updateUbicacionesPersonalMilitar(Request $request)
    {

        $this->validate(
            $request,
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
            $nomina = Nomina::where('codigo_empleado', $request->codigo_empleado)->update([
                "codigo_ubicacion" => !empty($request->ubicacion) ? $request->ubicacion : 0,
                "cod_ubicacion_detallada" => !empty($request->ubicacion_detallada) ? $request->ubicacion_detallada : 0,
                "fecha_inic_ubicacion" => !empty($request->fecha_inic_ubicacion) ? $request->fecha_inic_ubicacion : 0,
                "nro_resolucion_ubicacion" => !empty($request->nro_resolucion_ubicacion) ? $request->nro_resolucion_ubicacion : 0,
            ]);

            $nomina = Nomina::where('codigo_empleado', $request->codigo_empleado)->first();

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

            return redirect()->route('juntap.principal.ubicacion', [$request->id])->with('success', 'Se ha actualizado la Ubicación del Profesional');
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
    public function personalMilitarSuspendido(Request $request)
    {
        $empleados = Empleado::where('empleados.situacion', 'S');
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
            ->addColumn('actions', 'sireh.personal.militar.suspendidos._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function suspenderPersonalMilitar(Request $request)
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
    }

    public function listPersonalMilitarBajas()
    {
        return view('sireh.personal.militar.bajas.index');
    }

    //Obtiene el personal militar egresado, exclusivo por api para el Datatable
    public function personalMilitarBaja(Request $request)
    {
        $empleados = Empleado::where('empleados.situacion', 'E');
        $empleados->join('nomina', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado');
        $empleados->join('tipos_empleados', 'tipos_empleados.tipo_emp', '=', 'nomina.tipo_emp');
        $empleados->join('ubicaciones', 'ubicaciones.codigo_ubicacion', '=', 'nomina.codigo_ubicacion');
        $empleados->join('grados_militares', 'grados_militares.codigo_grado', '=', 'nomina.grado_militar');
        $empleados->join('egresos', 'egresos.codigo_empleado', '=', 'empleados.codigo_empleado');
        $empleados->join('tipo_de_baja', 'tipo_de_baja.codigo_egreso', '=', 'egresos.causa_egreso');
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
            'tipo_de_baja.descripcion as motivo',
            'egresos.fecha_salida as fecha_salida',
            'egresos.nro_resuelto as nro_resuelto',
        );
        $datatable = Datatables::of($empleados);
        return $datatable->make(true);
    }

    public function bajaPersonalMilitar($id)
    {
        $user_auth = auth()->user();

        $situaciones = Config::get('constants.situacion');
        $ubicaciones = Ubicaciones::all();
        $grados_militares = GradosMilitares::all();
        $datos_militares = DatosMilitares::all();
        $tipo_de_baja = TipoDeBaja::all();
        $datos = Empleado::with(['nomina', 'datos_militares'])->find($id);
        return view(
            'sireh.personal.militar.baja',
            compact(
                'datos',
                'grados_militares',
                'situaciones',
                'user_auth',
                'ubicaciones',
                'datos_militares',
                'tipo_de_baja'
            )
        );
    }

    public function darBajaPersonalMilitar(Request $request)
    {
        $this->validate(
            $request,
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
            $nomina = Nomina::where('codigo_empleado', $request->codigo_empleado)->update([
                "situacion" => 'E',
            ]);

            $empleados = Empleado::where('codigo_empleado', $request->codigo_empleado)->update([
                "situacion" => 'E',
            ]);

            $user_auth = auth()->user();

            $egresos = new Egresos;
            $egresos->codigo_empleado = $request->codigo_empleado;
            $egresos->causa_egreso = $request->causa_egreso;
            $egresos->fecha_salida = $request->fecha_salida;
            $egresos->nro_resuelto = $request->nro_resuelto;
            $egresos->fecha_resuelto = $request->fecha_resuelto;
            $egresos->fecha_registro = date('Y-m-d');
            $egresos->usuario = $user_auth->name;
            $egresos->save();

            $nomina = Nomina::where('codigo_empleado', $request->codigo_empleado)->first();

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
        $empleado = Empleado::where('id', $request->id)->first();
        $nomina = Nomina::where('codigo_empleado', $empleado->codigo_empleado)->first();

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

    public function escogerEscalafon()
    {
        $user_auth = auth()->user();

        $grados_militares = GradosMilitares::whereIn('tipo_emp', ['MIL', 'TRP'])
            ->orderBy('codigo_grado', 'asc')
            ->get();

        return view(
            'sireh.personal.militar.escalafon',
            compact(
                'grados_militares'
            )
        );
    }

    public function imprimirEscalafon(Request $request)
    {
        $this->validate(
            $request,
            [
                'grado_militar' => 'required',
            ],
            [
                'grado_militar.required' => 'El Grado Militar es requerido'
            ]
        );
        $empleados = Empleado::join('nomina', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
            ->join('datos_militares', 'datos_militares.codigo_empleado', '=', 'nomina.codigo_empleado')
            ->leftJoin('cargos', 'cargos.codigo_cargo', '=', 'nomina.codigo_cargo')
            ->leftJoin('ubicaciones', 'ubicaciones.codigo_ubicacion', '=', 'nomina.codigo_ubicacion')
            ->join('grados_militares', 'grados_militares.codigo_grado', '=', 'nomina.grado_militar')
            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
            ->leftjoin('especialidades_militares as em1', 'em1.codigo_especialidad', '=', 'datos_militares.codigo_especialidad1')
            ->leftjoin('especialidades_militares as em2', 'em2.codigo_especialidad', '=', 'datos_militares.codigo_especialidad2')
            ->where(function ($query) {
                $query->where('empleados.situacion', 'A')
                    ->orWhere('empleados.situacion', 'S');
            })
            ->where('nomina.grado_militar', $request->grado_militar)
            ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
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
            ->orderBy('datos_militares.fecha_ultimo_ascenso', 'asc')
            ->orderBy('datos_militares.fecha_graduacion', 'asc')
            ->orderBy('datos_militares.orden_merito', 'asc')
            ->get();

        $agrupados = $empleados->groupBy('categoria');

        $pdf = \PDF::loadview('sireh.personal.militar.imprimirescalafon', compact('agrupados', 'empleados'))->setPaper('a4', 'landscape');

        return $pdf->stream('escalafon.pdf');
        //return view('sireh.personal.militar.imprimirescalafon', compact('agrupados'));
    }

    //PERSONAL CIVIL FUNCTIONS
    public function viewPersonalCivil($id)
    {
        $user_auth = auth()->user();

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
        $datos = Empleado::with(['nomina', 'estudios_realizados'])->find($id);
        $getEmpleadoCode = Empleado::select('codigo_empleado')->find($id);
        $cursosRealizados = CursosRealizados::where('codigo_empleado', $getEmpleadoCode['codigo_empleado'])->get();
        return view(
            'sireh.personal.civil.view',
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
                'cursosRealizados',
                'cursos'
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
        $user_auth = auth()->user();

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
        $datos = Empleado::with(['nomina', 'estudios_realizados'])->find($id);
        return view(
            'juntap.principal.edit',
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
                'profesiones'
            )
        );
    }
    public function updatePersonalCivil(Request $request)
    {
        $user_auth = auth()->user();

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
    public function personalCivilNoActive()
    {
        $noActive = Empleado::where('empleados.situacion', '<>', 'A')
            ->join('nomina', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
            ->join('tipos_empleados', 'tipos_empleados.tipo_emp', '=', 'nomina.tipo_emp')
            //->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
            ->join('cargos', 'cargos.codigo_cargo', '=', 'nomina.codigo_cargo')
            ->where('nomina.tipo_emp', '<>', 'MIL')
            ->where('nomina.tipo_emp', '<>', 'TRP')
            ->where('nomina.tipo_emp', '<>', 'ALI')
            ->get();
        //dd($noActive);
        return view(
            'sireh.personal.civil.view_civil_no_activo',
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
        $user_auth = auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $cargos = Cargos::all();
        $grados_militares = GradosMilitares::all();
        $datos = Empleado::with(['nomina', 'estudios_realizados'])->find($id);
        $evaluaciones = IntelectualesCivil::where('codigo_empleado', $datos->codigo_empleado)->get();
        return view(
            'sireh.personal.civil.view_evaluar',
            compact(
                'datos',
                'grados_militares',
                'user_auth',
                'tipos_emp',
                'ubicaciones',
                'ubicaciones_det',
                'cargos',
                'evaluaciones'
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
        return response()->json(
            [
                'success' => true,
                'message' => 'Data',
                'data' => $edit,
            ]
        );
    }
    public function updateEvaluarPersonalCivil(Request $request)
    {
        $updateIntec = IntelectualesCivil::where('id', $request->id)->update($request->except('id'));

        return response()->json(
            [
                'success' => true,
                'message' => 'Data',
                'updateIntec' => $updateIntec
            ]
        );
    }


    public function editPersonalMilitarNoProf($id)
    {
        $user_auth = auth()->user();

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
        $datos = Empleado::with(['nomina', 'nomina.cargo', 'estudios_realizados', 'nomina.datos_militares'])->find($id);
        $grados_militares = GradosMilitares::where('tipo_emp', $datos->nomina->tipo_emp)->get();
        return view(
            'sireh.personal.militar_noprof.edit',
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
                'profesiones'
            )
        );
    }

    public function updatePersonalMilitarNoProf(Empleado $empleado, Request $request)
    {

        $this->validate(
            $request,
            [
                'cedula' => 'required|unique:empleados,cedula,' . $empleado->id,
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
            if ($request->file("foto")) {
                $ext = $request->file('foto')->getClientOriginalExtension();
                $file_name = 'empleado_' . $empleado->codigo_empleado . '.' . $ext;

                $path_foto = 'fotos/empleados/' . $file_name;
                if (file_exists($path_foto)) {
                    unlink($path_foto); // Eliminamos la imagen previa si existe.
                }
                //$path = $request->file("foto")->store($path);
                Image::make($request->file('foto'))->save(public_path($path_foto));
            } else {
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
                $empleado->foto = $path_foto;
            }
            $empleado->correo = $request->correo;
            $empleado->save();

            $nomina = Nomina::where('codigo_empleado', $empleado->codigo_empleado)->first();
            $nomina->cedula = $empleado->cedula;
            $nomina->codigo_ubicacion = $request->ubicacion;
            $nomina->fecha_ingreso = $request->fecha_ingreso;
            $nomina->codigo_cargo = !empty($request->cargo) ? $request->cargo : 0;
            $nomina->grado_militar = !empty($request->grado_militar) ? $request->grado_militar : null;
            $nomina->cod_rac = !empty($request->cod_rac) ? $request->cod_rac : null;
            $nomina->cod_ubicacion_detallada = !empty($request->ubicacion_det) ? $request->ubicacion_det : null;
            $nomina->save();

            if ($request->contingente) {
                $datos_militares = DatosMilitares::where('codigo_empleado', $empleado->codigo_empleado)->first();
                $datos_militares->contingente = $request->contingente;
                $datos_militares->save();
            }
            if (!empty($request->universidad) || !empty($request->profesion)) {
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

    public function egresarMilitarNoProf(Request $request)
    {

        $this->validate(
            $request,
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
            $nomina = Nomina::where('codigo_empleado', $empleado->codigo_empleado)->first();
            $empleado->situacion = 'E';
            $nomina->situacion = 'E';
            $nomina->fecha_egreso = $request->fecha_egreso;
            $nomina->observaciones = $request->observaciones;
            $empleado->update();
            $nomina->update();
            return response()->json(['success' => true, 'msg' => 'Egreso Realizado con exito']);
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
    public function storeFuncionPersonalMilitar(Request $request)
    {

        $empleado = Empleado::where('codigo_empleado', $request->codigo_empleado)->first();

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

        return response()->json(
            [
                'success' => true,
                'message' => 'Data Eliminada'
            ]
        );
    }

    public function reportesPersonalMilitarView()
    {
        $categorias_militares = CategoriasMilitares::whereIn('tipo_emp', ['MIL', 'MEX', 'TRP'])->get();
        return view('sireh.personal.militar.reportes', compact(
            'categorias_militares',
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportesPersonalMilitar(Request $request)
    {

        $this->validate(
            $request,
            [
                'reporte' => 'required',
                'parametros' => 'required|array|min:1',
                'parametros.*' => 'required|string|distinct',
            ],
            [
                'parametros.*.required' => 'El Parametro es requerido',
            ]

        );
        $reporte = $request->reporte;
        $nameParametro = array_key_first($request->parametros);
        $valueParametro = $request->parametros[$nameParametro];

        $complementoTitulo = '';
        switch ($reporte) {
            case 1:
                $complementoTitulo = "DE BAJA POR CATEGORIA";
                $empleados = Empleado::join('nomina', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                    ->join('tipos_empleados', 'tipos_empleados.tipo_emp', '=', 'nomina.tipo_emp')
                    ->join('ubicaciones', 'ubicaciones.codigo_ubicacion', '=', 'nomina.codigo_ubicacion')
                    ->join('grados_militares', 'grados_militares.codigo_grado', '=', 'nomina.grado_militar')
                    ->join('datos_militares', 'datos_militares.codigo_empleado', '=', 'nomina.codigo_empleado')
                    ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                    ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
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
                $datos = $empleados->get();

                break;
            case 2:
                //dd($valueParametro);
                $complementoTitulo = "DE BAJA POR SITUACION";
                $empleados = Empleado::join('nomina', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
                    ->join('tipos_empleados', 'tipos_empleados.tipo_emp', '=', 'nomina.tipo_emp')
                    ->join('ubicaciones', 'ubicaciones.codigo_ubicacion', '=', 'nomina.codigo_ubicacion')
                    ->join('grados_militares', 'grados_militares.codigo_grado', '=', 'nomina.grado_militar')
                    ->join('datos_militares', 'datos_militares.codigo_empleado', '=', 'nomina.codigo_empleado')
                    ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
                    ->whereIn('nomina.tipo_emp', ['MIL', 'MEX', 'TRP'])
                    ->where('nomina.situacion', $valueParametro)
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
                $datos = $empleados->get();
                break;
        }

        $titulo = 'REPORTE DE PERSONAL MILITAR ' . $complementoTitulo;

        $nombre_archivo = sprintf('ReportePersonalMilitar %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
        $data = compact('titulo', 'datos');

        return Excel::download(new PersonalMilitarExport($data), $nombre_archivo);
    }

    public function reportesPersonalMilitarNoProfView()
    {
        $ubicaciones = Ubicaciones::all();
        return view('sireh.personal.militar_noprof.reportes', compact(
            'ubicaciones',
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportePersonalMilitarNoProfJerarquiaUbicacion(Request $request)
    {

        $this->validate(
            $request,
            [
                'tipo_emp' => 'required',
                'grado_militar' => 'required',
                'ubicacion' => 'required',
            ],
            [
                'tipo_emp' => 'El Parametro Tipo Empleado es Requerido',
            ]

        );

        $codigo_ubicacion = $request->ubicacion;
        $grado_militar = $request->grado_militar;
        $ubicacion_descripcion = '';
        $empleados = Empleado::join('nomina', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
            ->join('tipos_empleados', 'tipos_empleados.tipo_emp', '=', 'nomina.tipo_emp')
            ->join('ubicaciones', 'ubicaciones.codigo_ubicacion', '=', 'nomina.codigo_ubicacion')
            ->join('grados_militares', 'grados_militares.codigo_grado', '=', 'nomina.grado_militar')
            ->join('datos_militares', 'datos_militares.codigo_empleado', '=', 'nomina.codigo_empleado')
            ->join('categorias_militares', 'categorias_militares.codigo_categoria', '=', 'datos_militares.codigo_categoria')
            ->whereIn('nomina.tipo_emp', ['MIL', 'MEF']);
        if ($grado_militar !== '0') {
            $empleados->where('nomina.grado_militar', $grado_militar);
        }
        if ($codigo_ubicacion !== '0') {
            $empleados->where('nomina.codigo_ubicacion', $codigo_ubicacion);
            $ubicacion_descripcion = Ubicaciones::where('codigo_ubicacion', $codigo_ubicacion)->first()->value('descripcion');
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

        $datos = $empleados->get();
        if (count($datos) > 0) {
            \Session::flash('success', 'Reporte Ejecutado con exito !');
            $titulo = 'LISTADO POR UBICACION DE MILITARES EN FORMACION Y/O LA TROPA ALISTADA';

            $nombre_archivo = sprintf('ReportePersonalMilitarNoProf %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
            $data = compact('titulo', 'datos', 'codigo_ubicacion', 'ubicacion_descripcion');
            return Excel::download(new PersonalMilitarEnFormacionExport($data), $nombre_archivo);
        } else {
            return redirect()->back()->with('error', 'No hay Datos para generar el informe');
        }
    }
}
