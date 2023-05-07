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
use App\Models\ConceptosNomina;
use App\Models\ConceptosPagados;
use App\Models\Familiares;
use App\Exports\CargaFamiliarExport;
use App\Exports\BajasExport;

class ReportesBSController extends Controller
{


    public function reportesBienestarSocial()
    {
        $especialidades_militares = EspecialidadesMilitares::all();
        $generos = Config::get('constants.sexo');
        $tipo_egreso = TipoDeBaja::all();
        $grados_militares = GradosMilitares::whereIn('tipo_emp',['MIL','MEX','TRP'])->orderBy('codigo_grado','ASC')->get();
        $categorias_militares = CategoriasMilitares::whereIn('tipo_emp',['MIL','MEX','TRP'])->get();
        return view('bienestar_social.reportes', compact(
            'especialidades_militares', 'generos', 'tipo_egreso',
            'grados_militares', 'categorias_militares',
        ));
    }

    public function reporteDevolucion5(Request $request) {
        $this->validate($request,
            [
                'cedula' => 'required',
            ],
            [
                'cedula' => 'La Cedula es requerida',
            ]
        );
        $concepto_nomina = ConceptosNomina::where('codigo_concepto','101')->first();

        $data = Empleado::join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado')
            ->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp')
            ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
            ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
            ->where('empleados.cedula', $request->cedula)
            ->select(
            'empleados.id',
            'empleados.codigo_empleado',
            'empleados.cedula',
            'empleados.nombre1',
            'empleados.nombre2',
            'empleados.apellido1',
            'empleados.apellido2',
            'grados_militares.siglas as siglas',
            'grados_militares.descripcion as grado_militar',
            'ubicaciones.descripcion as ubicacion',
        )->first();
        if(!$data){
            return back()
            ->with('warning','No se puede generar el reporte, no existen registros que corresponda a la cedula');
        };

        $conceptos_pagados = ConceptosPagados::where('codigo_empleado',$data->codigo_empleado)
            ->whereIn('codigo_concepto',['101','105'])
            ->orderBy('fecha_pago','ASC')
            ->orderBy('codigo_concepto','DESC')
            ->get();
            //dd($data);

        $pdf = \PDF::loadView('bienestar_social.reporte_devolucion5', compact('data', 'concepto_nomina', 'conceptos_pagados'));

        return $pdf->stream('Reporte Bienestar Social Devolucion.pdf',array('Attachment'=>0));
        //return view('bienestar_social.reporte_devolucion5', compact('data'));
    }

