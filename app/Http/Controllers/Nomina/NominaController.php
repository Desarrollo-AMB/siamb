<?php

namespace App\Http\Controllers\Nomina;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\asignaciones;
use App\Models\ConceptosNomina;
use App\Models\Empleado;
use App\Models\Salarios;
use App\Models\Nomina;
use App\Models\Familiares;
use App\Models\Ubicaciones;
use App\Models\CategoriasMilitares;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;



class NominaController extends Controller
{

 //INDEX PRINCIPAL DE NOMINA

    public function indexNomina()
    {
        $conceptos = ConceptosNomina::whereIn('codigo_concepto', [1, 2, 53, 54, 55, 545])
            ->pluck('porcentaje', 'codigo_concepto');

        return view('sireh.nomina.index', compact('conceptos'));
    }


    public function militarNomina()
    {
        return view('sireh.nomina.personal_militar.militar');
    }
    public function NoProfNomina()
    {
        return view('sireh.nomina.no_profesional.noprof');
    }
    public function sueldoBase()
    {
        $data = ConceptosNomina::select('*')
        ->whereIn('codigo_concepto', [1, 2])
        ->get();
      //return($data[0]['codigo_concepto']);
        return view('sireh.nomina.sueldo_base',compact('data'));
    }

                                   //SUELDO BASE
    public function updateSueldo(Request $request)
    {

        $id = $request->id;
        $descripcion = $request->descripcion;
        $porcentaje = $request->porcentaje;
        $idali = $request->idali;
        $descripcionali = $request->descripcionali;
        $porcentajeali = $request->porcentajeali;

        $updatesueldo = ConceptosNomina::find($id);
        $updatesueldo->descripcion = $descripcion;
        $updatesueldo->porcentaje = $porcentaje;
        $updatesueldo->save();

        $updatealimentacion = ConceptosNomina::find($idali);
        $updatealimentacion->descripcion = $descripcionali;
        $updatealimentacion->porcentaje = $porcentajeali;
        $updatealimentacion->save();

        //return($request);
            return redirect()->route('sireh.nomina.index')
            ->with('success','Sueldo y Bono de alimentación actualizados con éxito');
    }
                                   //PERSONAL MILITAR
//SECCION DE PRIMAS
//Ver Primas
    public function primas(Request $request)
    {
        $data = ConceptosNomina::
            select('*',)
            ->where ('tipo', 'A')
            ->get();
      //dd($data);
        return view('sireh.nomina.personal_militar.primas',compact('data'));
    }

//Editar prima

    public function edit(Request $request)
    {
        //$data = ConceptosNomina::find('$request');
        $data = $request;

      //dd($request);
      return $data;
        //return view('sireh.nomina.prima-edit',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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
//EDIT PRIMA 2
    public function editPrima (ConceptosNomina $id){

       // $prima = ConceptosNomina::find($id);
        return view('sireh.nomina.personal_militar.primas-edit',compact('id'));
    }
//UPDATE PRIMAS
/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [

            'descripcion' => 'required',
            'porcentaje' => 'required',
        ]);

        $universidades = ConceptosNomina::find($id);
        $universidades->descripcion = $request->input('descripcion');
        $universidades->porcentaje = $request->input('porcentaje');
        $universidades->save();
            return redirect()->route('sireh.nomina.primas')
            ->with('success','Prima actualizada con éxito');
    }

//Delete Primas
    public function deleteprimas($id)
    {
        ConceptosNomina::find($id)->delete();
        //\DB::table("cargos")->where('id',$id)->delete();
        return redirect()->route('sireh.nomina.primas');
    }
//Delete Primas Asignadas

public function deletePrimaAsignada(Request $request, $id)

{
   asignaciones::find($id)->delete();

    $cedula = $request->cedula;
    $empleado = Empleado::
        select('codigo_empleado','nombre1', 'apellido1')
        ->where ('cedula', $cedula)
        ->first();

    $asignaciones = Asignaciones::
    select('asignaciones.*', 'Empleados.codigo_empleado', 'Empleados.nombre1', 'Empleados.apellido1','primas_deducciones.descripcion as nombre')
    ->join('primas_deducciones', 'primas_deducciones.codigo_concepto', '=', 'asignaciones.id_concepto')
    ->join('Empleados', 'asignaciones.codigo_empleado', '=', 'Empleados.codigo_empleado')
    ->where('Empleados.cedula', $cedula)
    ->where('Asignaciones.tipo_concepto', 'A')
    ->with('conceptoNomina')
    ->get();

    $conceptos_nomina = ConceptosNomina::
        select('codigo_concepto', 'descripcion', 'tipo')
        ->where('tipo', 'A')
        ->get();

    $empleado_nombre = $empleado->nombre1;
    $empleado_apellido = $empleado->apellido1;

    $codigo_empleado=$empleado->codigo_empleado;

        $dataemp = [
            'empleado_nombre' => $empleado_nombre,
            'empleado_apellido' => $empleado_apellido,
            'cedula' => $cedula,
            'conceptos_nomina' => $conceptos_nomina,
            'codigo_empleado' => $codigo_empleado,
        ];

    //return($asignaciones);

    return view('sireh.nomina.personal_militar.actuales-primas',compact('asignaciones', 'conceptos_nomina', 'dataemp'));
}

                                      //ASIGNACION DE PRIMAS
    //SECCION DE SUELDOS
