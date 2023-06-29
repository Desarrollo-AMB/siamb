<?php

namespace App\Http\Controllers\Nomina;

use App\Http\Controllers\Controller;
use App\Models\asignaciones;
use App\Models\ConceptosNomina;
use App\Models\Salarios;
use App\Models\Empleado;
use App\Models\Nomina;
use App\Models\Ubicaciones;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class NominaNoProfController extends Controller


{

                                   //PERSONAL MILITAR
//SECCION DE PRIMAS
//Ver Primas
public function primas(Request $request)
{
    $data = ConceptosNomina::select('*')
        ->where('tipo', 'A')
        ->whereIn('tipo_empleado', ['MIF', 'ALI'])
        ->get();

    //dd($data);

    return view('sireh.nomina.no_profesional.primas_noprof', compact('data'));
}

//Nueva prima
    public function nueva(Request $request)
    {
        $prima = new ConceptosNomina();
        $prima->codigo_concepto = $request->codigo;
        $prima->descripcion = strtoupper($request->nombre);
        $prima->porcentaje = $request->porcentaje;
        $prima->tipo = 'A';
        $prima->save();

        return view('sireh.nomina.personal_militar.nueva-prima')
        ->with('success', 'Prima agregada con éxito');;

    }
//EDIT PRIMA 
    public function editPrimaNoProf (ConceptosNomina $registro){
        // $prima = ConceptosNomina::find($id);
         return view('sireh.nomina.no_profesional.primas-edit',compact('registro'));
    }
//UPDATE PRIMAS
/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $registro
     * @return \Illuminate\Http\Response
     */
    public function updateNoProf (Request $request, $registro)
    {

        $this->validate($request, [

            'descripcion' => 'required',
            'porcentaje' => 'required',
        ]);

        $universidades = ConceptosNomina::find($registro);
        $universidades->descripcion = $request->input('descripcion');
        $universidades->porcentaje = $request->input('porcentaje');
        $universidades->save();
            return redirect()->route('sireh.nomina.noProf')
            ->with('success','Prima actualizada con éxito');
    }
//Delete Primas
    public function deleteNoProf(Request $request, $id)
    {
        //return($request);
        ConceptosNomina::find($id)->delete();
        //\DB::table("cargos")->where('id',$id)->delete();
        return redirect()->back();
    }

//Delete Primas
    public function deleteNoProfAsignada(Request $request, $id)
    {
      
        asignaciones::find($id)->delete();
        //\DB::table("cargos")->where('id',$id)->delete();
       // return($request);
       $cedula = $request->cedula;
    $empleado = Empleado::select('codigo_empleado', 'nombre1', 'apellido1')
        ->where('cedula', $cedula)
        ->first();

    if (!$empleado) {
        session()->flash('error', 'El profesional con cédula '.$cedula.' no existe.');
        return redirect()->back();
    }

    $codigo_empleado = $empleado->codigo_empleado;

    $existeNomina = Nomina::where('codigo_empleado', $codigo_empleado)
        ->whereIn('tipo_emp', ['MIF', 'ALI'])
        ->exists();

    if ($existeNomina) {
        $asignaciones = Asignaciones::select('asignaciones.*', 'Empleados.codigo_empleado', 'Empleados.nombre1', 'Empleados.apellido1', 'primas_deducciones.descripcion as nombre')
            ->join('primas_deducciones', 'primas_deducciones.codigo_concepto', '=', 'asignaciones.id_concepto')
            ->join('Empleados', 'asignaciones.codigo_empleado', '=', 'Empleados.codigo_empleado')
            ->where('Empleados.cedula', $cedula)
            ->where('asignaciones.tipo_concepto', 'A')
            ->with('conceptoNomina')
            ->get();

        $empleado_nombre = $empleado->nombre1;
        $empleado_apellido = $empleado->apellido1;

        $conceptos_nomina = ConceptosNomina::select('codigo_concepto', 'descripcion', 'tipo', 'tipo_empleado')
        ->where('tipo', 'A')
        ->whereIn('tipo_empleado', ['MIF','ALI'])
        ->get();

        $dataemp = [
            'empleado_nombre' => $empleado_nombre,
            'empleado_apellido' => $empleado_apellido,
            'cedula' => $cedula,
            'conceptos_nomina' => $conceptos_nomina,
            'codigo_empleado' => $codigo_empleado,
        ];
//return($conceptos_nomina);
        return view('sireh.nomina.no_profesional.actuales-primas_noprof', compact('asignaciones', 'conceptos_nomina', 'dataemp'));
    } else {
        // La nómina no existe para el empleado con tipo_emp 'MIF' o 'ALI'
        // Realiza las operaciones que necesites aquí
        // Por ejemplo, muestra un mensaje de error o redirige a otra página
        session()->flash('error', 'El profesiona con cedula n° '.$cedula.' no pertenece a la nomina del Personal Militar No Profesional');
        return redirect()->back();
    }
    ;
   
}

                                      //ASIGNACION DE PRIMAS
    //SECCION DE SUELDOS
//Introducir cedula
public function nuevaNoProf()
{
    return view('sireh.nomina.no_profesional.nueva-prima_noprof');
}

//asignacion del profesional
public function actualesNoProf (Request $request)
    {
        $cedula = $request->cedula;

    $empleado = Empleado::select('codigo_empleado', 'nombre1', 'apellido1')
        ->where('cedula', $cedula)
        ->whereIn('situacion', ['A', 'S'])
        ->first();

    if (!$empleado) {
        session()->flash('error', 'El profesional con cédula '.$cedula.' no existe.');
        return redirect()->back();
    }

    $codigo_empleado = $empleado->codigo_empleado;

    $existeNomina = Nomina::where('codigo_empleado', $codigo_empleado)
    ->whereIn('tipo_emp', ['MEF', 'ALI'])
    ->whereIn('situacion', ['A', 'S'])
    ->exists();
 
    if ($existeNomina) {
        $asignaciones = Asignaciones::select('asignaciones.*', 'Empleados.codigo_empleado', 'Empleados.nombre1', 'Empleados.apellido1', 'primas_deducciones.descripcion as nombre')
            ->join('primas_deducciones', 'primas_deducciones.codigo_concepto', '=', 'asignaciones.id_concepto')
            ->join('Empleados', 'asignaciones.codigo_empleado', '=', 'Empleados.codigo_empleado')
            ->where('Empleados.cedula', $cedula)
            ->where('asignaciones.tipo_concepto', 'A')
            ->with('conceptoNomina')
            ->get();

        $empleado_nombre = $empleado->nombre1;
        $empleado_apellido = $empleado->apellido1;

        $conceptos_nomina = ConceptosNomina::select('codigo_concepto', 'descripcion', 'tipo', 'tipo_empleado')
        ->where('tipo', 'A')
        ->whereIn('tipo_empleado', ['MEF','ALI'])
        ->get();

        $dataemp = [
            'empleado_nombre' => $empleado_nombre,
            'empleado_apellido' => $empleado_apellido,
            'cedula' => $cedula,
            'conceptos_nomina' => $conceptos_nomina,
            'codigo_empleado' => $codigo_empleado,
        ];
//return($conceptos_nomina);
            return view('sireh.nomina.no_profesional.actuales-primas_noprof', compact('asignaciones', 'conceptos_nomina', 'dataemp'));
        } else {
            // La nómina no existe para el empleado con tipo_emp 'MIF' o 'ALI'
            // Realiza las operaciones que necesites aquí
            // Por ejemplo, muestra un mensaje de error o redirige a otra página
            session()->flash('error', 'El profesional con cedula n° '.$cedula.' no pertenece a la nomina del Personal Militar No Profesional');
            return redirect()->back();
        }
    }


 //asignacion de nueva prima
//Nueva prima
public function asignacionNoProf(Request $request)
{
    $codigo_concepto = $request->input('codigo_concepto');
    $cedula = $request->input('cedula');
    $empleado_nombre = $request->input('nombre');
    $empleado_apellido = $request->input('apellido');
    $codigo_empleado = $request->input('codigo_empleado');
    $tipo = $request->input('tipo');

    $asignacionExistente = Asignaciones::withTrashed()
        ->where('codigo_empleado', $codigo_empleado)
        ->where('id_concepto', $codigo_concepto)
        ->first();

    if ($asignacionExistente) {
        if ($asignacionExistente->deleted_at !== null) {
            $asignacionExistente->restore();
            session()->flash('success', 'La prima ha sido restaurada');
        } else {
            session()->flash('error', 'La prima ya se encuentra asignada al profesional');
        }
    } else {
        $asignacion = new Asignaciones();
        $asignacion->codigo_empleado = $codigo_empleado;
        $asignacion->id_concepto = $codigo_concepto;
        $asignacion->tipo_concepto = $tipo;
        $asignacion->save();
        session()->flash('success', 'La prima ha sido asignada con éxito');
    }

    $conceptos_nomina = ConceptosNomina::select('codigo_concepto', 'descripcion', 'tipo')
        ->where('tipo', 'A')
        ->where(function ($query) {
            $query->whereIn('tipo_empleado', ['MIF', 'ALI'])
                ->orWhereNull('tipo_empleado');
        })
        ->get();

    $dataemp = [
        'empleado_nombre' => $empleado_nombre,
        'empleado_apellido' => $empleado_apellido,
        'cedula' => $cedula,
        'conceptos_nomina' => $conceptos_nomina,
        'codigo_empleado' => $codigo_empleado,
    ];

    $empleado = Empleado::select('codigo_empleado', 'nombre1', 'apellido1')
        ->where('cedula', $cedula)
        ->first();

    $asignaciones = Asignaciones::select('asignaciones.*', 'Empleados.codigo_empleado', 'Empleados.nombre1', 'Empleados.apellido1', 'primas_deducciones.descripcion as nombre')
        ->join('primas_deducciones', 'primas_deducciones.codigo_concepto', '=', 'asignaciones.id_concepto')
        ->join('Empleados', 'asignaciones.codigo_empleado', '=', 'Empleados.codigo_empleado')
        ->where('Empleados.cedula', $cedula)
        ->where('Asignaciones.tipo_concepto', 'A')
        ->with('conceptoNomina')
        ->get();

    return view('sireh.nomina.no_profesional.actuales-primas_noprof', compact('asignaciones', 'conceptos_nomina', 'dataemp'))->render();
}
                                    //SECCION DE DEDUCCIONES

//Ver deducciones
    public function deduccionesNoProf(Request $request)
    {
        $data = ConceptosNomina::select('*')
        ->where('tipo', 'D')
        ->whereIn('tipo_empleado', ['MEF', 'ALI'])
        ->get();
      //dd($data);
        return view('sireh.nomina.no_profesional.deducciones',compact('data'));
    }
//EDIT PRIMA 2
public function editdeduccionesNoProf (ConceptosNomina $id){

    // $prima = ConceptosNomina::find($id);
     return view('sireh.nomina.no_profesional.deducciones-edit',compact('id'));
 }

 //UPDATE PRIMAS
/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $registro
     * @return \Illuminate\Http\Response
     */
    public function updateDeduccionesNoProf(Request $request, $id)
    {

        $this->validate($request, [

            'descripcion' => 'required',
            'porcentaje' => 'required',
        ]);

        $universidades = ConceptosNomina::find($id);
        $universidades->descripcion = $request->input('descripcion');
        $universidades->porcentaje = $request->input('porcentaje');
        $universidades->save();
            return redirect()->route('sireh.nomina.deducciones')
            ->with('success','Deducción actualizada con éxito');

    }

    //Delete deducciones
    public function deletededuccionesNoProf($id)
    {
        ConceptosNomina::find($id)->delete();
        //\DB::table("cargos")->where('id',$id)->delete();
        //return($id);
        return redirect()->route('sireh.nomina.noprof.deducciones');

    }

    //Delete Primas
    public function deletededuccionesAsignadas(Request $request, $id)
    {
      
        asignaciones::find($id)->delete();
        //\DB::table("cargos")->where('id',$id)->delete();
       // return($request);
       $cedula = $request->cedula;
        $empleado = Empleado::select('codigo_empleado', 'nombre1', 'apellido1')
        ->where('cedula', $cedula)
        ->first();

    if (!$empleado) {
        session()->flash('error', 'El profesional con cédula '.$cedula.' no existe.');
        return redirect()->back();
    }

    $codigo_empleado = $empleado->codigo_empleado;

    $existeNomina = Nomina::where('codigo_empleado', $codigo_empleado)
        ->whereIn('tipo_emp', ['MEF', 'ALI'])
        ->exists();

    if ($existeNomina) {
        $asignaciones = Asignaciones::select('asignaciones.*', 'Empleados.codigo_empleado', 'Empleados.nombre1', 'Empleados.apellido1', 'primas_deducciones.descripcion as nombre')
            ->join('primas_deducciones', 'primas_deducciones.codigo_concepto', '=', 'asignaciones.id_concepto')
            ->join('Empleados', 'asignaciones.codigo_empleado', '=', 'Empleados.codigo_empleado')
            ->where('Empleados.cedula', $cedula)
            ->where('asignaciones.tipo_concepto', 'D')
            ->with('conceptoNomina')
            ->get();

        $empleado_nombre = $empleado->nombre1;
        $empleado_apellido = $empleado->apellido1;

        $conceptos_nomina = ConceptosNomina::select('codigo_concepto', 'descripcion', 'tipo', 'tipo_empleado')
        ->where('tipo', 'D')
        ->whereIn('tipo_empleado', ['MEF','ALI'])
        ->get();

        $dataemp = [
            'empleado_nombre' => $empleado_nombre,
            'empleado_apellido' => $empleado_apellido,
            'cedula' => $cedula,
            'conceptos_nomina' => $conceptos_nomina,
            'codigo_empleado' => $codigo_empleado,
        ];
//return($conceptos_nomina);
        return view('sireh.nomina.no_profesional.actuales_deducciones_noprof', compact('asignaciones', 'conceptos_nomina', 'dataemp'));
    } else {
        // La nómina no existe para el empleado con tipo_emp 'MIF' o 'ALI'
        // Realiza las operaciones que necesites aquí
        // Por ejemplo, muestra un mensaje de error o redirige a otra página
        session()->flash('error', 'El profesiona con cedula n° '.$cedula.' no pertenece a la nomina del Personal Militar No Profesional');
        return redirect()->back();
    }
    ;
   
}

//Introducir cedula
    public function nuevaDeduccionNoProf()
    {
        return view('sireh.nomina.no_profesional.nueva-deduccion_noprof');
    }

//Asignacion del profesional
    public function actualesdeduccionesNoProf(Request $request)
        {
            $cedula = $request->cedula;

        $empleado = Empleado::select('codigo_empleado', 'nombre1', 'apellido1')
            ->where('cedula', $cedula)
            ->whereIn('situacion', ['A', 'S'])
            ->first();

        if (!$empleado) {
            session()->flash('error', 'El profesional con cédula '.$cedula.' no existe.');
            return redirect()->back();
        }

        $codigo_empleado = $empleado->codigo_empleado;

        $existeNomina = Nomina::where('codigo_empleado', $codigo_empleado)
            ->whereIn('tipo_emp', ['MEF', 'ALI'])
            ->whereIn('situacion', ['A', 'S'])
            ->exists();

        if ($existeNomina) {
            $asignaciones = Asignaciones::select('asignaciones.*', 'Empleados.codigo_empleado', 'Empleados.nombre1', 'Empleados.apellido1', 'primas_deducciones.descripcion as nombre')
                ->join('primas_deducciones', 'primas_deducciones.codigo_concepto', '=', 'asignaciones.id_concepto')
                ->join('Empleados', 'asignaciones.codigo_empleado', '=', 'Empleados.codigo_empleado')
                ->where('Empleados.cedula', $cedula)
                ->where('asignaciones.tipo_concepto', 'D')
                ->with('conceptoNomina')
                ->get();

            $empleado_nombre = $empleado->nombre1;
            $empleado_apellido = $empleado->apellido1;

            $conceptos_nomina = ConceptosNomina::select('codigo_concepto', 'descripcion', 'tipo', 'tipo_empleado')
            ->where('tipo', 'D')
            ->whereIn('tipo_empleado', ['MEF','ALI'])
            ->get();

            $dataemp = [
                'empleado_nombre' => $empleado_nombre,
                'empleado_apellido' => $empleado_apellido,
                'cedula' => $cedula,
                'conceptos_nomina' => $conceptos_nomina,
                'codigo_empleado' => $codigo_empleado,
            ];
        //return($conceptos_nomina);
            return view('sireh.nomina.no_profesional.actuales_deducciones_noprof', compact('asignaciones', 'conceptos_nomina', 'dataemp'));
        } else {
            // La nómina no existe para el empleado con tipo_emp 'MIF' o 'ALI'
            // Realiza las operaciones que necesites aquí
            // Por ejemplo, muestra un mensaje de error o redirige a otra página
            session()->flash('error', 'El profesiona con cedula n° '.$cedula.' no pertenece a la nomina del Personal Militar No Profesional');
            return redirect()->back();
        }
    }
    
//Asignacion del profesional II

    public function insertarDeduccionNoProf(Request $request)
    {
    
        $codigo_concepto = $request->input('codigo_concepto');
        $cedula = $request->input('cedula');
        $empleado_nombre = $request->input('nombre');
        $empleado_apellido = $request->input('apellido');
        $cedula = $request->input('cedula');
        $codigo_empleado = $request->input('codigo_empleado');
        $tipo = $request->input('tipo');
    
        $conceptos_nomina = ConceptosNomina::select('codigo_concepto', 'descripcion', 'tipo')
        ->where('tipo', 'D')
        ->where(function ($query) {
            $query->whereIn('tipo_empleado', ['MEF', 'ALI'])
                ->orWhereNull('tipo_empleado');
        })
        ->get();
    
        $dataemp = [
            'empleado_nombre' => $empleado_nombre,
            'empleado_apellido' => $empleado_apellido,
            'cedula' => $cedula,
            'conceptos_nomina' => $conceptos_nomina,
            'codigo_empleado' => $codigo_empleado, 
        ];
    
        $empleado = Empleado::
        select('codigo_empleado','nombre1', 'apellido1')
        ->where ('cedula', $cedula)
        ->first();
    
        $asignaciones = Asignaciones::
            select('asignaciones.*', 'Empleados.codigo_empleado', 'Empleados.nombre1', 'Empleados.apellido1','primas_deducciones.descripcion as nombre')
            ->join('primas_deducciones', 'primas_deducciones.codigo_concepto', '=', 'asignaciones.id_concepto')
            ->join('Empleados', 'asignaciones.codigo_empleado', '=', 'Empleados.codigo_empleado')
            ->where('Empleados.cedula', $cedula)
            ->where('Asignaciones.tipo_concepto', 'D')
            ->with('conceptoNomina')
            ->get();
    
        $asignacionExistente = Asignaciones::withTrashed()
        ->where('codigo_empleado', $codigo_empleado)
        ->where('id_concepto', $codigo_concepto)
        ->first();
    
            if ($asignacionExistente) {
                if ($asignacionExistente->deleted_at !== null) {
                    $asignacionExistente->restore();
                    session()->flash('success', 'La prima ha sido restaurada');
                } else {
                    session()->flash('error', 'La prima ya se encuentra asignada al profesional');
                }
            } else {
                $asignacion = new Asignaciones();
                $asignacion->codigo_empleado = $codigo_empleado;
                $asignacion->id_concepto = $codigo_concepto;
                $asignacion->tipo_concepto = $tipo;
                $asignacion->save();
                session()->flash('success', 'La prima ha sido asignada con éxito');
            }
    
        return view('sireh.nomina.no_profesional.actuales_deducciones_noprof', compact('asignaciones', 'conceptos_nomina', 'dataemp'))->render();
             }
//SECCION DE DEDUCCION SUELDO

    //VISTA CAMBIO DE SUELDO

    public function sueldosNoProf()
{
    $salarios = Salarios::select('*')
                ->where('tipo_emp', 'MEF')
                ->orderBy('antiguedad', 'asc')
                ->get();

    // Puedes utilizar dd para depurar y verificar si los datos se obtienen correctamente
    // dd($salarios); 

    return view('sireh.nomina.no_profesional.sueldo', compact('salarios'));
}


    //MODIFICACION DE SUELDO
    public function editSueldosNoProf(Request $request)
{
    $inputs = $request->except('_token');

    foreach ($inputs as $key => $value) {
        $id = intval(str_replace('porcentaje_', '', $key));

        $salario = Salarios::find($id);

        if ($salario && $value !== null) {
            $salario->porcentaje = $value;
            $salario->save();
        }
    }

    return redirect()->route('sireh.nomina.no_profesional')
        ->with('success', 'Los PORCENTAJES de SUELDO POR GRADO han sido actualizados con éxito');
}

//SECCION EXCEL

    public function excelVistaNoProf()
    {
        return view('sireh.nomina.no_profesional.excel-vista');
    }

//PROCESS

    public function excelProcessNoProf()
    {
    // Crear una instancia de Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Obtener la hoja activa del libro de Excel
    $sheet = $spreadsheet->getActiveSheet();

    // Definir los encabezados de las columnas
    $sheet->setCellValue('A1', 'COMPAÑIA');
    $sheet->setCellValue('B1', 'CODIGO_UBICACION');
    $sheet->setCellValue('C1', 'NOMBRE_UBICACION');
    $sheet->setCellValue('D1', 'GRADO');
    $sheet->setCellValue('E1', 'CONTINGENTE');
    $sheet->setCellValue('F1', 'NACIONALIDAD');
    $sheet->setCellValue('G1', 'CEDULA');
    $sheet->setCellValue('H1', 'APELLIDOS');
    $sheet->setCellValue('I1', 'NOMBRES');
    $sheet->setCellValue('J1', 'SEXO');
    $sheet->setCellValue('K1', 'DIRECCIÓN');
    $sheet->setCellValue('L1', 'TELEFONO');
    $sheet->setCellValue('M1', 'SUELDO');
    $sheet->setCellValue('N1', 'TIPO_TRABAJADOR');
    $sheet->setCellValue('O1', 'FECHA_NACIMIENTO');
    $sheet->setCellValue('P1', 'FECHA_INGRESO');
    $sheet->setCellValue('Q1', 'CODIGO_NOMINA');


    // Establecer el estilo para la primera fila
    $style = $sheet->getStyle('A1:Q1');
    $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $style->getAlignment()->setWrapText(true);
    // Ajustar el texto y centrarlo verticalmente
    $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $style->getAlignment()->setWrapText(true);

    // Establecer el estilo para la primera fila
    $style = $sheet->getStyle('A1:Q1');
    $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    // Obtener el objeto RowDimension de la primera fila
    $rowDimension = $sheet->getRowDimension(1);

    // Establecer la altura deseada para la primera fila
    $rowDimension->setRowHeight(50); 

    // Ajustar el ancho de las columnas B a E según el contenido
    $columnIterator = $sheet->getColumnIterator('A', 'Q');
    foreach ($columnIterator as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }

    // Establecer el estilo para todas las celdas
    $style = $sheet->getStyle($sheet->calculateWorksheetDimension());

    // Establecer el color de fondo y el color de texto
    $fill = $style->getFill();
    $fill->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('246193'); // Color de fondo azul
    $style->getFont()->getColor()->setRGB(Color::COLOR_WHITE); // Color de texto blanco

    // Establecer el color de las líneas de las celdas
    $border = $style->getBorders();
    $border->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);
    $border->getAllBorders()->getColor()->setRGB(Color::COLOR_BLACK); // Color de líneas negras



        
        // Obtener los registros de la nómina
    $nomina = Nomina::select('nomina.*', 'datos_militares.codigo_categoria', 'datos_militares.fecha_ultimo_ascenso', 'datos_militares.fecha_graduacion', 'grados_militares.siglas')
    ->whereIn('nomina.tipo_emp', ['ALI'])
    ->whereIn('nomina.situacion', ['S', 'A'])
    ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
    ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')

    // Obtener el nombre de la categoría por código de categoría
    ->leftJoin('categorias_militares', 'datos_militares.codigo_categoria', '=', 'categorias_militares.codigo_categoria')
    ->addSelect('categorias_militares.descripcion as nombre_categoria')
    ->get();

    // Obtener el porcentaje del sueldo base
    $sueldoBase = ConceptosNomina::where('codigo_concepto', '1')
    ->pluck('porcentaje')
    ->first();

    

    // Iterar sobre los datos y escribirlos en las celdas correspondientes
    $row = 2; // La primera fila ya está ocupada por los encabezados, así que comenzamos en la segunda fila
    
    foreach ($nomina as $item) {
    $fechaGraduacion = Carbon::parse($item->fecha_graduacion);
    $antiguedad = $fechaGraduacion->diffInYears(Carbon::now());
    $item->antiguedad = $antiguedad;

    // Verificar el valor de la columna "codigo_cia" y almacenarlo en una variable
    $codigo_cia = ($item->codigo_cia == '1') ? 'AVIACION MILITAR BOLIVARIANA' : $item->codigo_cia;

    // Utilizar la variable $codigo_cia en lugar de modificar directamente $item->codigo_cia
    $item->codigo_cia_modificado = $codigo_cia;

    // Calcular los años de servicio y la antigüedad en el grado
    $fechaAscenso = Carbon::parse($item->fecha_ultimo_ascenso);
    $antiguedadGrado = $fechaAscenso->diffInYears(Carbon::now());
    $item->antiguedadGrado = $antiguedadGrado;

    // Obtener el sexo
    $sexo = Empleado::where('codigo_empleado', $item->codigo_empleado)
        ->pluck('sexo')
        ->first();
    $item->sexo = $sexo;
    
    // Obtener la nacionalidad
    $nacionalidad = Empleado::where('codigo_empleado', $item->codigo_empleado)
        ->pluck('nacionalidad')
        ->first();
    $item->nacionalidad = $nacionalidad;
 
    // Obtener la direccion
    $direccion = Empleado::where('codigo_empleado', $item->codigo_empleado)
        ->pluck('direccion')
        ->first();
    $item->direccion = $direccion;

    // Obtener la telefono
    $telefono = Empleado::where('codigo_empleado', $item->codigo_empleado)
        ->pluck('telefono')
        ->first();
    $item->telefono = $telefono;

    // Obtener la fecha_nacimiento
    $fecha_nacimiento = Empleado::where('codigo_empleado', $item->codigo_empleado)
        ->pluck('fecha_nacim')
        ->first();
    $item->fecha_nacimiento = $fecha_nacimiento;

    // Obtener la fecha_ingreso
    $fecha_ingreso = Nomina::where('codigo_empleado', $item->codigo_empleado)
        ->pluck('fecha_ingreso')
        ->first();
    $item->fecha_ingreso = $fecha_ingreso;

    // Obtener la codigo_nomina
    $codigo_nomina = Nomina::where('codigo_empleado', $item->codigo_empleado)
        ->pluck('codigo_nomina')
        ->first();
    $item->codigo_nomina = $codigo_nomina;

    // Obtener la antigüedad ajustada (máximo 5)
    $antiguedadAjustada = min($antiguedadGrado, 5);

    // Obtener el salario correspondiente al grado militar y la antigüedad
    $salario = Salarios::where('codigo_grado', $item->grado_militar)
        ->where('antiguedad', $antiguedadAjustada)
        ->pluck('porcentaje')
        ->first();
    $item->salario = $salario;

    // Verificar si la antigüedad es mayor a 30 y ajustarla a 30
    $antiguedad = min($antiguedad, 30);
    $item->antiguedad = $antiguedad;

    // Obtener la descripción del código de ubicación
    $ubicacion = Ubicaciones::where('codigo_ubicacion', $item->codigo_ubicacion)
        ->pluck('descripcion')
        ->first();
    $item->ubicacion = $ubicacion;

    // Calcular el sueldo por grado
    $porcentajeSalario = Salarios::where('codigo_grado', $item->grado_militar)
        ->pluck('porcentaje')
        ->first();
    $sueldoGrado = $sueldoBase * $porcentajeSalario; 
    
    $item->sueldo_grado = $sueldoGrado;
    

    // Obtener el porcentaje del modelo ConceptosNomina
    $porcentajeConcepto = ConceptosNomina::where('codigo_concepto', '500')
    ->where('antiguedad', $antiguedad)
    ->pluck('porcentaje')
    ->first();
    $item->porcentaje_concepto = $porcentajeConcepto;

    // Mostrar el sueldo base
    $sueldoBase = ConceptosNomina::where('codigo_concepto', '1')
    ->pluck('porcentaje')
    ->first();
        
    // Obtener el monto del sueldo base
    $sueldoBase = ConceptosNomina::where('codigo_concepto', '1')
    ->pluck('porcentaje')
    ->first();
    
    $item->sueldo_base = $sueldoBase;



        $sheet->setCellValue('A' . $row, $item->codigo_ubicacion );
        $sheet->setCellValue('B' . $row, $item->ubicacion );
        $sheet->setCellValue('C' . $row, $item->siglas );
        $sheet->setCellValue('D' . $row, $item->ubicacion );
        $sheet->setCellValue('E' . $row, $item->ubicacion);
        $sheet->setCellValue('F' . $row, $item->nacionalidad );
        $sheet->setCellValue('G' . $row, $item->cedula );
        $sheet->setCellValue('H' . $row, $item->apellido1 . ' ' . $item->apellido2 );
        $sheet->setCellValue('I' . $row, $item->nombre1 . ' ' . $item->nombre2);
        $sheet->setCellValue('J' . $row, $item->sexo );
        $sheet->setCellValue('K' . $row, $item->direccion );
        $sheet->setCellValue('L' . $row, $item->telefono );
        $sheet->setCellValue('M' . $row, $item->sueldo_grado );
        $sheet->setCellValue('N' . $row, $item->tipo_emp );
        $sheet->setCellValue('O' . $row, $item->fecha_nacimiento );
        $sheet->setCellValue('P' . $row, $item->fecha_ingreso );
        $sheet->setCellValue('Q' . $row, $item->codigo_nomina );
  

        $row++; // Incrementar el número de fila para el próximo registro

    }

    // Crear un objeto Writer para generar el archivo Excel
    $writer = new Xlsx($spreadsheet);

    // Guardar el archivo en una ubicación temporal
    $tempFilePath = sys_get_temp_dir() . '/NOMINA_TROPA_ALISTADA.xlsx';
    $writer->save($tempFilePath);

    // Crear una respuesta con el archivo Excel
    $response = new BinaryFileResponse($tempFilePath);
    $response->setContentDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        'NOMINA_TROPA_ALISTADA.xlsx'
    );

    //dd($item);
    // Devolver la respuesta
    return $response;
   return view('sireh.nomina.no_profesional.excel-vista', compact('nomina'));

    }
    
    //SECCION EXCEL MILITAR EN FORMACION
    
