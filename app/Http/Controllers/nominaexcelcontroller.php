<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\Models\Nomina;
use App\Imports\ExcelImport;
use App\Models\ConceptosNomina;
use App\Models\ConceptosPagados;
use App\Models\Ubicaciones;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Validators\ValidationException;

class nominaexcelcontroller extends Controller
{

    public function index()
    {
        $ubicaciones = Ubicaciones::all();
        $conceptoNominas = ConceptosNomina::all();
        return view('sireh.nomina.personal_militar.carganomina', compact(
            'ubicaciones',
            'conceptoNominas'
        ));
    }

    public function importarExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'archivo_excel' => 'required|file',
            'fecha' => 'required',
            'parametros' => 'required|array|min:1',
            'parametros.*' => 'required|string|distinct',
            'tipo_nomina' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $archivoExcel = $request->file('archivo_excel');
        $nombreArchivo = $archivoExcel->getClientOriginalName();
        $rutaTemporal = public_path('temp/' . $nombreArchivo);
        $archivoExcel->move(public_path('temp'), $nombreArchivo);
        $fileObject = new File($rutaTemporal);
    
        $import = new ExcelImport();
    
        try {
            Excel::import($import, $fileObject);
        } catch (ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $errorRows[] = $failure->row();
            }
    
            return redirect()->back()->with('danger', 'La carga no tuvo éxito. Filas con errores: ' . implode(', ', $errorRows));
        }
    
        unlink($rutaTemporal);
    
        $nameParametro = array_key_first($request->parametros);
        $codigoConceptoExcel = $request->parametros[$nameParametro];
        $fecha = $request->fecha;
        $tipo_nomina = $request->tipo_nomina;
    
        // Verificar si ya existe un registro con los mismos valores
        $existingRecord = ConceptosPagados::where('codigo_concepto', $codigoConceptoExcel)
          //  ->where('fecha_pago', $fecha)
          // ->where('tipo_pago', $tipo_nomina)
            ->first();
 
        if ($existingRecord) {
            return redirect()->back()->with('danger', 'Ya existe una nomina para el concepto, fecha y tipo de pago  seleccionados.');
        }
    
        $excelData = $import->getExcelData();
    
        foreach ($excelData as $row) {
            if (isset($row['cedula']) && isset($row['monto'])) {
                $cedula = $row['cedula'];
                $monto = $row['monto'];
                $cedula = preg_replace('/[.,]/', '', $cedula);
                $codigoConcepto = $this->transformarCodigoConcepto($codigoConceptoExcel);
    
                $empleado = Nomina::where('cedula', $cedula)->first();
                $codigoEmpleado = $empleado->codigo_empleado;
    
                $conceptoNomina = ConceptosNomina::where('codigo_concepto', $codigoConcepto)->first();
    
                if ($empleado && $conceptoNomina) {
                    $conceptoPagado = new ConceptosPagados();
                    $conceptoPagado->codigo_empleado = $codigoEmpleado;
                    $conceptoPagado->codigo_concepto = $conceptoNomina->codigo_concepto;
                    $conceptoPagado->monto = $monto;
                    $conceptoPagado->fecha_pago = $fecha;
                    $conceptoPagado->fecha_pago_efectiva = $fecha;
                    $conceptoPagado->tipo_pago = $tipo_nomina;
                    $conceptoPagado->save();
                }
            }
        }
    
        return redirect()->back()->with('success', 'Importación de datos exitosa.');
    }

    private function transformarCodigoConcepto($codigoConceptoExcel)
    {
        if ($codigoConceptoExcel === '0001') {
            $codigoConcepto = '001';
        } elseif ($codigoConceptoExcel === '0053') {
            $codigoConcepto = '002';
        } else {
            $codigoConcepto = $codigoConceptoExcel;
        }

        return $codigoConcepto;
    }
}
