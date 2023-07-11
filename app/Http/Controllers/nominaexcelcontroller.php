<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nomina;
use App\Imports\ExcelImport;
use App\Models\ConceptosNomina;
use App\Models\ConceptosPagados;
use Maatwebsite\Excel\Facades\Excel;
class nominaexcelcontroller extends Controller
{
    public function importarExcel(Request $request)
    {
        $file = $request->file('excel_file');

        $excelData = Excel::toArray(new ExcelImport(), $file)[0];

        foreach ($excelData as $row) {
            $cedula = $row['cedula'];
            $monto = $row['monto'];
            $codigoConceptoExcel = $row['codigo_concepto'];

            // Transformar el código del concepto según tus necesidades
            $codigoConcepto = $this->transformarCodigoConcepto($codigoConceptoExcel);

            // Obtener el código del empleado a partir de la cédula en la tabla Nomina
            $empleado = Nomina::where('cedula', $cedula)->first();
            $codigoEmpleado = $empleado->codigo_empleado;

            // Buscar el concepto de nomina en la tabla ConceptoNomina
            $conceptoNomina = ConceptosNomina::where('codigo', $codigoConcepto)->first();

            // Guardar el registro en la tabla ConceptoPagado
            $conceptoPagado = new ConceptosPagados();
            $conceptoPagado->codigo_empleado = $codigoEmpleado;
            $conceptoPagado->codigo_concepto = $conceptoNomina->codigo;
            $conceptoPagado->monto = $monto;
            $conceptoPagado->save();
        }

        return redirect()->back()->with('success', 'Importación de datos exitosa.');
    }

    private function transformarCodigoConcepto($codigoConceptoExcel)
    {
        // Realizar la transformación según las reglas específicas
        if ($codigoConceptoExcel === '230') {
            $codigoConcepto = '001';
        } elseif ($codigoConceptoExcel === 'XXX') {
            $codigoConcepto = '002';
        } else {
            // Si no se cumple ninguna regla, mantener el código original
            $codigoConcepto = $codigoConceptoExcel;
        }

        return $codigoConcepto;
    }
}