    public function reporteCargaFamiliar(Request $request) {
        $this->validate($request,
            [
                'lista1' => 'required',
            ],
            [
                'lista1' => 'El Parametro es Requerido',
            ]
        );
        $lista = $request->lista1;
        $desde = $request->desde;
        $hasta = $request->hasta;

        switch ($lista) {
            case 1:
                $complementoTitulo= "REPORTE HIJOS DE 0 A 12 AÑOS";
                $familiares = Familiares::join('nomina','nomina.codigo_empleado','=','familiares.codigo_empleado')
                ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
                ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
                ->join('empleados','empleados.codigo_empleado','=','familiares.codigo_empleado')
                //->where('familiares.codigo_empleado', 62782)
                ->where('familiares.parentesco', 'H')
                ->whereRaw('TIMESTAMPDIFF(YEAR, familiares.fecha_nacimiento, NOW()) < 13')
                ->select(
                    'nomina.codigo_empleado as codigo_empleado',
                    'nomina.cedula as cedula',
                    'nomina.nombre1 as nombre1',
                    'nomina.nombre2 as nombre2',
                    'nomina.apellido1 as apellido1',
                    'nomina.apellido2 as apellido2',
                    DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                    'ubicaciones.descripcion as ubicacion',
                    'grados_militares.siglas as siglas',
                    'familiares.nombre1 as nombref1',
                    'familiares.nombre2 as nombref2',
                    'familiares.apellido1 as apellidof1',
                    'familiares.apellido2 as apellidof2',
                    'familiares.fecha_nacimiento as fecha_nacimientof',
                    DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                    DB::raw('TIMESTAMPDIFF(YEAR, familiares.fecha_nacimiento, NOW()) as edad'),
                    'familiares.fecha_registro',
                )
                ->orderBy('codigo_empleado','ASC')
                ->orderBy('edad','ASC')
                ->get();
                //dd($familiares);
                break;

            case 2:
                $complementoTitulo= "REPORTE HIJOS DE 0 A 26 AÑOS";
                $familiares = Familiares::join('nomina','nomina.codigo_empleado','=','familiares.codigo_empleado')
                ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
                ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
                ->join('empleados','empleados.codigo_empleado','=','familiares.codigo_empleado')
                //->where('familiares.codigo_empleado', 62782)
                ->where('familiares.parentesco', 'H')
                ->whereRaw('TIMESTAMPDIFF(YEAR, familiares.fecha_nacimiento, NOW()) < 27')
                ->select(
                    'nomina.codigo_empleado as codigo_empleado',
                    'nomina.cedula as cedula',
                    'nomina.nombre1 as nombre1',
                    'nomina.nombre2 as nombre2',
                    'nomina.apellido1 as apellido1',
                    'nomina.apellido2 as apellido2',
                    DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                    'ubicaciones.descripcion as ubicacion',
                    'grados_militares.siglas as siglas',
                    'familiares.nombre1 as nombref1',
                    'familiares.nombre2 as nombref2',
                    'familiares.apellido1 as apellidof1',
                    'familiares.apellido2 as apellidof2',
                    'familiares.fecha_nacimiento as fecha_nacimientof',
                    DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                    DB::raw('TIMESTAMPDIFF(YEAR, familiares.fecha_nacimiento, NOW()) as edad'),
                    'familiares.fecha_registro',
                )
                ->orderBy('codigo_empleado','ASC')
                ->orderBy('edad','ASC')
                ->get();
                //dd($familiares);
                break;

            case 3:
                $complementoTitulo= "REPORTE DE MADRES AMB";
                $familiares = Familiares::join('nomina','nomina.codigo_empleado','=','familiares.codigo_empleado')
                ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
                ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
                ->join('empleados','empleados.codigo_empleado','=','familiares.codigo_empleado')
                //->where('familiares.codigo_empleado', 62782)
                ->where('familiares.parentesco', 'H')
                ->where('empleados.sexo', 'F')
                ->select(
                    'nomina.codigo_empleado as codigo_empleado',
                    'nomina.cedula as cedula',
                    'nomina.nombre1 as nombre1',
                    'nomina.nombre2 as nombre2',
                    'nomina.apellido1 as apellido1',
                    'nomina.apellido2 as apellido2',
                    DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                    'ubicaciones.descripcion as ubicacion',
                    'grados_militares.siglas as siglas',
                    'familiares.nombre1 as nombref1',
                    'familiares.nombre2 as nombref2',
                    'familiares.apellido1 as apellidof1',
                    'familiares.apellido2 as apellidof2',
                    'familiares.fecha_nacimiento as fecha_nacimientof',
                    DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                    DB::raw('TIMESTAMPDIFF(YEAR, familiares.fecha_nacimiento, NOW()) as edad'),
                    'familiares.fecha_registro',
                )
                ->orderBy('codigo_empleado','ASC')
                ->orderBy('edad','ASC')
                ->get();
                //dd($familiares);
                break;

            case 4:
                $complementoTitulo= "REPORTE DE PADRES AMB";
                $familiares = Familiares::join('nomina','nomina.codigo_empleado','=','familiares.codigo_empleado')
                ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
                ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
                ->join('empleados','empleados.codigo_empleado','=','familiares.codigo_empleado')
                //->where('familiares.codigo_empleado', 62782)
                ->where('familiares.parentesco', 'H')
                ->where('empleados.sexo', 'M')
                ->select(
                    'nomina.codigo_empleado as codigo_empleado',
                    'nomina.cedula as cedula',
                    'nomina.nombre1 as nombre1',
                    'nomina.nombre2 as nombre2',
                    'nomina.apellido1 as apellido1',
                    'nomina.apellido2 as apellido2',
                    DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                    'ubicaciones.descripcion as ubicacion',
                    'grados_militares.siglas as siglas',
                    'familiares.nombre1 as nombref1',
                    'familiares.nombre2 as nombref2',
                    'familiares.apellido1 as apellidof1',
                    'familiares.apellido2 as apellidof2',
                    'familiares.fecha_nacimiento as fecha_nacimientof',
                    DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                    DB::raw('TIMESTAMPDIFF(YEAR, familiares.fecha_nacimiento, NOW()) as edad'),
                    'familiares.fecha_registro',
                )
                ->orderBy('codigo_empleado','ASC')
                ->orderBy('edad','ASC')
                ->get();
                //dd($familiares);
                break;

            case 5:
                $complementoTitulo= "MATRIZ DE TODOS LOS HIJOS DE LOS PROFESIONALES DE LA AMB";
                $familiares = Familiares::join('nomina','nomina.codigo_empleado','=','familiares.codigo_empleado')
                ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
                ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
                ->join('empleados','empleados.codigo_empleado','=','familiares.codigo_empleado')
                //->where('familiares.codigo_empleado', 62782)
                ->where('familiares.parentesco', 'H')
                ->select(
                    'nomina.codigo_empleado as codigo_empleado',
                    'nomina.cedula as cedula',
                    'nomina.nombre1 as nombre1',
                    'nomina.nombre2 as nombre2',
                    'nomina.apellido1 as apellido1',
                    'nomina.apellido2 as apellido2',
                    DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                    'ubicaciones.descripcion as ubicacion',
                    'grados_militares.siglas as siglas',
                    'familiares.nombre1 as nombref1',
                    'familiares.nombre2 as nombref2',
                    'familiares.apellido1 as apellidof1',
                    'familiares.apellido2 as apellidof2',
                    'familiares.fecha_nacimiento as fecha_nacimientof',
                    DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                    DB::raw('TIMESTAMPDIFF(YEAR, familiares.fecha_nacimiento, NOW()) as edad'),
                    'familiares.fecha_registro',
                )
                ->orderBy('codigo_empleado','ASC')
                ->orderBy('edad','ASC')
                ->get();
                //dd($familiares);
                break;

                case 6:
                    $complementoTitulo= "REPORTE DE HIJOS POR FECHA DESDE: ".$desde." HASTA: ".$hasta;
                    $familiares = Familiares::join('nomina','nomina.codigo_empleado','=','familiares.codigo_empleado')
                    ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
                    ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
                    ->join('empleados','empleados.codigo_empleado','=','familiares.codigo_empleado')
                    ->whereBetween('familiares.fecha_registro', [$desde, $hasta])
                    ->where('familiares.parentesco', 'H')
                    ->select(
                        'nomina.codigo_empleado as codigo_empleado',
                        'nomina.cedula as cedula',
                        'nomina.nombre1 as nombre1',
                        'nomina.nombre2 as nombre2',
                        'nomina.apellido1 as apellido1',
                        'nomina.apellido2 as apellido2',
                        DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                        'ubicaciones.descripcion as ubicacion',
                        'grados_militares.siglas as siglas',
                        'familiares.nombre1 as nombref1',
                        'familiares.nombre2 as nombref2',
                        'familiares.apellido1 as apellidof1',
                        'familiares.apellido2 as apellidof2',
                        'familiares.fecha_nacimiento as fecha_nacimientof',
                        DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                        DB::raw('TIMESTAMPDIFF(YEAR, familiares.fecha_nacimiento, NOW()) as edad'),
                        'familiares.fecha_registro',
                    )
                    ->orderBy('fecha_registro','ASC')
                    ->orderBy('codigo_empleado','ASC')
                    ->orderBy('edad','ASC')
                    ->get();
                    //dd($familiares);
                    break;
        }

        $titulo = 'REPORTE BIENESTAR SOCIAL - '.$complementoTitulo;

        $nombre_archivo = sprintf('ReporteBienestarSocial %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
        $data = compact('titulo', 'familiares');

        return Excel::download(new CargaFamiliarExport($data), $nombre_archivo);
        //return view('excel.carga_familiar', compact('titulo','familiares'));
    }

    public function reporteBajas(Request $request) {
        $this->validate($request,
            [
                'lista2' => 'required',
            ],
            [
                'lista2' => 'El Parametro es Requerido',
            ]
        );
        $lista = $request->lista2;
        $especialidad = $request->especialidad;
        $grado = $request->grado;
        $categoria = $request->categoria;
        $sexo = $request->sexo;
        $tipo_egreso = $request->tipo_egreso;
        $desde = $request->desde;
        $hasta = $request->hasta;

        switch ($lista) {
            case 1:
                $complementoTitulo= "REPORTE DE BAJAS POR ESPECIALIDAD";

                $egresos = Egresos::join('nomina','nomina.codigo_empleado','=','egresos.codigo_empleado')
                ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
                ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
                ->join('empleados','empleados.codigo_empleado','=','egresos.codigo_empleado')
                ->join('datos_militares','datos_militares.codigo_empleado','=','egresos.codigo_empleado')
                ->join('tipo_de_baja','tipo_de_baja.codigo_egreso','=','egresos.causa_egreso')
                //->where('egresos.codigo_empleado', 62705)
                ->where('datos_militares.codigo_especialidad1', $especialidad)
                //->whereRaw('TIMESTAMPDIFF(YEAR, familiares.fecha_nacimiento, NOW()) < 13')
                ->select(
                    'nomina.codigo_empleado as codigo_empleado',
                    'grados_militares.siglas as siglas',
                    'nomina.cedula as cedula',
                    'nomina.nombre1 as nombre1',
                    'nomina.nombre2 as nombre2',
                    'nomina.apellido1 as apellido1',
                    'nomina.apellido2 as apellido2',
                    DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                    //'datos_militares.codigo_especialidad1 as especialidad',
                    //'datos_militares.codigo_categoria as categoria',
                    'ubicaciones.descripcion as ubicacion',
                    'datos_militares.fecha_graduacion as fecha_graduacion',
                    'tipo_de_baja.descripcion as tipo_de_baja',
                    'egresos.fecha_salida as fecha_salida',
                )
                ->orderBy('causa_egreso','ASC')
                ->orderBy('fecha_salida','ASC')
                ->get();

                $especialidades = EspecialidadesMilitares::where('especialidades_militares.codigo_especialidad', 'egresos.datos_militares.codigo_especialidad1')->get();
                $categorias = CategoriasMilitares::where('categorias_militares.codigo_categoria', 'egresos.datos_militares.codigo_categoria')->get();
                //dd($especialidades);
                break;

            case 2:
                $complementoTitulo= "REPORTE DE HIJOS POR FECHA";
                break;

            case 3:
                $complementoTitulo= "REPORTE DE HIJOS POR FECHA";
                break;

            case 4:
                $complementoTitulo= "REPORTE DE HIJOS POR FECHA";
                break;

            case 5:
                $complementoTitulo= "REPORTE DE HIJOS POR FECHA";
                break;

                case 6:
                    $complementoTitulo= "REPORTE DE HIJOS POR FECHA";
                    $familiares = Familiares::join('nomina','nomina.codigo_empleado','=','familiares.codigo_empleado')
                    ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
                    ->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion')
                    ->join('empleados','empleados.codigo_empleado','=','familiares.codigo_empleado')
                    ->whereBetween('familiares.fecha_registro', [$desde, $hasta])
                    ->where('familiares.parentesco', 'H')
                    ->select(
                        'nomina.codigo_empleado as codigo_empleado',
                        'nomina.cedula as cedula',
                        'nomina.nombre1 as nombre1',
                        'nomina.nombre2 as nombre2',
                        'nomina.apellido1 as apellido1',
                        'nomina.apellido2 as apellido2',
                        DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                        'ubicaciones.descripcion as ubicacion',
                        'grados_militares.siglas as siglas',
                        'familiares.nombre1 as nombref1',
                        'familiares.nombre2 as nombref2',
                        'familiares.apellido1 as apellidof1',
                        'familiares.apellido2 as apellidof2',
                        'familiares.fecha_nacimiento as fecha_nacimientof',
                        DB::raw("CASE empleados.sexo WHEN 'M' THEN 'MASCULINO' ELSE 'FEMENINA' END as genero"),
                        DB::raw('TIMESTAMPDIFF(YEAR, familiares.fecha_nacimiento, NOW()) as edad'),
                        'familiares.fecha_registro',
                    )
                    ->orderBy('fecha_registro','ASC')
                    ->orderBy('codigo_empleado','ASC')
                    ->orderBy('edad','ASC')
                    ->get();
                    //dd($familiares);
                    break;
        }

        $titulo = 'REPORTE BIENESTAR SOCIAL - '.$complementoTitulo;

        /*$nombre_archivo = sprintf('ReporteBienestarSocial %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
        $data = compact('titulo', 'bajas');

        return Excel::download(new BajasExport($data), $nombre_archivo);*/
        return view('excel.bajas', compact('titulo','especialidades','categorias','egresos'));
    }
}
