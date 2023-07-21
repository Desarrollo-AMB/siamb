<?php

namespace App\Imports;

use App\Models\ConceptosNomina;
use App\Models\ConceptosPagados;
use App\Models\Nomina;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Termwind\Components\Dd;

class ExcelImport implements ToCollection, WithHeadingRow
{


    private $excelData;

    public function collection(Collection $rows)
    {
        $this->excelData = $rows;
    }

    public function getExcelData()
    {
        return $this->excelData;
    }
}
   /* public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $cedula = $row['cedula'];
            $monto = $row['monto'];

            // Eliminar comas y puntos de la cédula
            $cedula = preg_replace('/[.,]/', '', $cedula);

            // Buscar el código de empleado en la tabla 'nomina' basado en la cédula
            $codigoEmpleado = Nomina::where('cedula', $cedula)->value('codigo_empleado');

            // Buscar el código de concepto en la tabla 'conceptos_nomina' basado en el código del concepto del Excel
            $codigoConcepto = ConceptosNomina::where('codigo_concepto', 'LIKE', '001%')->value('codigo_concepto');

            // Verificar que la cédula y el código de empleado sean válidos
            if ($codigoEmpleado !== null && isset($row['cedula']) && isset($row['monto'])) {
                // Obtener el código del empleado a partir de la cédula en la tabla Nomina
                $empleado = Nomina::where('cedula', $cedula)->first();
                $codigoEmpleado = $empleado->codigo_empleado;

                // Buscar el concepto de nomina en la tabla ConceptoNomina
                $conceptoNomina = ConceptosNomina::where('codigo_concepto', $codigoConcepto)->first();

                // Guardar el registro en la tabla ConceptoPagado
                $conceptoPagado = new ConceptosPagados();
                $conceptoPagado->codigo_empleado = $codigoEmpleado;
                $conceptoPagado->codigo_concepto = $conceptoNomina->codigo;
                $conceptoPagado->monto = $monto;
                $conceptoPagado->save();
            }
        }
    }
}*/