//Introducir cedula
public function asignacionPrima()
{
    return view('sireh.nomina.personal_militar.nueva-prima');
}

//asignacion del profesional
public function actualesPrimas(Request $request)
    {
        $cedula = $request->cedula;
        $empleado = Empleado::
        select('codigo_empleado','nombre1', 'apellido1')
        ->where ('cedula', $cedula)
        ->first();

        if (!$empleado) {
            // Si la consulta no devuelve ningún resultado, el empleado no existe
            // Almacenamos un mensaje de error en la sesión
            session()->flash('error', 'El profesional con cédula '.$cedula.' no existe.');

            // Redirigimos al usuario a la página anterior
            return redirect()->back();
        }
        $asignaciones = Asignaciones::
        select('asignaciones.*', 'Empleados.codigo_empleado', 'Empleados.nombre1', 'Empleados.apellido1','primas_deducciones.descripcion as nombre')
        ->join('primas_deducciones', 'primas_deducciones.codigo_concepto', '=', 'asignaciones.id_concepto')
        ->join('Empleados', 'asignaciones.codigo_empleado', '=', 'Empleados.codigo_empleado')
        ->where('Empleados.cedula', $cedula)
        ->where('Asignaciones.tipo_concepto', 'A')
        ->with('conceptoNomina')
        ->get();

        $empleado_nombre = $empleado->nombre1;
        $empleado_apellido = $empleado->apellido1;

        $conceptos_nomina = ConceptosNomina::
        select('codigo_concepto', 'descripcion', 'tipo')
        ->where('tipo', 'A')
        ->get();

        $codigo_empleado=$empleado->codigo_empleado;

        $dataemp = [
            'empleado_nombre' => $empleado_nombre,
            'empleado_apellido' => $empleado_apellido,
            'cedula' => $cedula,
            'conceptos_nomina' => $conceptos_nomina,
            'codigo_empleado' => $codigo_empleado,
        ];
//return($codigo_empleado);
      return view('sireh.nomina.personal_militar.actuales-primas',compact('asignaciones', 'conceptos_nomina', 'dataemp'));

    }

 //asignacion de nueva prima
//Nueva prima
public function asignacionNuevaPrima(Request $request)
{
    // Obtener los datos del formulario
    $codigo_concepto = $request->input('codigo_concepto');
    $cedula = $request->input('cedula');
    $empleado_nombre = $request->input('nombre');
    $empleado_apellido = $request->input('apellido');
    $codigo_empleado = $request->input('codigo_empleado');
    $tipo = $request->input('tipo');

    // Obtener conceptos de nómina
    $conceptos_nomina = ConceptosNomina::select('codigo_concepto', 'descripcion', 'tipo')
        ->where('tipo', 'A')
        ->get();

    // Obtener datos del empleado
    $empleado = Empleado::select('codigo_empleado', 'nombre1', 'apellido1')
        ->where('cedula', $cedula)
        ->first();

    // Obtener asignaciones existentes del empleado
    $asignaciones = Asignaciones::select('asignaciones.*', 'Empleados.codigo_empleado', 'Empleados.nombre1', 'Empleados.apellido1', 'primas_deducciones.descripcion as nombre')
        ->join('primas_deducciones', 'primas_deducciones.codigo_concepto', '=', 'asignaciones.id_concepto')
        ->join('Empleados', 'asignaciones.codigo_empleado', '=', 'Empleados.codigo_empleado')
        ->where('Empleados.cedula', $cedula)
        ->where('Asignaciones.tipo_concepto', 'A')
        ->with('conceptoNomina')
        ->get();

    // Verificar si existe una asignación existente
    $asignacionExistente = Asignaciones::withTrashed()
        ->where('codigo_empleado', $codigo_empleado)
        ->where('id_concepto', $codigo_concepto)
        ->first();

    // Realizar las acciones según corresponda
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

    // Obtener nuevamente las asignaciones después de los cambios
    $asignaciones = Asignaciones::select('asignaciones.*', 'Empleados.codigo_empleado', 'Empleados.nombre1', 'Empleados.apellido1', 'primas_deducciones.descripcion as nombre')
        ->join('primas_deducciones', 'primas_deducciones.codigo_concepto', '=', 'asignaciones.id_concepto')
        ->join('Empleados', 'asignaciones.codigo_empleado', '=', 'Empleados.codigo_empleado')
        ->where('Empleados.cedula', $cedula)
        ->where('Asignaciones.tipo_concepto', 'A')
        ->with('conceptoNomina')
        ->get();

    // Preparar los datos para pasar a la vista
    $dataemp = [
        'empleado_nombre' => $empleado_nombre,
        'empleado_apellido' => $empleado_apellido,
        'cedula' => $cedula,
        'conceptos_nomina' => $conceptos_nomina,
        'codigo_empleado' => $codigo_empleado,
    ];

    // Renderizar la vista con los datos actualizados y los mensajes flash
    return view('sireh.nomina.personal_militar.actuales-primas', compact('asignaciones', 'conceptos_nomina', 'dataemp'));

}

                                    //SECCION DE DEDUCCIONES

