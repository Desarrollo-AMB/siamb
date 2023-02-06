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
use App\Models\ConceptosNomina;
use App\Models\ConceptosPagados;

class ReportesBSController extends Controller
{
    

    public function reportesBienestarSocial()
    {
        $categorias_militares = CategoriasMilitares::whereIn('tipo_emp',['MIL','MEX','TRP'])->get();
        return view('bienestar_social.reportes', compact(
            'categorias_militares',
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
        
        
        $pdf = \PDF::loadView('bienestar_social.reporte_devolucion5', compact('data', 'concepto_nomina', 'conceptos_pagados'));

        return $pdf->stream('Reporte Bienestar Social Devolucion.pdf',array('Attachment'=>0));
        //return view('bienestar_social.reporte_devolucion5', compact('data'));
       
    }

}