//EXCEL VISTA MILITAR EN FORMACION
    public function excelVistaNoProfMEF()
    {
        return view('sireh.nomina.noProf.excelvistaMEF');
    }

//PROCESS EXCELL MILITAR EN FORMACION

    public function excelProcessNoProfMEF()
    {
    // Crear una instancia de Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Obtener la hoja activa del libro de Excel
    $sheet = $spreadsheet->getActiveSheet();

    // Definir los encabezados de las columnas
    $sheet->setCellValue('A1', 'COMPAÑIA');
    $sheet->setCellValue('B1', 'CODIGO_UBICACION');
    $sheet->setCellValue('C1', 'NOMBRE_UBICACION');
    $sheet->setCellValue('D1', 'GRADO');
    $sheet->setCellValue('E1', 'CONTINGENTE');
    $sheet->setCellValue('F1', 'NACIONALIDAD');
    $sheet->setCellValue('G1', 'CEDULA');
    $sheet->setCellValue('H1', 'APELLIDOS');
    $sheet->setCellValue('I1', 'NOMBRES');
    $sheet->setCellValue('J1', 'SEXO');
    $sheet->setCellValue('K1', 'DIRECCIÓN');
    $sheet->setCellValue('L1', 'TELEFONO');
    $sheet->setCellValue('M1', 'SUELDO');
    $sheet->setCellValue('N1', 'TIPO_TRABAJADOR');
    $sheet->setCellValue('O1', 'FECHA_NACIMIENTO');
    $sheet->setCellValue('P1', 'FECHA_INGRESO');
    $sheet->setCellValue('Q1', 'CODIGO_NOMINA');


    // Establecer el estilo para la primera fila
    $style = $sheet->getStyle('A1:Q1');
    $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $style->getAlignment()->setWrapText(true);
    // Ajustar el texto y centrarlo verticalmente
    $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $style->getAlignment()->setWrapText(true);

    // Establecer el estilo para la primera fila
    $style = $sheet->getStyle('A1:Q1');
    $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    // Obtener el objeto RowDimension de la primera fila
    $rowDimension = $sheet->getRowDimension(1);

    // Establecer la altura deseada para la primera fila
    $rowDimension->setRowHeight(50); 

    // Ajustar el ancho de las columnas B a E según el contenido
    $columnIterator = $sheet->getColumnIterator('A', 'Q');
    foreach ($columnIterator as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }

    // Establecer el estilo para todas las celdas
    $style = $sheet->getStyle($sheet->calculateWorksheetDimension());

    // Establecer el color de fondo y el color de texto
    $fill = $style->getFill();
    $fill->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('246193'); // Color de fondo azul
    $style->getFont()->getColor()->setRGB(Color::COLOR_WHITE); // Color de texto blanco

    // Establecer el color de las líneas de las celdas
    $border = $style->getBorders();
    $border->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);
    $border->getAllBorders()->getColor()->setRGB(Color::COLOR_BLACK); // Color de líneas negras



        
        // Obtener los registros de la nómina
    $nomina = Nomina::select('nomina.*', 'datos_militares.codigo_categoria', 'datos_militares.fecha_ultimo_ascenso', 'datos_militares.fecha_graduacion', 'grados_militares.siglas')
    ->whereIn('nomina.tipo_emp', ['MEF'])
    ->whereIn('nomina.situacion', ['S', 'A'])
    ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
    ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')

    // Obtener el nombre de la categoría por código de categoría
    ->leftJoin('categorias_militares', 'datos_militares.codigo_categoria', '=', 'categorias_militares.codigo_categoria')
    ->addSelect('categorias_militares.descripcion as nombre_categoria')
    ->get();

    // Obtener el porcentaje del sueldo base
    $sueldoBase = ConceptosNomina::where('codigo_concepto', '1')
    ->pluck('porcentaje')
    ->first();

    

    // Iterar sobre los datos y escribirlos en las celdas correspondientes
    $row = 2; // La primera fila ya está ocupada por los encabezados, así que comenzamos en la segunda fila
    
    foreach ($nomina as $item) {
    $fechaGraduacion = Carbon::parse($item->fecha_graduacion);
    $antiguedad = $fechaGraduacion->diffInYears(Carbon::now());
    $item->antiguedad = $antiguedad;

    // Verificar el valor de la columna "codigo_cia" y almacenarlo en una variable
    $codigo_cia = ($item->codigo_cia == '1') ? 'AVIACION MILITAR BOLIVARIANA' : $item->codigo_cia;

    // Utilizar la variable $codigo_cia en lugar de modificar directamente $item->codigo_cia
    $item->codigo_cia_modificado = $codigo_cia;

    // Calcular los años de servicio y la antigüedad en el grado
    $fechaAscenso = Carbon::parse($item->fecha_ultimo_ascenso);
    $antiguedadGrado = $fechaAscenso->diffInYears(Carbon::now());
    $item->antiguedadGrado = $antiguedadGrado;

    // Obtener el sexo
    $sexo = Empleado::where('codigo_empleado', $item->codigo_empleado)
        ->pluck('sexo')
        ->first();
    $item->sexo = $sexo;
    
    // Obtener la nacionalidad
    $nacionalidad = Empleado::where('codigo_empleado', $item->codigo_empleado)
        ->pluck('nacionalidad')
        ->first();
    $item->nacionalidad = $nacionalidad;

    // Obtener la direccion
    $direccion = Empleado::where('codigo_empleado', $item->codigo_empleado)
        ->pluck('direccion')
        ->first();
    $item->direccion = $direccion;

    // Obtener la telefono
    $telefono = Empleado::where('codigo_empleado', $item->codigo_empleado)
        ->pluck('telefono')
        ->first();
    $item->telefono = $telefono;

    // Obtener la fecha_nacimiento
    $fecha_nacimiento = Empleado::where('codigo_empleado', $item->codigo_empleado)
        ->pluck('fecha_nacim')
        ->first();
    $item->fecha_nacimiento = $fecha_nacimiento;

    // Obtener la fecha_ingreso
    $fecha_ingreso = Nomina::where('codigo_empleado', $item->codigo_empleado)
        ->pluck('fecha_ingreso')
        ->first();
    $item->fecha_ingreso = $fecha_ingreso;

    // Obtener la codigo_nomina
    $codigo_nomina = Nomina::where('codigo_empleado', $item->codigo_empleado)
        ->pluck('codigo_nomina')
        ->first();
    $item->codigo_nomina = $codigo_nomina;

    // Obtener la antigüedad ajustada (máximo 5)
    $antiguedadAjustada = min($antiguedadGrado, 5);

    // Obtener el salario correspondiente al grado militar y la antigüedad
    $salario = Salarios::where('codigo_grado', $item->grado_militar)
        ->where('antiguedad', $antiguedadAjustada)
        ->pluck('porcentaje')
        ->first();
    $item->salario = $salario;

    // Verificar si la antigüedad es mayor a 30 y ajustarla a 30
    $antiguedad = min($antiguedad, 30);
    $item->antiguedad = $antiguedad;

    // Obtener la descripción del código de ubicación
    $ubicacion = Ubicaciones::where('codigo_ubicacion', $item->codigo_ubicacion)
        ->pluck('descripcion')
        ->first();
    $item->ubicacion = $ubicacion;

    // Calcular el sueldo por grado
    $porcentajeSalario = Salarios::where('codigo_grado', $item->grado_militar)
        ->pluck('porcentaje')
        ->first();
    $sueldoGrado = $sueldoBase * $porcentajeSalario; 
    
    $item->sueldo_grado = $sueldoGrado;
    

    // Obtener el porcentaje del modelo ConceptosNomina
    $porcentajeConcepto = ConceptosNomina::where('codigo_concepto', '500')
    ->where('antiguedad', $antiguedad)
    ->pluck('porcentaje')
    ->first();
    $item->porcentaje_concepto = $porcentajeConcepto;

    // Mostrar el sueldo base
    $sueldoBase = ConceptosNomina::where('codigo_concepto', '1')
    ->pluck('porcentaje')
    ->first();
        
    // Obtener el monto del sueldo base
    $sueldoBase = ConceptosNomina::where('codigo_concepto', '1')
    ->pluck('porcentaje')
    ->first();
    
    $item->sueldo_base = $sueldoBase;



        $sheet->setCellValue('A' . $row, $item->codigo_ubicacion );
        $sheet->setCellValue('B' . $row, $item->ubicacion );
        $sheet->setCellValue('C' . $row, $item->siglas );
        $sheet->setCellValue('D' . $row, $item->ubicacion );
        $sheet->setCellValue('E' . $row, $item->ubicacion);
        $sheet->setCellValue('F' . $row, $item->nacionalidad );
        $sheet->setCellValue('G' . $row, $item->cedula );
        $sheet->setCellValue('H' . $row, $item->apellido1 . ' ' . $item->apellido2 );
        $sheet->setCellValue('I' . $row, $item->nombre1 . ' ' . $item->nombre2);
        $sheet->setCellValue('J' . $row, $item->sexo );
        $sheet->setCellValue('K' . $row, $item->direccion );
        $sheet->setCellValue('L' . $row, $item->telefono );
        $sheet->setCellValue('M' . $row, $item->sueldo_grado );
        $sheet->setCellValue('N' . $row, $item->tipo_emp );
        $sheet->setCellValue('O' . $row, $item->fecha_nacimiento );
        $sheet->setCellValue('P' . $row, $item->fecha_ingreso );
        $sheet->setCellValue('Q' . $row, $item->codigo_nomina );
  

        $row++; // Incrementar el número de fila para el próximo registro

    }

    // Crear un objeto Writer para generar el archivo Excel
    $writer = new Xlsx($spreadsheet);

    // Guardar el archivo en una ubicación temporal
    $tempFilePath = sys_get_temp_dir() . '/NOMINA_MILITAR_EN_FORMACION.xlsx';
    $writer->save($tempFilePath);

    // Crear una respuesta con el archivo Excel
    $response = new BinaryFileResponse($tempFilePath);
    $response->setContentDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        'NOMINA_MILITAR_EN_FORMACION.xlsx'
    );

    //dd($item);
    // Devolver la respuesta
    return $response;
   //return view('sireh.nomina.no_profesional.excel-vista_mef', compact('nomina'));

    }
    


}