//Ver deducciones
public function deducciones(Request $request)
{
    $data = ConceptosNomina::select('*')
        ->where('tipo', 'D')
        ->where('tipo_empleado', 'MIL')
        ->get();

    return view('sireh.nomina.personal_militar.deducciones', compact('data'));
}
//EDIT PRIMA 2
public function editdeducciones (ConceptosNomina $id){

    // $prima = ConceptosNomina::find($id);
     return view('sireh.nomina.personal_militar.deducciones-edit',compact('id'));
 }

 //UPDATE PRIMAS
/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDeducciones(Request $request, $id)
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
    public function deletededucciones($id)
    {
        ConceptosNomina::find($id)->delete();
        //\DB::table("cargos")->where('id',$id)->delete();
        return redirect()->route('sireh.nomina.deducciones');
    }

//Introducir cedula
public function nuevaDeduccion()
{
    return view('sireh.nomina.personal_militar.nueva-deduccion');
}

//Delete Primas Asignadas

public function deleteDeduccionesAsignadas(Request $request, $id)

{
   asignaciones::find($id)->delete();

    $cedula = $request->cedula;
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

    $conceptos_nomina = ConceptosNomina::
        select('codigo_concepto', 'descripcion', 'tipo')
        ->where('tipo', 'D')
        ->get();

    $empleado_nombre = $empleado->nombre1;
    $empleado_apellido = $empleado->apellido1;

    $codigo_empleado=$empleado->codigo_empleado;

        $dataemp = [
            'empleado_nombre' => $empleado_nombre,
            'empleado_apellido' => $empleado_apellido,
            'cedula' => $cedula,
            'conceptos_nomina' => $conceptos_nomina,
            'codigo_empleado' => $codigo_empleado,
        ];

    //return($asignaciones);

    return view('sireh.nomina.personal_militar.actuales_deducciones',compact('asignaciones', 'conceptos_nomina', 'dataemp'));
}


//asignacion del profesional
public function actualesdeducciones(Request $request)
    {
        $cedula = $request->cedula;
        $empleado = Empleado::
        select('codigo_empleado','nombre1', 'apellido1')
        ->where ('cedula', $cedula)
        ->first();

        if (!$empleado) {
            // Si la consulta no devuelve ningún resultado, el empleado no existe
            // Almacenamos un mensaje de error en la sesión
            session()->flash('error', 'El profesional con cédula '.$cedula.' no existe.');

            // Redirigimos al usuario a la página anterior
            return redirect()->back();
        }
        $asignaciones = Asignaciones::select('Asignaciones.*', 'empleados.codigo_empleado', 'empleados.nombre1', 'empleados.apellido1','primas_deducciones.descripcion as nombre')
        ->join('empleados', 'Asignaciones.codigo_empleado', '=', 'empleados.codigo_empleado')
        ->leftjoin('primas_deducciones','primas_deducciones.codigo_concepto', '=', 'asignaciones.id_concepto')
        ->where('Empleados.cedula', $cedula)
        ->where('Asignaciones.tipo_concepto', 'D')

        ->get();

        $empleado_nombre = $empleado->nombre1;
        $empleado_apellido = $empleado->apellido1;

        $conceptos_nomina = ConceptosNomina::
        select('codigo_concepto', 'descripcion', 'tipo')
        ->where('tipo', 'D')
        ->get();

        $codigo_empleado=$empleado->codigo_empleado;

        $dataemp = [
            'empleado_nombre' => $empleado_nombre,
            'empleado_apellido' => $empleado_apellido,
            'cedula' => $cedula,
            'conceptos_nomina' => $conceptos_nomina,
            'codigo_empleado' => $codigo_empleado,
        ];
//return($conceptos_nomina);
      return view('sireh.nomina.personal_militar.actuales_deducciones',compact('asignaciones', 'conceptos_nomina', 'dataemp'));

    }

    public function insertarDeduccion(Request $request)
{
    $codigo_concepto = $request->input('codigo_concepto');
    $cedula = $request->input('cedula');
    $empleado_nombre = $request->input('nombre');
    $empleado_apellido = $request->input('apellido');
    $cedula = $request->input('cedula');
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

    $conceptos_nomina = ConceptosNomina::
        select('codigo_concepto', 'descripcion', 'tipo')
        ->where('tipo', 'D')
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
        ->where('cedula', $cedula)
        ->first();

    $asignaciones = Asignaciones::select('Asignaciones.*', 'empleados.codigo_empleado', 'empleados.nombre1', 'empleados.apellido1','primas_deducciones.descripcion as nombre')
        ->join('empleados', 'Asignaciones.codigo_empleado', '=', 'empleados.codigo_empleado')
        ->leftjoin('primas_deducciones','primas_deducciones.codigo_concepto', '=', 'asignaciones.id_concepto')
        ->where('Empleados.cedula', $cedula)
        ->where('Asignaciones.tipo_concepto', 'D')
        ->get();

    return view('sireh.nomina.personal_militar.actuales_deducciones', compact('asignaciones', 'conceptos_nomina', 'dataemp'))->render();
}


                        //SECCION DE DEDUCCION SUELDO

