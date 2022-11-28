<?php

namespace App\Http\Controllers\Civil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

use App\Models\Empleado;
use App\Models\Nomina;
use App\Models\IntelectualesCivil;
use App\Models\Movimientos;
use App\Exports\EvaluacionesExport;

class EvaluacionesCivilController extends Controller
{
    public function evaluacionesFecha() {
        return view('sireh.personal.civil.evaluaciones.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluacionesReportExcel(Request $request) {
        $this->validate($request, 
            [
                'desde' => 'required',
                'hasta' => 'required',
            ],
            [
                'desde.required' => 'La Fecha Desde es requerida',
                'hasta.required' => 'La Fecha Hasta es requerida'
            ]
        );
        $titulo = 'REPORTE DE EVALUACIONES';
        $evaluaciones = IntelectualesCivil::whereBetween('intelectuales_civil.fecha_evaluacion',[$request->desde,$request->hasta])
        ->join('nomina','nomina.codigo_empleado','=','intelectuales_civil.codigo_empleado')
        ->leftJoin('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp')
        ->select(
            'tipos_empleados.descripcion as tipo_emp',
            'nomina.cedula as cedula',
            'nomina.nombre1 as nombre1',
            'nomina.nombre2 as nombre2',
            'nomina.apellido1 as apellido1',
            'nomina.apellido2 as apellido2',
            'intelectuales_civil.nota as nota',
            'intelectuales_civil.observaciones as observaciones',
            'intelectuales_civil.fecha_evaluacion as fecha_evaluacion',
            'intelectuales_civil.nombre_evaluador as nombre_evaluador',
            'intelectuales_civil.cedula_evaluador as cedula_evaluador',

        )
        ->get();

        $nombre_archivo = sprintf('reporte de evaluaciones %s .xlsx', Carbon::now()->format('Y-m-d h_i_s_a'));
        $data = compact('titulo', 'evaluaciones');
        return Excel::download(new EvaluacionesExport($data), $nombre_archivo);
    }
}