//VISTA CAMBIO DE SUELDO

public function sueldosMil()
{
    $salarios = Salarios::select('*')
                        ->where('tipo_emp', 'MIL')
                        ->get();

    // dd($salarios); // Puedes utilizar dd para depurar y verificar si los datos se obtienen correctamente

    return view('sireh.nomina.personal_militar.sueldo', compact('salarios'));
}


//MODIFICACION DE SUELDO
public function editSueldosMil(Request $request)
{
    $inputs = $request->except('_token');

    foreach ($inputs as $key => $value) {
        $id = intval($key);

        $salario = Salarios::find($id);

        if ($salario && $value !== null) {
            $salario->porcentaje = $value;
            $salario->save();
        }
    }
//return($inputs);
return redirect()->route('sireh.nomina.militar')
       ->with('success','Los PORCENTAJES de SUELDO POR GRADO han sido actualizados con éxito');

}

                               //SECCION EXCEL

//PROCESS

public function excelProcess()
{
// Crear una instancia de Spreadsheet
$spreadsheet = new Spreadsheet();

// Obtener la hoja activa del libro de Excel
$sheet = $spreadsheet->getActiveSheet();

// Definir los encabezados de las columnas
$sheet->setCellValue('A1', 'GRADO');
$sheet->setCellValue('B1', 'CATEGORIA');
$sheet->setCellValue('C1', 'CÉDULA');
$sheet->setCellValue('D1', 'NOMBRES');
$sheet->setCellValue('E1', 'UBICACIÓN');
$sheet->setCellValue('F1', 'SUELDO BÁSICO');
$sheet->setCellValue('G1', 'FECHA ULTIMO ASCENSO');
$sheet->setCellValue('H1', 'AÑOS EN EL GRADO');
$sheet->setCellValue('I1', 'AÑOS DE SERVICIO');
$sheet->setCellValue('J1', 'FECHA DE INGRESO');
$sheet->setCellValue('K1', '% AÑOS DE SERVICIO');
$sheet->setCellValue('L1', 'PRIMA DE ANTIGUEDAD(0500)');
$sheet->setCellValue('M1', 'NRO DE HIJOS');
$sheet->setCellValue('N1', 'PRIMA POR HIJOS(4012)');
$sheet->setCellValue('O1', 'PRIMA RIESGOS TIPO A(4016)');
$sheet->setCellValue('P1', 'PRIMA RIESGOS TIPO B(4017)');
$sheet->setCellValue('Q1', 'PRIMA RIESGOS TIPO C(GHP 8%)');
$sheet->setCellValue('R1', 'FRONTERA TIPO A (0053)');
$sheet->setCellValue('S1', 'FRONTERA TIPO B (0054)');
$sheet->setCellValue('T1', 'FRONTERA TIPO C (0055)');
$sheet->setCellValue('U1', 'PRIMA PROFECIONALIZACION');
$sheet->setCellValue('V1', '% PROFECIONALIZACIÓN');
$sheet->setCellValue('W1', 'ASIGNACION ALIM. ACAD. HUGO CHAVEZ(0088)');
$sheet->setCellValue('X1', 'TOTAL ASIGNACIONES');
$sheet->setCellValue('Y1', 'TOTAL PRIMAS COMUNES');
$sheet->setCellValue('Z1', 'BONO FIN DE AÑO');
$sheet->setCellValue('AA1', 'SUELDO INTEGRAL');
$sheet->setCellValue('AB1', '6,5% IPSFA');
$sheet->setCellValue('AC1', '5% PENSIONES(9404)');
$sheet->setCellValue('AD1', 'DEDUCCION ALIM. HUGO CHAVEZ (5141)');
$sheet->setCellValue('AE1', 'CIRCULO MILITAR (9998)');
$sheet->setCellValue('AF1', 'CAJA DE AHORRO 10% (5565)');
$sheet->setCellValue('AG1', 'PENSION ALIMENTACIÓN (5087)');
$sheet->setCellValue('AH1', 'L.P.H(5003)');
$sheet->setCellValue('AI1', 'TOTAL DE DEDUCCIONES');
$sheet->setCellValue('AJ1', 'DEPOSITO EN BANCO');


// Establecer el estilo para la primera fila
$style = $sheet->getStyle('A1:AJ1');
$style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$style->getAlignment()->setWrapText(true);
// Ajustar el texto y centrarlo verticalmente
$style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$style->getAlignment()->setWrapText(true);

// Establecer el estilo para la primera fila
$style = $sheet->getStyle('A1:E1');
$style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

// Ajustar el ancho de las columnas B a E según el contenido
$columnIterator = $sheet->getColumnIterator('B', 'E');
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
->whereIn('nomina.tipo_emp', ['MIL', 'TRP'])
->whereIn('nomina.situacion', ['S', 'A'])
//->whereIn('nomina.grado_militar', ['020'])
//->take(8)
->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')

// Calcular la cantidad de hijos del profesional
->withCount(['familiares' => function ($query) {
    $query->where('parentesco', 'H');
}])

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
// Calcular los años de servicio y la antigüedad en el grado
foreach ($nomina as $item) {
$fechaGraduacion = Carbon::parse($item->fecha_graduacion);
$antiguedad = $fechaGraduacion->diffInYears(Carbon::now());
$item->antiguedad = $antiguedad;

$fechaAscenso = Carbon::parse($item->fecha_ultimo_ascenso);
$antiguedadGrado = $fechaAscenso->diffInYears(Carbon::now());
$item->antiguedadGrado = $antiguedadGrado;

// Agregar la prima por hijos y la cantidad de hijos
//se trae el monto de la tabla primas_deducciones
$montoPorHijo = ConceptosNomina::where('codigo_concepto', '4012')
->pluck('porcentaje')
->first();
$montoPorHijo = $montoPorHijo;
//se multiplica la cantidad por el monto
$cantidadHijos = $item->familiares_count;
$primaPorHijos = $cantidadHijos * $montoPorHijo;
$item->prima_por_hijos = $primaPorHijos;

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
    ->where('antiguedad', $antiguedadAjustada)
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

// Calcular el monto de la prima de antigüedad
$montoPrimaAntiguedad = $sueldoGrado * ($porcentajeConcepto / 100);
$item->monto_prima_antiguedad = $montoPrimaAntiguedad;

// Calcular la prima de riesgo tipo A
$primaRiesgoTipoA = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->where('id_concepto', '4016')
    ->pluck('porcentaje')
    ->first();

    if ($primaRiesgoTipoA) {
        $montoPrimaRiesgoTipoA = $sueldoGrado * ($primaRiesgoTipoA / 100);
        $item->prima_riesgo_tipo_a = $montoPrimaRiesgoTipoA;
    } else {
        $item->prima_riesgo_tipo_a = '0';
    }

// Calcular la prima de riesgo tipo B
$primaRiesgoTipoB = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->where('id_concepto', '4017')
    ->pluck('porcentaje')
    ->first();

    if ($primaRiesgoTipoB) {
        $montoPrimaRiesgoTipoB = $sueldoGrado * ($primaRiesgoTipoB / 100);
        $item->prima_riesgo_tipo_b = $montoPrimaRiesgoTipoB;
    } else {
        $item->prima_riesgo_tipo_b = '0';
    }

// Calcular la prima de riesgo tipo C
$primaRiesgoTipoC = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->where('id_concepto', '4018')
    ->pluck('porcentaje')
    ->first();

    if ($primaRiesgoTipoC) {
        $montoPrimaRiesgoTipoC = $sueldoGrado * ($primaRiesgoTipoC / 100);
        $item->prima_riesgo_tipo_c = $montoPrimaRiesgoTipoC;
    } else {
        $item->prima_riesgo_tipo_c = '0';
    }

// Calcular la prima de frontera tipo A
$primaFronteraTipoA = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->where('id_concepto', '53')
    ->pluck('porcentaje')
    ->first();

    if ($primaFronteraTipoA) {
        $montoprimaFronteraTipoA = $sueldoGrado * ($primaFronteraTipoA / 100);
        $item->prima_frontera_tipo_a = $montoprimaFronteraTipoA;
    } else {
        $item->prima_frontera_tipo_a = '0';
    }

// Calcular la prima de frontera tipo B
$primaFronteraTipoB = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->where('id_concepto', '55')
    ->pluck('porcentaje')
    ->first();

    if ($primaFronteraTipoB) {
        $montoprimaFronteraTipoB = $sueldoGrado * ($primaFronteraTipoB / 100);
        $item->prima_frontera_tipo_b = $montoprimaFronteraTipoB;
    } else {
        $item->prima_frontera_tipo_b = '0';
    }

// Calcular la prima de frontera tipo C
$primaFronteraTipoC = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->where('id_concepto', '54')
    ->pluck('porcentaje')
    ->first();

    if ($primaFronteraTipoC) {
        $montoprimaFronteraTipoC = $sueldoGrado * ($primaFronteraTipoC / 100);
        $item->prima_frontera_tipo_c = $montoprimaFronteraTipoC;
    } else {
        $item->prima_frontera_tipo_c = '0';
    }


// Obtener los códigos de concepto de prima de profesionalización
$conceptosPrimaProf = ['3026', '3027', '3028', '3029', '3030'];

// Calcular la prima de profesionalización
$primaDeProfesionalizacion = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->whereIn('id_concepto', $conceptosPrimaProf)
    ->pluck('porcentaje')
    ->sum();

if ($primaDeProfesionalizacion > 0) {
    $montoPrimaDeProfesionalizacion = $sueldoGrado * ($primaDeProfesionalizacion / 100);
    $item->prima_de_profesionalizacion = $montoPrimaDeProfesionalizacion;
} else {
    $item->prima_de_profesionalizacion = '0';
}

// Calcular la asignacion alimenticia academia Hugo Chavez
$primaAlimentacionHugoChavez = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->where('id_concepto', '88')
    ->pluck('porcentaje')
    ->sum();

if ($primaAlimentacionHugoChavez > 0) {
    $montoprimaAlimentacionHugoChavez = $sueldoGrado * ($primaAlimentacionHugoChavez / 100);
    $item->prima_alimentacion_hugo_chavez = $montoprimaAlimentacionHugoChavez;
} else {
    $item->prima_alimentacion_hugo_chavez = '0';
}

    // Obtener el grado militar del $item
    $gradoMilitar = $item->grado_militar;

    // Variable para almacenar el código de concepto correspondiente
    $codigoConcepto = '';

    // Asignar el código de concepto según el grado militar
    switch ($gradoMilitar) {
        case '470':
        case '460':
        case '450':
        case '440':
        case '430':
            $codigoConcepto = '106';
            break;
        case '420':
        case '410':
        case '090':
        case '080':
        case '070':
            $codigoConcepto = '545';
            break;
        case '060':
        case '050':
            $codigoConcepto = '544';
            break;
        case '040':
        case '030':
        case '020':
            $codigoConcepto = '539';
            break;
        case '015':
        case '010':
            $codigoConcepto = '538';
            break;
        default:
            // Código de concepto por defecto si no se cumple ninguna condición
            $codigoConcepto = 'default_code';
    }

    // Asignar el código de concepto al $item
    $item->codigo_concepto = $codigoConcepto;

    //calculo del porcentaje de la prima de profecionalizacion
    $primaDeProfesionalizacion = ConceptosNomina::where('codigo_concepto', $codigoConcepto )
    ->pluck('porcentaje')
    ->sum();

    $item->prima_prof = $primaDeProfesionalizacion;

    //calculo del monto de la prima de profecionalizacion
    $montoPrimaProf = ($primaDeProfesionalizacion / 100) * $sueldoGrado;
    $item->monto_prima_prof = $montoPrimaProf;

// Calcular la suma de las asignaciones
$montoTotal = ($montoPrimaAntiguedad ?? 0) + ($primaPorHijos ?? 0) + ($montoPrimaRiesgoTipoA ?? 0) +
    ($montoPrimaRiesgoTipoB ?? 0) + ($montoPrimaRiesgoTipoC ?? 0) + ($montoprimaFronteraTipoA ?? 0) +
    ($montoprimaFronteraTipoB ?? 0) + ($montoprimaFronteraTipoC ?? 0) + ($montoPrimaProf ?? 0) +
    ($montoprimaAlimentacionHugoChavez ?? 0) + ($sueldoGrado ?? 0);

$item->monto_total = $montoTotal;

// Calcular la suma primas comunes
$montoTotalComunes = ($montoPrimaAntiguedad ?? 0) + ($montoPrimaProf ?? 0) + ($sueldoBase ?? 0);

$item->monto_total_comunes = $montoTotalComunes;

// Mostrar el sueldo base
$sueldoBase = ConceptosNomina::where('codigo_concepto', '1')
->pluck('porcentaje')
->first();

$item->porcentaje_prima_prof = $primaDeProfesionalizacion;

// Obtener el monto del sueldo base
$sueldoBase = ConceptosNomina::where('codigo_concepto', '1')
->pluck('porcentaje')
->first();

$item->sueldo_base = $sueldoBase;

// Calcular el bono vacacional
$bonoVacacional = ($montoTotalComunes ?? 0) / 30 * 120;
$item->bono_vacacional = $bonoVacacional;

                            // CALCULO 6.5 IPSFA

// Obtener el porcentaje de la deducción 6.5 IPSFA
$porcentajeDeduccion6IPSFA = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->where('id_concepto', '9400')
    ->pluck('porcentaje')
    ->sum();

if ($porcentajeDeduccion6IPSFA > 0) {
    $deduccion6IPSFA = $sueldoGrado * ($porcentajeDeduccion6IPSFA / 100);
    $item->deduccion6IPSFA = $deduccion6IPSFA;
} else {
    $item->deduccion6IPSFA = '0';
}

                            // CALCULO PENSIONES

// Obtener el porcentaje de la deducción PENSIONES
$porcentajepensiones = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->where('id_concepto', '9404')
    ->pluck('porcentaje')
    ->sum();

if ($porcentajepensiones > 0) {
    $pensiones = $sueldoGrado * ($porcentajepensiones / 100);
    $item->pensiones = $pensiones;
} else {
    $item->pensiones = '0';
}


                 // CALCULO DEDUCCION ALIM. ACADEMIA. HUGO CHAVEZ

// Obtener el porcentaje de la deducción alim hugo chavez
$porcentaje_alimentacion_hugochavez = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->where('id_concepto', '5141')
    ->pluck('porcentaje')
    ->sum();

if ($porcentajepensiones > 0) {
    $alimentacion_hugochavez = $sueldoGrado * ($porcentaje_alimentacion_hugochavez / 100);
    $item->alimentacion_hugochavez = $alimentacion_hugochavez;
} else {
    $item->alimentacion_hugochavez = '0';
}


                            // CALCULO DEDUCCIÓN CIRCULO MILITAR

// Obtener el porcentaje de la deducción CIRCULO MILITAR
$porcentaje_circulo_militar = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->where('id_concepto', '9998')
    ->pluck('porcentaje')
    ->sum();

if ($porcentajepensiones > 0) {
    // Calcular el monto de la deducción CIRCULO MILITAR
    $circulomilitar = $sueldoGrado * ($porcentaje_circulo_militar / 100);
    $item->circulomilitar = $circulomilitar;
} else {
    $item->circulomilitar = '0';
}


                            // CALCULO DEDUCCIÓN CAJA DE AHORRO

// Obtener el porcentaje de la deducción CAJA DE AHORRO
$porcentaje_caja_ahorro = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->where('id_concepto', '5565')
    ->pluck('porcentaje')
    ->sum();

if ($porcentajepensiones > 0) {
    // Calcular el monto de la deducción CAJA DE AHORRO
    $caja_ahorro = $sueldoGrado * ($porcentaje_caja_ahorro / 100);
    $item->caja_ahorro = $caja_ahorro;
} else {
    $item->caja_ahorro = '0';
}


                            // CALCULO DEDUCCIÓN PENSION DE ALIMENTACION

// Obtener el porcentaje de la deducción PENSION DE ALIMENTACION
$porcentaje_pension_alimentacion = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->where('id_concepto', '5087')
    ->pluck('porcentaje')
    ->sum();

if ($porcentajepensiones > 0) {
    // Calcular el monto de la deducción PENSION DE ALIMENTACION
    $pension_alimentacion = $sueldoGrado * ($porcentaje_pension_alimentacion / 100);
    $item->pension_alimentacion = $pension_alimentacion;
} else {
    $item->pension_alimentacion = '0';
}

                        // CALCULO DEDUCCIÓN L.P.H

// Obtener el porcentaje de la deducción L.P.H
$porcentaje_LPH = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->where('id_concepto', '5003')
    ->pluck('porcentaje')
    ->sum();

if ($porcentajepensiones > 0) {
    // Calcular el monto de la deducción L.P.H
    $porcentaje_LPH = $sueldoGrado * ($porcentaje_LPH / 100);
    $item->l_p_h = $porcentaje_LPH;
} else {
    $item->l_p_h = '0';
}

                        // CALCULO DESCUENTO DE ARMAMENTO

// Obtener el porcentaje de la deducción armamento
$armamento = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->where('id_concepto', '0000')
    ->pluck('porcentaje')
    ->sum();

if ($porcentajepensiones > 0) {
    // Calcular el monto de la deducción armamento
    $armamento = $sueldoGrado * ($armamento / 100);
    $item->armamento = $armamento;
} else {
    $item->armamento = '0';
}

// Sumar todas las deducciones
$totalDeducciones = $item->deduccion6IPSFA +
                    $item->pensiones +
                    $item->alimentacion_hugochavez +
                    $item->circulomilitar +
                    $item->caja_ahorro +
                    $item->pension_alimentacion +
                    $item->l_p_h +
                    $item->armamento;

// Verificar si el total de deducciones es igual a cero
if ($totalDeducciones == 0) {
    $totalDeducciones = '0'; // Convertir a string para enviar '0' en lugar de 0
}

// Asignar el total de deducciones al objeto $item
$item->total_deducciones = $totalDeducciones;


                            // CALCULAR TOTAL DE DEPOSITO EN BANCO

$totalDepositoEnBanco = ($montoTotal ?? 0) - ($montoTotalDeducciones ?? 0);

// Verificar si el total de depósito en el banco es igual a cero
if ($totalDepositoEnBanco == 0) {
    $totalDepositoEnBanco = '0'; // Convertir a string para enviar '0' en lugar de 0
}

// Asignar el total de depósito en el banco al campo correspondiente
$item->deposito_en_banco = $totalDepositoEnBanco;

    $sheet->setCellValue('A' . $row, $item->siglas);
    $sheet->setCellValue('B' . $row, $item->nombre_categoria);
    $sheet->setCellValue('C' . $row, $item->cedula);
    $sheet->setCellValue('D' . $row, $item->nombre1 . ' ' . $item->nombre2 . ' ' . $item->apellido1 . ' ' . $item->apellido2);
    $sheet->setCellValue('E' . $row, $item->ubicacion);
    $sheet->setCellValue('F' . $row, $item->sueldo_grado);
    $sheet->setCellValue('G' . $row, $item->fecha_ultimo_ascenso);
    $sheet->setCellValue('H' . $row, $item->antiguedadGrado);
    $sheet->setCellValue('I' . $row, $item->antiguedad);
    $sheet->setCellValue('J' . $row, $item->fecha_graduacion);
    $sheet->setCellValue('K' . $row, $item->porcentaje_concepto);
    $sheet->setCellValue('L' . $row, $item->monto_prima_antiguedad);
    $sheet->setCellValue('M' . $row, $item->familiares_count);
    $sheet->setCellValue('N' . $row, $item->prima_por_hijos);
    $sheet->setCellValue('O' . $row, $item->prima_riesgo_tipo_a);
    $sheet->setCellValue('P' . $row, $item->prima_riesgo_tipo_b);
    $sheet->setCellValue('Q' . $row, $item->prima_riesgo_tipo_c);
    $sheet->setCellValue('R' . $row, $item->prima_frontera_tipo_a);
    $sheet->setCellValue('S' . $row, $item->prima_frontera_tipo_b);
    $sheet->setCellValue('T' . $row, $item->prima_frontera_tipo_c);
    $sheet->setCellValue('U' . $row, $item->prima_de_profesionalizacion);
    $sheet->setCellValue('V' . $row, $item->codigo_concepto);
    $sheet->setCellValue('W' . $row, $item->prima_alimentacion_hugo_chavez);
    $sheet->setCellValue('X' . $row, $item->monto_total);
    $sheet->setCellValue('Y' . $row, $item->monto_total_comunes);
    $sheet->setCellValue('Z' . $row, $item->bono_vacacional);
    $sheet->setCellValue('AA' . $row, $item->sueldo_base);
    $sheet->setCellValue('AB' . $row, $item->deduccion6IPSFA);
    $sheet->setCellValue('AC' . $row, $item->pensiones);
    $sheet->setCellValue('AD' . $row, $item->alimentacion_hugochavez);
    $sheet->setCellValue('AE' . $row, $item->circulomilitar);
    $sheet->setCellValue('AF' . $row, $item->caja_ahorro);
    $sheet->setCellValue('AG' . $row, $item->pension_alimentacion);
    $sheet->setCellValue('AH' . $row, $item->l_p_h);
    $sheet->setCellValue('AI' . $row, $item->total_deducciones);
    $sheet->setCellValue('AJ' . $row, $item->deposito_en_banco);


    $row++; // Incrementar el número de fila para el próximo registro

}

// Crear un objeto Writer para generar el archivo Excel
$writer = new Xlsx($spreadsheet);

// Guardar el archivo en una ubicación temporal
$tempFilePath = sys_get_temp_dir() . '/NOMINA_PERSONAL_MILITAR.xlsx';
$writer->save($tempFilePath);

// Crear una respuesta con el archivo Excel
$response = new BinaryFileResponse($tempFilePath);
$response->setContentDisposition(
    ResponseHeaderBag::DISPOSITION_ATTACHMENT,
    'NOMINA_PERSONAL_MILITAR.xlsx'
);

//dd($item);
// Devolver la respuesta
//return $response;
return view('sireh.nomina.personal_militar.excel-vista', compact('nomina'));

}




}