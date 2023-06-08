<?php

namespace App\Http\Controllers\Nomina;

use App\Http\Controllers\Controller;
use App\Models\asignaciones;
use App\Models\ConceptosNomina;
use App\Models\Empleado;
use Illuminate\Http\Request; 
use App\Models\Salarios;
use Carbon\Carbon;
use App\Models\Ubicaciones;
use App\Models\Cargos;
use App\Models\Nomina;
use App\Models\Familiares;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class NominaCivilController extends Controller
{

 //INDEX PRINCIPAL DE NOMINA
    public function indexNomina()
    {
        return view('sireh.nomina.personal_civil.militar');
    }

    public function militarNomina()
    {
        return view('sireh.nomina.personal_militar.militar');
    }
    public function NoProfNomina()
    {
        return view('sireh.nomina.no_profesional.noprof');
    }


                                   //PERSONAL MILITAR
//SECCION DE PRIMAS
//Ver Primas
    public function CivilNomina(Request $request)
    {
        $data = ConceptosNomina::
            select('*')
            ->where('tipo', 'A')
            ->whereIn('tipo_empleado', ['EMP', 'CON', 'OBR', 'DOC', 'MED', 'CEX', 'DTC'])
            ->get();

        return view('sireh.nomina.personal_civil.primas', compact('data'));
    }

//Editar prima

    public function civiledit(Request $request)
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
    //public function civilnueva(Request $request)
    //{
       // $prima = new ConceptosNomina();
       // $prima->codigo_concepto = $request->codigo;
       // $prima->descripcion = strtoupper($request->nombre);
       // $prima->porcentaje = $request->porcentaje;
       // $prima->tipo = 'A';
       // $prima->save();

       // return view('sireh.nomina.personal_militar.nueva-prima')
        //->with('success', 'Prima agregada con éxito');;

   // }
//EDIT PRIMA 2
    public function civileditPrima (ConceptosNomina $registro){

       // $prima = ConceptosNomina::find($id);
        return view('sireh.nomina.personal_civil.primas-edit',compact('registro'));
    }
//UPDATE PRIMAS
/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $registro
     * @return \Illuminate\Http\Response
     */
    public function civilupdate(Request $request, $registro)
    {

        $this->validate($request, [

            'descripcion' => 'required',
            'porcentaje' => 'required',
        ]);

        $universidades = ConceptosNomina::find($registro);
        $universidades->descripcion = $request->input('descripcion');
        $universidades->porcentaje = $request->input('porcentaje');
        $universidades->save();
            return redirect()->route('sireh.nomina.personal.civil.primas')
            ->with('success','Prima actualizada con éxito');
    }
//Delete Primas
    public function civildeleteprimas($id)
    {
        ConceptosNomina::find($id)->delete();
        //\DB::table("cargos")->where('id',$id)->delete();
        return redirect()->route('sireh.nomina.primas');
    }
//Delete Primas Asignadas

public function civildeletePrimaAsignada(Request $request, $id)
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
 
     $conceptos_nomina = ConceptosNomina::select('codigo_concepto', 'descripcion', 'tipo', 'tipo_empleado')
        ->where('tipo', 'A')
        ->whereIn('tipo_empleado', ['EMP'])
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
     
     return view('sireh.nomina.personal_civil.actuales-primas',compact('asignaciones', 'conceptos_nomina', 'dataemp'));
 }

                                      //ASIGNACION DE PRIMAS
    //SECCION DE SUELDOS
//Introducir cedula
public function civilasignacionPrima()
{
    return view('sireh.nomina.personal_civil.nueva-prima');
}

//asignacion del profesional
public function civilactualesPrimas(Request $request)
{
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
    ->whereIn('tipo_emp', ['EMP'])
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
    ->whereIn('tipo_empleado', ['EMP'])
    ->get();

    $dataemp = [
        'empleado_nombre' => $empleado_nombre,
        'empleado_apellido' => $empleado_apellido,
        'cedula' => $cedula,
        'conceptos_nomina' => $conceptos_nomina,
        'codigo_empleado' => $codigo_empleado,
    ];
//return($conceptos_nomina);
        return view('sireh.nomina.personal_civil.actuales-primas', compact('asignaciones', 'conceptos_nomina', 'dataemp'));
    } else {
        // La nómina no existe para el empleado con tipo_emp 'MIF' o 'ALI'
        // Realiza las operaciones que necesites aquí
        // Por ejemplo, muestra un mensaje de error o redirige a otra página
        session()->flash('error', 'El profesional con cedula n° '.$cedula.' no pertenece a la nomina del Personal Civil');
        return redirect()->back();
    }
}

 //asignacion de nueva prima
//Nueva prima
public function civilasignacionNuevaPrima(Request $request)
{
    $codigo_concepto = $request->input('codigo_concepto');
    $cedula = $request->input('cedula');
    $empleado_nombre = $request->input('nombre');
    $empleado_apellido = $request->input('apellido');
    $cedula = $request->input('cedula');
    $codigo_empleado = $request->input('codigo_empleado');
    $tipo = $request->input('tipo');

    $conceptos_nomina = ConceptosNomina::select('codigo_concepto', 'descripcion', 'tipo', 'tipo_empleado')
    ->where('tipo', 'A')
    ->whereIn('tipo_empleado', ['EMP'])
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
        ->where('Asignaciones.tipo_concepto', 'A')
        ->with('conceptoNomina')
        ->get();


        if (Asignaciones::where('codigo_empleado', $codigo_empleado)->where('id_concepto', $codigo_concepto)->exists()) {
           // return('existe');
           session()->flash('error', 'La prima ya se encuentra asignada al profesional');
            return view('sireh.nomina.personal_civil.actuales-primas',compact('asignaciones', 'conceptos_nomina', 'dataemp'));
        }

        $asignacion = new asignaciones();
        $asignacion->codigo_empleado = $codigo_empleado;
        $asignacion->id_concepto = $codigo_concepto;
        $asignacion->tipo_concepto = $tipo;
        $asignacion->save();

//return('no existe');
    return view('sireh.nomina.personal_civil.actuales-primas',compact('asignaciones', 'conceptos_nomina', 'dataemp'))->render();

}

                                    //SECCION DE DEDUCCIONES

//Ver deducciones
    public function deduccionesCivil(Request $request)
    {
        $data = ConceptosNomina::
            select('*',)
            ->where ('tipo', 'D')
            ->whereIn('tipo_empleado', ['EMP'])
            ->get();

        return view('sireh.nomina.personal_civil.deducciones', compact('data'));

    }
//EDIT PRIMA 2
public function civileditDeduccion (ConceptosNomina $registro){

    // $prima = ConceptosNomina::find($id);
     return view('sireh.nomina.personal_civil.deducciones-edit',compact('registro'));
 }

 //UPDATE PRIMAS
/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $registro
     * @return \Illuminate\Http\Response
     */
    public function updateDeducciones(Request $request, $registro)
    {

        $this->validate($request, [

            'descripcion' => 'required',
            'porcentaje' => 'required',
        ]);

        $universidades = ConceptosNomina::find($registro);
        $universidades->descripcion = $request->input('descripcion');
        $universidades->porcentaje = $request->input('porcentaje');
        $universidades->save();
            return redirect()->route('sireh.nomina.personalcivil.deducciones')
            ->with('success','Deducción actualizada con éxito');

    }

    //Delete deducciones
    public function deletededucciones($id)
    {
        ConceptosNomina::find($id)->delete();
        //\DB::table("cargos")->where('id',$id)->delete();
        return redirect()->route('sireh.nomina.deducciones');
    }

    //Delete deducciones asignadas
    public function deleteCivildeduccionesAsignadas(Request $request, $id)
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
 
     $conceptos_nomina = ConceptosNomina::select('codigo_concepto', 'descripcion', 'tipo', 'tipo_empleado')
        ->where('tipo', 'D')
        ->whereIn('tipo_empleado', ['EMP'])
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
     
     return view('sireh.nomina.personal_civil.actuales_deducciones',compact('asignaciones', 'conceptos_nomina', 'dataemp'));
 }

//Introducir cedula
public function nuevaDeduccion()
{
    return view('sireh.nomina.personal_civil.nueva-deduccion');
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
        $asignaciones = Asignaciones::
        select('Asignaciones.*', 'Empleados.codigo_empleado', 'Empleados.nombre1', 'Empleados.apellido1')
        ->join('Empleados', 'Asignaciones.codigo_empleado', '=', 'Empleados.codigo_empleado')
        ->where('Empleados.cedula', $cedula)
        ->where('Asignaciones.tipo_concepto', 'D')
        ->with('conceptoNomina')
        ->get();

        $empleado_nombre = $empleado->nombre1;
        $empleado_apellido = $empleado->apellido1;

        $conceptos_nomina = ConceptosNomina::select('codigo_concepto', 'descripcion', 'tipo', 'tipo_empleado')
        ->where('tipo', 'D')
        ->whereIn('tipo_empleado', ['EMP'])
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
      return view('sireh.nomina.personal_civil.actuales_deducciones',compact('asignaciones', 'conceptos_nomina', 'dataemp'));

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

        $conceptos_nomina = ConceptosNomina::
            select('codigo_concepto', 'descripcion', 'tipo')
            ->where('tipo', 'D')
            ->whereIn('tipo_empleado', ['EMP'])
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
        select('Asignaciones.*', 'Empleados.codigo_empleado', 'Empleados.nombre1', 'Empleados.apellido1')
        ->join('Empleados', 'Asignaciones.codigo_empleado', '=', 'Empleados.codigo_empleado')
        ->where('Empleados.cedula', $cedula)
        ->where('Asignaciones.tipo_concepto', 'D')
        ->with('conceptoNomina')
        ->get();

            if (Asignaciones::where('codigo_empleado', $codigo_empleado)->where('id_concepto', $codigo_concepto)->exists()) {
               // return('existe');
               session()->flash('error', 'La deduccion ya se encuentra asignada al profesional');
                return view('sireh.nomina.personal_civil.actuales_deducciones',compact('asignaciones', 'conceptos_nomina', 'dataemp'));
            }

            $asignacion = new asignaciones();
            $asignacion->codigo_empleado = $codigo_empleado;
            $asignacion->id_concepto = $codigo_concepto;
            $asignacion->tipo_concepto = $tipo;
            $asignacion->save();

    //return('no existe');
        return view('sireh.nomina.personal_civil.actuales_deducciones',compact('asignaciones', 'conceptos_nomina', 'dataemp'))->render();

    }
    

    //VISTA CAMBIO DE SUELDO

public function sueldosOBR()
{
    $salarios = Salarios::select('*')
                ->where('tipo_emp', 'OBR')
                ->orderBy('antiguedad', 'asc')
                ->get();
    
    $docentes = Salarios::select('*')
                ->where('tipo_emp', 'DOC')
                ->orderBy('antiguedad', 'asc')
                ->get();
                
    $empleados = Salarios::select('*')
                ->where('tipo_emp', 'EMP')
                ->orderBy('antiguedad', 'asc')
                ->get();
                
    // Puedes utilizar dd para depurar y verificar si los datos se obtienen correctamente
    // dd($salarios); 
    return view('sireh.nomina.personal_civil.sueldo', compact('salarios', 'docentes', 'empleados'));
}


//MODIFICACION DE SUELDO
public function editSueldosCivil(Request $request)
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
//return($inputs);
return redirect()->route('sireh.nomina.personal_civil.militar')
       ->with('success','Los PORCENTAJES de SUELDO han sido actualizados con éxito');
}

                               //SECCION EXCEL OBREROS

//PROCESS 

public function excelProcess()
{
// Crear una instancia de Spreadsheet
$spreadsheet = new Spreadsheet();

// Obtener la hoja activa del libro de Excel
$sheet = $spreadsheet->getActiveSheet();

// Definir los encabezados de las columnas
$sheet->setCellValue('A1', 'NRO');
$sheet->setCellValue('B1', 'CÉDULA');
$sheet->setCellValue('C1', 'NOMBRES Y APELLIDOS');
$sheet->setCellValue('D1', 'TIPO DE PUESTO');
$sheet->setCellValue('E1', 'GRADO');
$sheet->setCellValue('F1', 'PUESTO');
$sheet->setCellValue('G1', 'PROF. X DIRECTIVA');
$sheet->setCellValue('H1', 'FECHA DE INGRESO');
$sheet->setCellValue('I1', 'FECHA DE CALCULO DE ANTIGUEDAD');
$sheet->setCellValue('J1', 'ANTIGUEDAD AVIACIÓN');
$sheet->setCellValue('K1', 'ANTIGUEDAD ADMON. PÚBLICA');
$sheet->setCellValue('L1', 'TOTAL AÑOS');
$sheet->setCellValue('M1', 'SUELDO BÁSICO(0003)');
$sheet->setCellValue('N1', 'ANTIGUEDAD(0500)');
$sheet->setCellValue('O1', 'PRIMA PROF (0545,0544,0539)');
$sheet->setCellValue('P1', 'PRIMA PROF TSU (0106)');
$sheet->setCellValue('Q1', 'PRIMA HIJO (4000)');
$sheet->setCellValue('R1', 'PRIMA HIJO ESTUDIANDO (4015)');
$sheet->setCellValue('S1', 'PRIMA HIJO COND. ESPECIAL (4014)');
$sheet->setCellValue('T1', 'REMUNERACIÓN MENSUAL(0055)');
$sheet->setCellValue('U1', 'S.S.O(5001)');
$sheet->setCellValue('V1', 'S.P.F(5002)');
$sheet->setCellValue('W1', 'L.P.H(5003)');
$sheet->setCellValue('X1', 'FJU(5004)');
$sheet->setCellValue('Y1', 'AHORRO CAFUCAMIDE (5103)');


// Establecer el estilo para la primera fila
$style = $sheet->getStyle('A1:Y1');
$style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$style->getAlignment()->setWrapText(true);
// Ajustar el texto y centrarlo verticalmente
$style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$style->getAlignment()->setWrapText(true);

// Establecer el estilo para la primera fila
$style = $sheet->getStyle('A1:G1');
$style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

// Ajustar el ancho de las columnas B a E según el contenido
$columnIterator = $sheet->getColumnIterator('B', 'F');
foreach ($columnIterator as $column) {
    $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
}

// Establecer el estilo para todas las celdas
$style = $sheet->getStyle($sheet->calculateWorksheetDimension());

// Establecer el color de fondo y el color de texto
$fill = $style->getFill();
$fill->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('404040'); // Color de fondo azul
$style->getFont()->getColor()->setRGB(Color::COLOR_WHITE); // Color de texto blanco

// Establecer el color de las líneas de las celdas
$border = $style->getBorders();
$border->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);
$border->getAllBorders()->getColor()->setRGB(Color::COLOR_BLACK); // Color de líneas negras


                                      //INICIO DE LOS CALCULOS EXCEL OBREROS   
// Obtener los registros de la nómina
$nomina = Nomina::whereIn('tipo_emp', ['OBR'])
->whereIn('situacion', ['S', 'A'])
->take(15)
->get();

// Obtener el porcentaje del sueldo base
$sueldoBase = ConceptosNomina::where('codigo_concepto', '1')
->pluck('porcentaje')
->first();

// Iterar sobre los datos y escribirlos en las celdas correspondientes
$row = 2; // La primera fila ya está ocupada por los encabezados, así que comenzamos en la segunda fila
// Calcular los años de servicio y la antigüedad en el grado
// Obtener el total de registros

// Variable contador
$contador = 1;

foreach ($nomina as $item) {

// Asignar el número de registro al objeto $item
    $item->nro = $contador;

// Incrementar el contador
    $contador++;

//TRAER LOS NOMBRES DE LOS CARGOS
    $datacargo = Cargos::where('codigo_cargo', $item->codigo_cargo)->first();

    if ($datacargo) {
        $nombre_cargo = $datacargo->nombre_cargo;
        $grado = $datacargo->grado;
    } else {
        $nombre_cargo = 'No encontrado';
        $grado = 'No encontrado';
    }

// Asignar los valores al objeto $item
    $item->nombre_cargo = $nombre_cargo;
    $item->grado = $grado;


//CODIGO GRADO
// Asignar el valor de $antiguedad_admon_publica al objeto $item
    $codigo_grado='101';
    $item->codigo_grado = $codigo_grado;
    
//FECHA DEL DIA
//Fecha actual para el calculo de antiguedad
    $fechaActual = Carbon::now()->toDateString();
    $item->fechadeldia = $fechaActual;

//ANTIGUEDAD AVIACION
// Verificar si la columna 'fecha_ingreso' existe en $item
    if (isset($item->fecha_ingreso)) {
    // Obtener la fecha de ingreso y la fecha actual
        $fechaIngreso = Carbon::parse($item->fecha_ingreso);
        $fechaActual = Carbon::now();

    // Calcular la antigüedad en años
        $antiguedad = $fechaIngreso->diffInYears($fechaActual);
        $item->calculo_antiguedad = $antiguedad;
    } else {
        $item->calculo_antiguedad = null; // Opcional: manejar el caso cuando no hay fecha de ingreso
    }
    
//ANTIGUEDAD ADMON PUBLICA
// Buscar el registro en Asignaciones correspondiente al codigo_empleado
    $asignacion = Asignaciones::where('codigo_empleado', $item->codigo_empleado)->first();

// Verificar si se encontró un registro en Asignaciones
if ($asignacion && isset($asignacion->porcentaje)) {
    $antiguedad_admon_publica = $asignacion->porcentaje;

    // Asignar el valor de $antiguedad_admon_publica al objeto $item
    $item->antiguedad_admon_publica = $antiguedad_admon_publica;

    // Calcular el total de antigüedad
    $totalAntiguedad = $antiguedad_admon_publica + $antiguedad;

    // Asignar el valor del total de antigüedad al objeto $item
    $item->total_antiguedad = $totalAntiguedad;
} else {
    $antiguedad_admon_publica = 0;

    // Asignar el valor de $antiguedad_admon_publica al objeto $item
    $item->antiguedad_admon_publica = $antiguedad_admon_publica;

    // Calcular el total de antigüedad
    $totalAntiguedad = $antiguedad_admon_publica + $antiguedad;

    // Asignar el valor del total de antigüedad al objeto $item
    $item->total_antiguedad = $totalAntiguedad;
}

    // Agregar la prima por hijos y la prima de riesgo tipo A a cada obrero
    $cantidadHijos = $item->familiares_count;
    $primaPorHijos = $cantidadHijos * 25;
    $item->prima_por_hijos = $primaPorHijos;

//CALCULO DE SALARIO POR ANTIGUEDAD
//TRAER EL PORCENTAJE DE SALARIO
// Buscar el registro en Salarios correspondiente al código de grado
    $salario = Salarios::where('codigo_grado', $codigo_grado)->first();

// Verificar si se encontró un registro en Salarios
    if ($salario && isset($salario->porcentaje)) {
        $porcentajeSalario = $salario->porcentaje;

        // Asignar el valor de $porcentajeSalario al objeto $item
        $item->porcentaje_salario = $porcentajeSalario;
    } else {
        $porcentajeSalario = 0;
        // Asignar el valor de $porcentajeSalario al objeto $item
        $item->porcentaje_salario = $porcentajeSalario;
    }
    
//CALCULO DE MONTO POR ANTIGUEDAD
// Obtener el sueldo básico de la tabla ConceptosNomina
    $conceptoSueldoBasico = ConceptosNomina::where('codigo_concepto', '001')->first();

    // Verificar si se encontró un registro en ConceptosNomina
    if ($conceptoSueldoBasico && isset($conceptoSueldoBasico->porcentaje)) {
        $sueldoBasico = $conceptoSueldoBasico->porcentaje;

        // Calcular el sueldo del obrero
        $sueldoObrero = $sueldoBasico * $porcentajeSalario;

        // Asignar el valor del sueldo al objeto $item
        $item->sueldo_obrero = $sueldoObrero;
    } else {
        $sueldoObrero = 0;
        // Asignar el valor del sueldo al objeto $item
        $item->sueldo_obrero = $sueldoObrero;
    }
    
//CALCULO DEL MONTO DE LA ANTIGUEDAD
// Verificar si la antigüedad es mayor a 30 y ajustarla a 30
    $totalAntiguedad = min($totalAntiguedad, 30);
    $item->totalAntiguedad = $totalAntiguedad;

// Buscar el porcentaje de la prima por antigüedad en ConceptosNomina
    $conceptoAntiguedad = ConceptosNomina::where('antiguedad', $totalAntiguedad)
    ->where('tipo_empleado', 'OBR')
    ->first();

    if ($conceptoAntiguedad && isset($conceptoAntiguedad->porcentaje)) {
        $porcentajePrimaAntiguedad = $conceptoAntiguedad->porcentaje;
    } else {
        $porcentajePrimaAntiguedad = 0;
    }
    // Calcular la prima por antigüedad
    $primaAntiguedad = $sueldoObrero * $porcentajePrimaAntiguedad / 100;
    // Asignar valores a propiedades del objeto $item
    $item->prima_antiguedad = $primaAntiguedad;

//CALCULO DE PRIMA DE PROFECIONALIZACION 
    $conceptoPrima = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->whereIn('id_concepto', ['545', '544', '539'])
    ->first();

    if ($conceptoPrima) {
    $porcentajePrima = $conceptoPrima->porcentaje;
    // Calcular el monto de la prima de profesionalización
    $montoPrimaProfecionalizacion = $sueldoObrero * $porcentajePrima / 100;
    } else {
    // Si no se encuentra el registro, asignar el monto de prima como 0
    $montoPrimaProfecionalizacion = 0;
    }
    // Asignar el monto de la prima de profesionalización al objeto $item
    $item->monto_prima_profesionalizacion = $montoPrimaProfecionalizacion;

//CALCULO PRIMA PROF TSU
    $asignacionPrimaTsu = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
        ->where('id_concepto', '106')
        ->first();

    if ($asignacionPrimaTsu) {
        $porcentajePrimaTsu = $asignacionPrimaTsu->porcentaje;
        // Calcular el monto de la prima de prima_tsu
        $montoPrimaTsu = $sueldoObrero * $porcentajePrimaTsu / 100;
    } else {
        // Si no se encuentra el registro, asignar el monto de prima_tsu como 0
        $montoPrimaTsu = 0;
    }

// Asignar el monto de la prima de prima_tsu al objeto $item
    $item->monto_prima_tsu = $montoPrimaTsu;

//CALCULO PRIMA POR HIJOS
// Conteo de registros en el modelo Familiares
    $cantidadDeHijos = Familiares::where('codigo_empleado', $item->codigo_empleado)
    ->where('parentesco', 'H')
    ->count();

// Verificar si la cantidad de hijos es vacía y asignar 0 en ese caso
    if (empty($cantidadDeHijos)) {
    $cantidadDeHijos = 0;
    }

// Obtener el porcentaje del modelo ConceptosNomina
    $conceptoHijos = ConceptosNomina::where('codigo_concepto', '4000')
    ->where('tipo_empleado', 'OBR')
    ->first();

    if ($conceptoHijos) {
    $porcentajeHijos = $conceptoHijos->porcentaje;
    } else {
    $porcentajeHijos = 0;
    }

// Calcular el monto por cada hijo
    $montoPorHijo = $sueldoObrero * $porcentajeHijos / 100;
    
// Calcular  el monto total por hijos
    $resultadoHijos = $cantidadDeHijos * $montoPorHijo;

// Asignar el resultado final al objeto $item
    $item->resultado_hijos = $resultadoHijos;
    

//CALCULO PRIMA POR HIJOS ESPECIALES
// Conteo de registros en el modelo Familiares
    $cantidadDeHijosEspeciales = Familiares::where('codigo_empleado', $item->codigo_empleado)
        ->where('parentesco', 'H')
        ->where('especial', 'S')
        ->count();

// Verificar si la cantidad de hijos especiales es vacía y asignar 0 en ese caso
    if (empty($cantidadDeHijosEspeciales)) {
        $cantidadDeHijosEspeciales = 0;
    }

// Obtener el porcentaje del modelo ConceptosNomina
    $conceptoHijosEspeciales = ConceptosNomina::where('codigo_concepto', '4014')
        ->where('tipo_empleado', 'OBR')
        ->first();

    if ($conceptoHijosEspeciales) {
        $porcentajeHijosEspeciales = $conceptoHijosEspeciales->porcentaje;
    } else {
        $porcentajeHijosEspeciales = 0;
    }

// Calcular el monto por cada hijo
    $montoPorHijoEspecial = $sueldoObrero * $porcentajeHijosEspeciales / 100;
    
// Calcular  el monto total por hijos
    $resultadoHijosEspeciales = $cantidadDeHijosEspeciales * $montoPorHijoEspecial;

// Asignar el resultado final al objeto $item
    $item->resultado_hijos_especiales = $resultadoHijosEspeciales;

    
//CALCULO PRIMA POR HIJOS ESTUDIANDO
// Conteo de registros en el modelo Familiares
    $cantidadDeHijosEstudiando = Familiares::where('codigo_empleado', $item->codigo_empleado)
        ->where('parentesco', 'H')
        ->where('estudia', 'S')
        ->count();

// Verificar si la cantidad de hijos Estudiando es vacía y asignar 0 en ese caso
    if (empty($cantidadDeHijosEstudiando)) {
        $cantidadDeHijosEstudiando = 0;
    }

// Obtener el porcentaje del modelo ConceptosNomina
    $conceptoHijosEstudiando = ConceptosNomina::where('codigo_concepto', '4014')
        ->where('tipo_empleado', 'OBR')
        ->first();

    if ($conceptoHijosEstudiando) {
        $porcentajeHijosEstudiando = $conceptoHijosEstudiando->porcentaje;
    } else {
        $porcentajeHijosEstudiando = 0;
    }

// Calcular el monto por cada hijo
    $montoPorHijoEstudiando = $sueldoObrero * $porcentajeHijosEstudiando / 100;
    
// Calcular  el monto total por hijos
    $resultadoHijosEstudiando = $cantidadDeHijosEstudiando * $montoPorHijoEstudiando;

// Asignar el resultado final al objeto $item
    $item->resultado_hijos_Estudiando = $resultadoHijosEstudiando;

//Calculo del S.S.O
// Obtener el porcentaje del S.S.O del modelo ConceptosNomina
    $conceptoSSO = ConceptosNomina::where('codigo_concepto', '5001')
    ->where('tipo_empleado', 'OBR')
    ->first();

    if ($conceptoSSO) {
        $porcentajeSSO = $conceptoSSO->porcentaje;
    } else {
        $porcentajeSSO = 0;
    }
    
// Calcular el monto SSO
    $montoSSO = $sueldoObrero * $porcentajeSSO / 100;
// Asignar el resultado final al objeto $item
    $item->montoSSO = $montoSSO;

//Calculo del S.P.F
// Obtener el porcentaje del S.P.F del modelo ConceptosNomina
    $conceptoSPF = ConceptosNomina::where('codigo_concepto', '5002')
    ->where('tipo_empleado', 'OBR')
    ->first();

    if ($conceptoSPF) {
        $porcentajeSPF = $conceptoSPF->porcentaje;
    } else {
        $porcentajeSPF = 0;
    }

// Calcular el monto SPF
    $montoSPF = $sueldoObrero * $porcentajeSPF / 100;
// Asignar el resultado final al objeto $item
    $item->montoSPF = $montoSPF;

//Calculo del S.P.H
// Obtener el porcentaje del S.P.H del modelo ConceptosNomina
    $conceptoLPH = ConceptosNomina::where('codigo_concepto', '5003')
    ->where('tipo_empleado', 'OBR')
    ->first();

    if ($conceptoLPH) {
        $porcentajeLPH = $conceptoLPH->porcentaje;
    } else {
        $porcentajeLPH = 0;
    }

// Calcular el monto LPH
    $montoLPH = $sueldoObrero * $porcentajeLPH / 100;
// Asignar el resultado final al objeto $item
    $item->montoLPH = $montoLPH;

//Calculo del F.J.U
// Obtener el porcentaje del F.J.U del modelo ConceptosNomina
    $conceptoFJU = ConceptosNomina::where('codigo_concepto', '5004')
    ->where('tipo_empleado', 'OBR')
    ->first();

    if ($conceptoFJU) {
        $porcentajeFJU = $conceptoFJU->porcentaje;
    } else {
        $porcentajeFJU = 0;
    }

// Calcular el monto FJU
    $montoFJU = $sueldoObrero * $porcentajeFJU / 100;
// Asignar el resultado final al objeto $item
    $item->montoFJU = $montoFJU;

//Calculo del CAFUCAMIDE
// Obtener el porcentaje del CAFUCAMIDE del modelo ConceptosNomina
    $conceptoCafucamide = ConceptosNomina::where('codigo_concepto', '5004')
    ->where('tipo_empleado', 'OBR')
    ->first();
    if ($conceptoCafucamide) {
        $porcentajeCafucamide = $conceptoCafucamide->porcentaje;
    } else {
        $porcentajeCafucamide = 0;
    }
// Calcular el monto Cafucamide
    $montoCafucamide = $sueldoObrero * $porcentajeCafucamide / 100;
// Asignar el resultado final al objeto $item
    $item->montoCafucamide = $montoCafucamide;

//FILAS DEL EXCEL
    $sheet->setCellValue('A' . $row, $item->nro);
    $sheet->setCellValue('B' . $row, $item->cedula);
    $sheet->setCellValue('C' . $row, $item->nombre1 . ' ' . $item->nombre2 . ' ' . $item->apellido1 . ' ' . $item->apellido2);
    $sheet->setCellValue('D' . $row, 'por consultar');
    $sheet->setCellValue('E' . $row, $item->grado);
    $sheet->setCellValue('F' . $row, $item->nombre_cargo);
    $sheet->setCellValue('G' . $row, 'por consultar');
    $sheet->setCellValue('H' . $row, $item->fecha_ingreso);
    $sheet->setCellValue('I' . $row, $item->fechadeldia);
    $sheet->setCellValue('J' . $row, $item->calculo_antiguedad);
    $sheet->setCellValue('K' . $row, $item->antiguedad_admon_publica);
    $sheet->setCellValue('L' . $row, $item->total_antiguedad);
    $sheet->setCellValue('M' . $row, $item->sueldo_obrero);
    $sheet->setCellValue('N' . $row, $item->prima_antiguedad);
    $sheet->setCellValue('O' . $row, $item->monto_prima_profesionalizacion);
    $sheet->setCellValue('P' . $row, $item->monto_prima_tsu);
    $sheet->setCellValue('Q' . $row, $item->resultado_hijos);
    $sheet->setCellValue('R' . $row, $item->resultado_hijos_Estudiando);
    $sheet->setCellValue('S' . $row, $item->resultado_hijos_especiales);
    $sheet->setCellValue('T' . $row, 'por consultar');
    $sheet->setCellValue('U' . $row, $item->montoSSO);
    $sheet->setCellValue('V' . $row, $item->montoSPF);
    $sheet->setCellValue('W' . $row, $item->montoLPH);
    $sheet->setCellValue('X' . $row, $item->montoFJU);
    $sheet->setCellValue('Y' . $row, $item->montoCafucamide);
    

    $row++; // Incrementar el número de fila para el próximo registro

}
// Crear un objeto Writer para generar el archivo Excel
    $writer = new Xlsx($spreadsheet);

// Guardar el archivo en una ubicación temporal
    $tempFilePath = sys_get_temp_dir() . '/NOMINA_PERSONAL_OBRERO.xlsx';
    $writer->save($tempFilePath);

// Crear una respuesta con el archivo Excel
    $response = new BinaryFileResponse($tempFilePath);
    $response->setContentDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        'NOMINA_PERSONAL_OBRERO.xlsx'
    );




//dd($montoSSO);
// Devolver la respuesta
return $response;
return view('sireh.nomina.personal_civil.excel-vista', compact('nomina'));

}

                                            //SECCION EXCEL EMPLEADOS

//PROCESS 

public function excelProcessEmp()
{
// Crear una instancia de Spreadsheet
$spreadsheet = new Spreadsheet();

// Obtener la hoja activa del libro de Excel
$sheet = $spreadsheet->getActiveSheet();

// Definir los encabezados de las columnas
$sheet->setCellValue('A1', 'NRO');
$sheet->setCellValue('B1', 'CÉDULA');
$sheet->setCellValue('C1', 'NOMBRES Y APELLIDOS');
$sheet->setCellValue('D1', 'TIPO DE PUESTO');
$sheet->setCellValue('E1', 'GRADO');
$sheet->setCellValue('F1', 'PUESTO');
$sheet->setCellValue('G1', 'PROF. X DIRECTIVA');
$sheet->setCellValue('H1', 'FECHA DE INGRESO');
$sheet->setCellValue('I1', 'FECHA DE CALCULO DE ANTIGUEDAD');
$sheet->setCellValue('J1', 'ANTIGUEDAD AVIACIÓN');
$sheet->setCellValue('K1', 'ANTIGUEDAD ADMON. PÚBLICA');
$sheet->setCellValue('L1', 'TOTAL AÑOS');
$sheet->setCellValue('M1', 'SUELDO BÁSICO(0003)');
$sheet->setCellValue('N1', 'ANTIGUEDAD(0500)');
$sheet->setCellValue('O1', 'PRIMA PROF (0545,0544,0539)');
$sheet->setCellValue('P1', 'PRIMA PROF TSU (0106)');
$sheet->setCellValue('Q1', 'PRIMA HIJO (4000)');
$sheet->setCellValue('R1', 'PRIMA HIJO ESTUDIANDO (4015)');
$sheet->setCellValue('S1', 'PRIMA HIJO COND. ESPECIAL (4014)');
$sheet->setCellValue('T1', 'REMUNERACIÓN MENSUAL(0055)');
$sheet->setCellValue('U1', 'S.S.O(5001)');
$sheet->setCellValue('V1', 'S.P.F(5002)');
$sheet->setCellValue('W1', 'L.P.H(5003)');
$sheet->setCellValue('X1', 'FJU(5004)');
$sheet->setCellValue('Y1', 'AHORRO CAFUCAMIDE (5103)');


// Establecer el estilo para la primera fila
$style = $sheet->getStyle('A1:Y1');
$style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$style->getAlignment()->setWrapText(true);
// Ajustar el texto y centrarlo verticalmente
$style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$style->getAlignment()->setWrapText(true);

// Establecer el estilo para la primera fila
$style = $sheet->getStyle('A1:G1');
$style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

// Ajustar el ancho de las columnas B a E según el contenido
$columnIterator = $sheet->getColumnIterator('B', 'F');
foreach ($columnIterator as $column) {
    $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
}

// Establecer el estilo para todas las celdas
$style = $sheet->getStyle($sheet->calculateWorksheetDimension());

// Establecer el color de fondo y el color de texto
$fill = $style->getFill();
$fill->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('404040'); // Color de fondo azul
$style->getFont()->getColor()->setRGB(Color::COLOR_WHITE); // Color de texto blanco

// Establecer el color de las líneas de las celdas
$border = $style->getBorders();
$border->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);
$border->getAllBorders()->getColor()->setRGB(Color::COLOR_BLACK); // Color de líneas negras


                                      //INICIO DE LOS CALCULOS EXCEL EMPLEADO   
// Obtener los registros de la nómina
$nomina = Nomina::whereIn('tipo_emp', ['EMP'])
->whereIn('situacion', ['S', 'A'])
->take(15)
->get();

// Obtener el porcentaje del sueldo base
$sueldoBase = ConceptosNomina::where('codigo_concepto', '1')
->pluck('porcentaje')
->first();

// Iterar sobre los datos y escribirlos en las celdas correspondientes
$row = 2; // La primera fila ya está ocupada por los encabezados, así que comenzamos en la segunda fila
// Calcular los años de servicio y la antigüedad en el grado
// Obtener el total de registros

// Variable contador
$contador = 1;

foreach ($nomina as $item) {

// Asignar el número de registro al objeto $item
    $item->nro = $contador;

// Incrementar el contador
    $contador++;

//TRAER LOS NOMBRES DE LOS CARGOS
    $datacargo = Cargos::where('codigo_cargo', $item->codigo_cargo)->first();

    if ($datacargo) {
        $nombre_cargo = $datacargo->nombre_cargo;
        $grado = $datacargo->grado;
    } else {
        $nombre_cargo = 'No encontrado';
        $grado = 'No encontrado';
    }

// Asignar los valores al objeto $item
    $item->nombre_cargo = $nombre_cargo;
    $item->grado = $grado;


//CODIGO GRADO
// Asignar el valor de $antiguedad_admon_publica al objeto $item
    $codigo_grado='101';
    $item->codigo_grado = $codigo_grado;
    
//FECHA DEL DIA
//Fecha actual para el calculo de antiguedad
    $fechaActual = Carbon::now()->toDateString();
    $item->fechadeldia = $fechaActual;

//ANTIGUEDAD AVIACION
// Verificar si la columna 'fecha_ingreso' existe en $item
    if (isset($item->fecha_ingreso)) {
    // Obtener la fecha de ingreso y la fecha actual
        $fechaIngreso = Carbon::parse($item->fecha_ingreso);
        $fechaActual = Carbon::now();

    // Calcular la antigüedad en años
        $antiguedad = $fechaIngreso->diffInYears($fechaActual);
        $item->calculo_antiguedad = $antiguedad;
    } else {
        $item->calculo_antiguedad = null; // Opcional: manejar el caso cuando no hay fecha de ingreso
    }
    
//ANTIGUEDAD ADMON PUBLICA
// Buscar el registro en Asignaciones correspondiente al codigo_empleado
    $asignacion = Asignaciones::where('codigo_empleado', $item->codigo_empleado)->first();

// Verificar si se encontró un registro en Asignaciones
if ($asignacion && isset($asignacion->porcentaje)) {
    $antiguedad_admon_publica = $asignacion->porcentaje;

    // Asignar el valor de $antiguedad_admon_publica al objeto $item
    $item->antiguedad_admon_publica = $antiguedad_admon_publica;

    // Calcular el total de antigüedad
    $totalAntiguedad = $antiguedad_admon_publica + $antiguedad;

    // Asignar el valor del total de antigüedad al objeto $item
    $item->total_antiguedad = $totalAntiguedad;
} else {
    $antiguedad_admon_publica = 0;

    // Asignar el valor de $antiguedad_admon_publica al objeto $item
    $item->antiguedad_admon_publica = $antiguedad_admon_publica;

    // Calcular el total de antigüedad
    $totalAntiguedad = $antiguedad_admon_publica + $antiguedad;

    // Asignar el valor del total de antigüedad al objeto $item
    $item->total_antiguedad = $totalAntiguedad;
}

    // Agregar la prima por hijos y la prima de riesgo tipo A a cada obrero
    $cantidadHijos = $item->familiares_count;
    $primaPorHijos = $cantidadHijos * 25;
    $item->prima_por_hijos = $primaPorHijos;

//CALCULO DE SALARIO POR ANTIGUEDAD
//TRAER EL PORCENTAJE DE SALARIO
// Buscar el registro en Salarios correspondiente al código de grado
    $salario = Salarios::where('codigo_grado', $codigo_grado)->first();

// Verificar si se encontró un registro en Salarios
    if ($salario && isset($salario->porcentaje)) {
        $porcentajeSalario = $salario->porcentaje;

        // Asignar el valor de $porcentajeSalario al objeto $item
        $item->porcentaje_salario = $porcentajeSalario;
    } else {
        $porcentajeSalario = 0;
        // Asignar el valor de $porcentajeSalario al objeto $item
        $item->porcentaje_salario = $porcentajeSalario;
    }
    
//CALCULO DE MONTO POR ANTIGUEDAD
// Obtener el sueldo básico de la tabla ConceptosNomina
    $conceptoSueldoBasico = ConceptosNomina::where('codigo_concepto', '001')->first();

    // Verificar si se encontró un registro en ConceptosNomina
    if ($conceptoSueldoBasico && isset($conceptoSueldoBasico->porcentaje)) {
        $sueldoBasico = $conceptoSueldoBasico->porcentaje;

        // Calcular el sueldo del obrero
        $sueldoObrero = $sueldoBasico * $porcentajeSalario;

        // Asignar el valor del sueldo al objeto $item
        $item->sueldo_obrero = $sueldoObrero;
    } else {
        $sueldoObrero = 0;
        // Asignar el valor del sueldo al objeto $item
        $item->sueldo_obrero = $sueldoObrero;
    }
    
//CALCULO DEL MONTO DE LA ANTIGUEDAD
// Verificar si la antigüedad es mayor a 30 y ajustarla a 30
    $totalAntiguedad = min($totalAntiguedad, 30);
    $item->totalAntiguedad = $totalAntiguedad;

// Buscar el porcentaje de la prima por antigüedad en ConceptosNomina
    $conceptoAntiguedad = ConceptosNomina::where('antiguedad', $totalAntiguedad)
    ->where('tipo_empleado', 'EMP')
    ->first();

    if ($conceptoAntiguedad && isset($conceptoAntiguedad->porcentaje)) {
        $porcentajePrimaAntiguedad = $conceptoAntiguedad->porcentaje;
    } else {
        $porcentajePrimaAntiguedad = 0;
    }
    // Calcular la prima por antigüedad
    $primaAntiguedad = $sueldoObrero * $porcentajePrimaAntiguedad / 100;
    // Asignar valores a propiedades del objeto $item
    $item->prima_antiguedad = $primaAntiguedad;

//CALCULO DE PRIMA DE PROFECIONALIZACION 
    $conceptoPrima = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->whereIn('id_concepto', ['545', '544', '539'])
    ->first();

    if ($conceptoPrima) {
    $porcentajePrima = $conceptoPrima->porcentaje;
    // Calcular el monto de la prima de profesionalización
    $montoPrimaProfecionalizacion = $sueldoObrero * $porcentajePrima / 100;
    } else {
    // Si no se encuentra el registro, asignar el monto de prima como 0
    $montoPrimaProfecionalizacion = 0;
    }
    // Asignar el monto de la prima de profesionalización al objeto $item
    $item->monto_prima_profesionalizacion = $montoPrimaProfecionalizacion;

//CALCULO PRIMA PROF TSU
    $asignacionPrimaTsu = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
        ->where('id_concepto', '106')
        ->first();

    if ($asignacionPrimaTsu) {
        $porcentajePrimaTsu = $asignacionPrimaTsu->porcentaje;
        // Calcular el monto de la prima de prima_tsu
        $montoPrimaTsu = $sueldoObrero * $porcentajePrimaTsu / 100;
    } else {
        // Si no se encuentra el registro, asignar el monto de prima_tsu como 0
        $montoPrimaTsu = 0;
    }

// Asignar el monto de la prima de prima_tsu al objeto $item
    $item->monto_prima_tsu = $montoPrimaTsu;

//CALCULO PRIMA POR HIJOS
// Conteo de registros en el modelo Familiares
    $cantidadDeHijos = Familiares::where('codigo_empleado', $item->codigo_empleado)
    ->where('parentesco', 'H')
    ->count();

// Verificar si la cantidad de hijos es vacía y asignar 0 en ese caso
    if (empty($cantidadDeHijos)) {
    $cantidadDeHijos = 0;
    }

// Obtener el porcentaje del modelo ConceptosNomina
    $conceptoHijos = ConceptosNomina::where('codigo_concepto', '4000')
    ->where('tipo_empleado', 'EMP')
    ->first();

    if ($conceptoHijos) {
    $porcentajeHijos = $conceptoHijos->porcentaje;
    } else {
    $porcentajeHijos = 0;
    }

// Calcular el monto por cada hijo
    $montoPorHijo = $sueldoObrero * $porcentajeHijos / 100;
    
// Calcular  el monto total por hijos
    $resultadoHijos = $cantidadDeHijos * $montoPorHijo;

// Asignar el resultado final al objeto $item
    $item->resultado_hijos = $resultadoHijos;
    

//CALCULO PRIMA POR HIJOS ESPECIALES
// Conteo de registros en el modelo Familiares
    $cantidadDeHijosEspeciales = Familiares::where('codigo_empleado', $item->codigo_empleado)
        ->where('parentesco', 'H')
        ->where('especial', 'S')
        ->count();

// Verificar si la cantidad de hijos especiales es vacía y asignar 0 en ese caso
    if (empty($cantidadDeHijosEspeciales)) {
        $cantidadDeHijosEspeciales = 0;
    }

// Obtener el porcentaje del modelo ConceptosNomina
    $conceptoHijosEspeciales = ConceptosNomina::where('codigo_concepto', '4014')
        ->where('tipo_empleado', 'EMP')
        ->first();

    if ($conceptoHijosEspeciales) {
        $porcentajeHijosEspeciales = $conceptoHijosEspeciales->porcentaje;
    } else {
        $porcentajeHijosEspeciales = 0;
    }

// Calcular el monto por cada hijo
    $montoPorHijoEspecial = $sueldoObrero * $porcentajeHijosEspeciales / 100;
    
// Calcular  el monto total por hijos
    $resultadoHijosEspeciales = $cantidadDeHijosEspeciales * $montoPorHijoEspecial;

// Asignar el resultado final al objeto $item
    $item->resultado_hijos_especiales = $resultadoHijosEspeciales;

    
//CALCULO PRIMA POR HIJOS ESTUDIANDO
// Conteo de registros en el modelo Familiares
    $cantidadDeHijosEstudiando = Familiares::where('codigo_empleado', $item->codigo_empleado)
        ->where('parentesco', 'H')
        ->where('estudia', 'S')
        ->count();

// Verificar si la cantidad de hijos Estudiando es vacía y asignar 0 en ese caso
    if (empty($cantidadDeHijosEstudiando)) {
        $cantidadDeHijosEstudiando = 0;
    }

// Obtener el porcentaje del modelo ConceptosNomina
    $conceptoHijosEstudiando = ConceptosNomina::where('codigo_concepto', '4014')
        ->where('tipo_empleado', 'EMP')
        ->first();

    if ($conceptoHijosEstudiando) {
        $porcentajeHijosEstudiando = $conceptoHijosEstudiando->porcentaje;
    } else {
        $porcentajeHijosEstudiando = 0;
    }

// Calcular el monto por cada hijo
    $montoPorHijoEstudiando = $sueldoObrero * $porcentajeHijosEstudiando / 100;
    
// Calcular  el monto total por hijos
    $resultadoHijosEstudiando = $cantidadDeHijosEstudiando * $montoPorHijoEstudiando;

// Asignar el resultado final al objeto $item
    $item->resultado_hijos_Estudiando = $resultadoHijosEstudiando;

//Calculo del S.S.O
// Obtener el porcentaje del S.S.O del modelo ConceptosNomina
    $conceptoSSO = ConceptosNomina::where('codigo_concepto', '5001')
    ->where('tipo_empleado', 'EMP')
    ->first();

    if ($conceptoSSO) {
        $porcentajeSSO = $conceptoSSO->porcentaje;
    } else {
        $porcentajeSSO = 0;
    }
    
// Calcular el monto SSO
    $montoSSO = $sueldoObrero * $porcentajeSSO / 100;
// Asignar el resultado final al objeto $item
    $item->montoSSO = $montoSSO;

//Calculo del S.P.F
// Obtener el porcentaje del S.P.F del modelo ConceptosNomina
    $conceptoSPF = ConceptosNomina::where('codigo_concepto', '5002')
    ->where('tipo_empleado', 'EMP')
    ->first();

    if ($conceptoSPF) {
        $porcentajeSPF = $conceptoSPF->porcentaje;
    } else {
        $porcentajeSPF = 0;
    }

// Calcular el monto SPF
    $montoSPF = $sueldoObrero * $porcentajeSPF / 100;
// Asignar el resultado final al objeto $item
    $item->montoSPF = $montoSPF;

//Calculo del S.P.H
// Obtener el porcentaje del S.P.H del modelo ConceptosNomina
    $conceptoLPH = ConceptosNomina::where('codigo_concepto', '5003')
    ->where('tipo_empleado', 'EMP')
    ->first();

    if ($conceptoLPH) {
        $porcentajeLPH = $conceptoLPH->porcentaje;
    } else {
        $porcentajeLPH = 0;
    }

// Calcular el monto LPH
    $montoLPH = $sueldoObrero * $porcentajeLPH / 100;
// Asignar el resultado final al objeto $item
    $item->montoLPH = $montoLPH;

//Calculo del F.J.U
// Obtener el porcentaje del F.J.U del modelo ConceptosNomina
    $conceptoFJU = ConceptosNomina::where('codigo_concepto', '5004')
    ->where('tipo_empleado', 'EMP')
    ->first();

    if ($conceptoFJU) {
        $porcentajeFJU = $conceptoFJU->porcentaje;
    } else {
        $porcentajeFJU = 0;
    }

// Calcular el monto FJU
    $montoFJU = $sueldoObrero * $porcentajeFJU / 100;
// Asignar el resultado final al objeto $item
    $item->montoFJU = $montoFJU;

//Calculo del CAFUCAMIDE
// Obtener el porcentaje del CAFUCAMIDE del modelo ConceptosNomina
    $conceptoCafucamide = ConceptosNomina::where('codigo_concepto', '5004')
    ->where('tipo_empleado', 'EMP')
    ->first();
    if ($conceptoCafucamide) {
        $porcentajeCafucamide = $conceptoCafucamide->porcentaje;
    } else {
        $porcentajeCafucamide = 0;
    }
// Calcular el monto Cafucamide
    $montoCafucamide = $sueldoObrero * $porcentajeCafucamide / 100;
// Asignar el resultado final al objeto $item
    $item->montoCafucamide = $montoCafucamide;

//FILAS DEL EXCEL
    $sheet->setCellValue('A' . $row, $item->nro);
    $sheet->setCellValue('B' . $row, $item->cedula);
    $sheet->setCellValue('C' . $row, $item->nombre1 . ' ' . $item->nombre2 . ' ' . $item->apellido1 . ' ' . $item->apellido2);
    $sheet->setCellValue('D' . $row, 'por consultar');
    $sheet->setCellValue('E' . $row, $item->grado);
    $sheet->setCellValue('F' . $row, $item->nombre_cargo);
    $sheet->setCellValue('G' . $row, 'por consultar');
    $sheet->setCellValue('H' . $row, $item->fecha_ingreso);
    $sheet->setCellValue('I' . $row, $item->fechadeldia);
    $sheet->setCellValue('J' . $row, $item->calculo_antiguedad);
    $sheet->setCellValue('K' . $row, $item->antiguedad_admon_publica);
    $sheet->setCellValue('L' . $row, $item->total_antiguedad);
    $sheet->setCellValue('M' . $row, $item->sueldo_obrero);
    $sheet->setCellValue('N' . $row, $item->prima_antiguedad);
    $sheet->setCellValue('O' . $row, $item->monto_prima_profesionalizacion);
    $sheet->setCellValue('P' . $row, $item->monto_prima_tsu);
    $sheet->setCellValue('Q' . $row, $item->resultado_hijos);
    $sheet->setCellValue('R' . $row, $item->resultado_hijos_Estudiando);
    $sheet->setCellValue('S' . $row, $item->resultado_hijos_especiales);
    $sheet->setCellValue('T' . $row, 'por consultar');
    $sheet->setCellValue('U' . $row, $item->montoSSO);
    $sheet->setCellValue('V' . $row, $item->montoSPF);
    $sheet->setCellValue('W' . $row, $item->montoLPH);
    $sheet->setCellValue('X' . $row, $item->montoFJU);
    $sheet->setCellValue('Y' . $row, $item->montoCafucamide);
    

    $row++; // Incrementar el número de fila para el próximo registro

}
// Crear un objeto Writer para generar el archivo Excel
    $writer = new Xlsx($spreadsheet);

// Guardar el archivo en una ubicación temporal
    $tempFilePath = sys_get_temp_dir() . '/NOMINA_PERSONAL_EMPLEADOS.xlsx';
    $writer->save($tempFilePath);

// Crear una respuesta con el archivo Excel
    $response = new BinaryFileResponse($tempFilePath);
    $response->setContentDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        'NOMINA_PERSONAL_EMPLEADOS.xlsx'
    );


//dd($montoSSO);
// Devolver la respuesta
return $response;
return view('sireh.nomina.personal_civil.excel-vista', compact('nomina'));



}

                                            //SECCION EXCEL DOCENTES

//PROCESS 

public function excelProcessDoc()
{
// Crear una instancia de Spreadsheet
$spreadsheet = new Spreadsheet();

// Obtener la hoja activa del libro de Excel
$sheet = $spreadsheet->getActiveSheet();

// Definir los encabezados de las columnas
$sheet->setCellValue('A1', 'NRO');
$sheet->setCellValue('B1', 'CÉDULA');
$sheet->setCellValue('C1', 'NOMBRES Y APELLIDOS');
$sheet->setCellValue('D1', 'TIPO DE PUESTO');
$sheet->setCellValue('E1', 'GRADO');
$sheet->setCellValue('F1', 'PUESTO');
$sheet->setCellValue('G1', 'PROF. X DIRECTIVA');
$sheet->setCellValue('H1', 'FECHA DE INGRESO');
$sheet->setCellValue('I1', 'FECHA DE CALCULO DE ANTIGUEDAD');
$sheet->setCellValue('J1', 'ANTIGUEDAD AVIACIÓN');
$sheet->setCellValue('K1', 'ANTIGUEDAD ADMON. PÚBLICA');
$sheet->setCellValue('L1', 'TOTAL AÑOS');
$sheet->setCellValue('M1', 'SUELDO BÁSICO(0003)');
$sheet->setCellValue('N1', 'ANTIGUEDAD(0500)');
$sheet->setCellValue('O1', 'PRIMA PROF (0545,0544,0539)');
$sheet->setCellValue('P1', 'PRIMA PROF TSU (0106)');
$sheet->setCellValue('Q1', 'PRIMA HIJO (4000)');
$sheet->setCellValue('R1', 'PRIMA HIJO ESTUDIANDO (4015)');
$sheet->setCellValue('S1', 'PRIMA HIJO COND. ESPECIAL (4014)');
$sheet->setCellValue('T1', 'REMUNERACIÓN MENSUAL(0055)');
$sheet->setCellValue('U1', 'S.S.O(5001)');
$sheet->setCellValue('V1', 'S.P.F(5002)');
$sheet->setCellValue('W1', 'L.P.H(5003)');
$sheet->setCellValue('X1', 'FJU(5004)');
$sheet->setCellValue('Y1', 'AHORRO CAFUCAMIDE (5103)');


// Establecer el estilo para la primera fila
$style = $sheet->getStyle('A1:Y1');
$style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$style->getAlignment()->setWrapText(true);
// Ajustar el texto y centrarlo verticalmente
$style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$style->getAlignment()->setWrapText(true);

// Establecer el estilo para la primera fila
$style = $sheet->getStyle('A1:G1');
$style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

// Ajustar el ancho de las columnas B a E según el contenido
$columnIterator = $sheet->getColumnIterator('B', 'F');
foreach ($columnIterator as $column) {
    $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
}

// Establecer el estilo para todas las celdas
$style = $sheet->getStyle($sheet->calculateWorksheetDimension());

// Establecer el color de fondo y el color de texto
$fill = $style->getFill();
$fill->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('404040'); // Color de fondo azul
$style->getFont()->getColor()->setRGB(Color::COLOR_WHITE); // Color de texto blanco

// Establecer el color de las líneas de las celdas
$border = $style->getBorders();
$border->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);
$border->getAllBorders()->getColor()->setRGB(Color::COLOR_BLACK); // Color de líneas negras


                                      //INICIO DE LOS CALCULOS EXCEL DOCENTES   
// Obtener los registros de la nómina
$nomina = Nomina::whereIn('tipo_emp', ['DOC'])
->whereIn('situacion', ['S', 'A'])
->take(15)
->get();

// Obtener el porcentaje del sueldo base
$sueldoBase = ConceptosNomina::where('codigo_concepto', '1')
->pluck('porcentaje')
->first();

// Iterar sobre los datos y escribirlos en las celdas correspondientes
$row = 2; // La primera fila ya está ocupada por los encabezados, así que comenzamos en la segunda fila
// Calcular los años de servicio y la antigüedad en el grado
// Obtener el total de registros

// Variable contador
$contador = 1;

foreach ($nomina as $item) {

// Asignar el número de registro al objeto $item
    $item->nro = $contador;

// Incrementar el contador
    $contador++;

//TRAER LOS NOMBRES DE LOS CARGOS
    $datacargo = Cargos::where('codigo_cargo', $item->codigo_cargo)->first();

    if ($datacargo) {
        $nombre_cargo = $datacargo->nombre_cargo;
        $grado = $datacargo->grado;
    } else {
        $nombre_cargo = 'No encontrado';
        $grado = 'No encontrado';
    }

// Asignar los valores al objeto $item
    $item->nombre_cargo = $nombre_cargo;
    $item->grado = $grado;


//CODIGO GRADO
// Asignar el valor de $antiguedad_admon_publica al objeto $item
    $codigo_grado='101';
    $item->codigo_grado = $codigo_grado;
    
//FECHA DEL DIA
//Fecha actual para el calculo de antiguedad
    $fechaActual = Carbon::now()->toDateString();
    $item->fechadeldia = $fechaActual;

//ANTIGUEDAD AVIACION
// Verificar si la columna 'fecha_ingreso' existe en $item
    if (isset($item->fecha_ingreso)) {
    // Obtener la fecha de ingreso y la fecha actual
        $fechaIngreso = Carbon::parse($item->fecha_ingreso);
        $fechaActual = Carbon::now();

    // Calcular la antigüedad en años
        $antiguedad = $fechaIngreso->diffInYears($fechaActual);
        $item->calculo_antiguedad = $antiguedad;
    } else {
        $item->calculo_antiguedad = null; // Opcional: manejar el caso cuando no hay fecha de ingreso
    }
    
//ANTIGUEDAD ADMON PUBLICA
// Buscar el registro en Asignaciones correspondiente al codigo_empleado
    $asignacion = Asignaciones::where('codigo_empleado', $item->codigo_empleado)->first();

// Verificar si se encontró un registro en Asignaciones
if ($asignacion && isset($asignacion->porcentaje)) {
    $antiguedad_admon_publica = $asignacion->porcentaje;

    // Asignar el valor de $antiguedad_admon_publica al objeto $item
    $item->antiguedad_admon_publica = $antiguedad_admon_publica;

    // Calcular el total de antigüedad
    $totalAntiguedad = $antiguedad_admon_publica + $antiguedad;

    // Asignar el valor del total de antigüedad al objeto $item
    $item->total_antiguedad = $totalAntiguedad;
} else {
    $antiguedad_admon_publica = 0;

    // Asignar el valor de $antiguedad_admon_publica al objeto $item
    $item->antiguedad_admon_publica = $antiguedad_admon_publica;

    // Calcular el total de antigüedad
    $totalAntiguedad = $antiguedad_admon_publica + $antiguedad;

    // Asignar el valor del total de antigüedad al objeto $item
    $item->total_antiguedad = $totalAntiguedad;
}

    // Agregar la prima por hijos y la prima de riesgo tipo A a cada obrero
    $cantidadHijos = $item->familiares_count;
    $primaPorHijos = $cantidadHijos * 25;
    $item->prima_por_hijos = $primaPorHijos;

//CALCULO DE SALARIO POR ANTIGUEDAD
//TRAER EL PORCENTAJE DE SALARIO
// Buscar el registro en Salarios correspondiente al código de grado
    $salario = Salarios::where('codigo_grado', $codigo_grado)->first();

// Verificar si se encontró un registro en Salarios
    if ($salario && isset($salario->porcentaje)) {
        $porcentajeSalario = $salario->porcentaje;

        // Asignar el valor de $porcentajeSalario al objeto $item
        $item->porcentaje_salario = $porcentajeSalario;
    } else {
        $porcentajeSalario = 0;
        // Asignar el valor de $porcentajeSalario al objeto $item
        $item->porcentaje_salario = $porcentajeSalario;
    }
    
//CALCULO DE MONTO POR ANTIGUEDAD
// Obtener el sueldo básico de la tabla ConceptosNomina
    $conceptoSueldoBasico = ConceptosNomina::where('codigo_concepto', '001')->first();

    // Verificar si se encontró un registro en ConceptosNomina
    if ($conceptoSueldoBasico && isset($conceptoSueldoBasico->porcentaje)) {
        $sueldoBasico = $conceptoSueldoBasico->porcentaje;

        // Calcular el sueldo del obrero
        $sueldoObrero = $sueldoBasico * $porcentajeSalario;

        // Asignar el valor del sueldo al objeto $item
        $item->sueldo_obrero = $sueldoObrero;
    } else {
        $sueldoObrero = 0;
        // Asignar el valor del sueldo al objeto $item
        $item->sueldo_obrero = $sueldoObrero;
    }
    
//CALCULO DEL MONTO DE LA ANTIGUEDAD
// Verificar si la antigüedad es mayor a 30 y ajustarla a 30
    $totalAntiguedad = min($totalAntiguedad, 30);
    $item->totalAntiguedad = $totalAntiguedad;

// Buscar el porcentaje de la prima por antigüedad en ConceptosNomina
    $conceptoAntiguedad = ConceptosNomina::where('antiguedad', $totalAntiguedad)
    ->where('tipo_empleado', 'DOC')
    ->first();

    if ($conceptoAntiguedad && isset($conceptoAntiguedad->porcentaje)) {
        $porcentajePrimaAntiguedad = $conceptoAntiguedad->porcentaje;
    } else {
        $porcentajePrimaAntiguedad = 0;
    }
    // Calcular la prima por antigüedad
    $primaAntiguedad = $sueldoObrero * $porcentajePrimaAntiguedad / 100;
    // Asignar valores a propiedades del objeto $item
    $item->prima_antiguedad = $primaAntiguedad;

//CALCULO DE PRIMA DE PROFECIONALIZACION 
    $conceptoPrima = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
    ->whereIn('id_concepto', ['545', '544', '539'])
    ->first();

    if ($conceptoPrima) {
    $porcentajePrima = $conceptoPrima->porcentaje;
    // Calcular el monto de la prima de profesionalización
    $montoPrimaProfecionalizacion = $sueldoObrero * $porcentajePrima / 100;
    } else {
    // Si no se encuentra el registro, asignar el monto de prima como 0
    $montoPrimaProfecionalizacion = 0;
    }
    // Asignar el monto de la prima de profesionalización al objeto $item
    $item->monto_prima_profesionalizacion = $montoPrimaProfecionalizacion;

//CALCULO PRIMA PROF TSU
    $asignacionPrimaTsu = Asignaciones::where('codigo_empleado', $item->codigo_empleado)
        ->where('id_concepto', '106')
        ->first();

    if ($asignacionPrimaTsu) {
        $porcentajePrimaTsu = $asignacionPrimaTsu->porcentaje;
        // Calcular el monto de la prima de prima_tsu
        $montoPrimaTsu = $sueldoObrero * $porcentajePrimaTsu / 100;
    } else {
        // Si no se encuentra el registro, asignar el monto de prima_tsu como 0
        $montoPrimaTsu = 0;
    }

// Asignar el monto de la prima de prima_tsu al objeto $item
    $item->monto_prima_tsu = $montoPrimaTsu;

//CALCULO PRIMA POR HIJOS
// Conteo de registros en el modelo Familiares
    $cantidadDeHijos = Familiares::where('codigo_empleado', $item->codigo_empleado)
    ->where('parentesco', 'H')
    ->count();

// Verificar si la cantidad de hijos es vacía y asignar 0 en ese caso
    if (empty($cantidadDeHijos)) {
    $cantidadDeHijos = 0;
    }

// Obtener el porcentaje del modelo ConceptosNomina
    $conceptoHijos = ConceptosNomina::where('codigo_concepto', '4000')
    ->where('tipo_empleado', 'DOC')
    ->first();

    if ($conceptoHijos) {
    $porcentajeHijos = $conceptoHijos->porcentaje;
    } else {
    $porcentajeHijos = 0;
    }

// Calcular el monto por cada hijo
    $montoPorHijo = $sueldoObrero * $porcentajeHijos / 100;
    
// Calcular  el monto total por hijos
    $resultadoHijos = $cantidadDeHijos * $montoPorHijo;

// Asignar el resultado final al objeto $item
    $item->resultado_hijos = $resultadoHijos;
    

//CALCULO PRIMA POR HIJOS ESPECIALES
// Conteo de registros en el modelo Familiares
    $cantidadDeHijosEspeciales = Familiares::where('codigo_empleado', $item->codigo_empleado)
        ->where('parentesco', 'H')
        ->where('especial', 'S')
        ->count();

// Verificar si la cantidad de hijos especiales es vacía y asignar 0 en ese caso
    if (empty($cantidadDeHijosEspeciales)) {
        $cantidadDeHijosEspeciales = 0;
    }

// Obtener el porcentaje del modelo ConceptosNomina
    $conceptoHijosEspeciales = ConceptosNomina::where('codigo_concepto', '4014')
        ->where('tipo_empleado', 'DOC')
        ->first();

    if ($conceptoHijosEspeciales) {
        $porcentajeHijosEspeciales = $conceptoHijosEspeciales->porcentaje;
    } else {
        $porcentajeHijosEspeciales = 0;
    }

// Calcular el monto por cada hijo
    $montoPorHijoEspecial = $sueldoObrero * $porcentajeHijosEspeciales / 100;
    
// Calcular  el monto total por hijos
    $resultadoHijosEspeciales = $cantidadDeHijosEspeciales * $montoPorHijoEspecial;

// Asignar el resultado final al objeto $item
    $item->resultado_hijos_especiales = $resultadoHijosEspeciales;

    
//CALCULO PRIMA POR HIJOS ESTUDIANDO
// Conteo de registros en el modelo Familiares
    $cantidadDeHijosEstudiando = Familiares::where('codigo_empleado', $item->codigo_empleado)
        ->where('parentesco', 'H')
        ->where('estudia', 'S')
        ->count();

// Verificar si la cantidad de hijos Estudiando es vacía y asignar 0 en ese caso
    if (empty($cantidadDeHijosEstudiando)) {
        $cantidadDeHijosEstudiando = 0;
    }

// Obtener el porcentaje del modelo ConceptosNomina
    $conceptoHijosEstudiando = ConceptosNomina::where('codigo_concepto', '4014')
        ->where('tipo_empleado', 'DOC')
        ->first();

    if ($conceptoHijosEstudiando) {
        $porcentajeHijosEstudiando = $conceptoHijosEstudiando->porcentaje;
    } else {
        $porcentajeHijosEstudiando = 0;
    }

// Calcular el monto por cada hijo
    $montoPorHijoEstudiando = $sueldoObrero * $porcentajeHijosEstudiando / 100;
    
// Calcular  el monto total por hijos
    $resultadoHijosEstudiando = $cantidadDeHijosEstudiando * $montoPorHijoEstudiando;

// Asignar el resultado final al objeto $item
    $item->resultado_hijos_Estudiando = $resultadoHijosEstudiando;

//Calculo del S.S.O
// Obtener el porcentaje del S.S.O del modelo ConceptosNomina
    $conceptoSSO = ConceptosNomina::where('codigo_concepto', '5001')
    ->where('tipo_empleado', 'DOC')
    ->first();

    if ($conceptoSSO) {
        $porcentajeSSO = $conceptoSSO->porcentaje;
    } else {
        $porcentajeSSO = 0;
    }
    
// Calcular el monto SSO
    $montoSSO = $sueldoObrero * $porcentajeSSO / 100;
// Asignar el resultado final al objeto $item
    $item->montoSSO = $montoSSO;

//Calculo del S.P.F
// Obtener el porcentaje del S.P.F del modelo ConceptosNomina
    $conceptoSPF = ConceptosNomina::where('codigo_concepto', '5002')
    ->where('tipo_empleado', 'DOC')
    ->first();

    if ($conceptoSPF) {
        $porcentajeSPF = $conceptoSPF->porcentaje;
    } else {
        $porcentajeSPF = 0;
    }

// Calcular el monto SPF
    $montoSPF = $sueldoObrero * $porcentajeSPF / 100;
// Asignar el resultado final al objeto $item
    $item->montoSPF = $montoSPF;

//Calculo del S.P.H
// Obtener el porcentaje del S.P.H del modelo ConceptosNomina
    $conceptoLPH = ConceptosNomina::where('codigo_concepto', '5003')
    ->where('tipo_empleado', 'DOC')
    ->first();

    if ($conceptoLPH) {
        $porcentajeLPH = $conceptoLPH->porcentaje;
    } else {
        $porcentajeLPH = 0;
    }

// Calcular el monto LPH
    $montoLPH = $sueldoObrero * $porcentajeLPH / 100;
// Asignar el resultado final al objeto $item
    $item->montoLPH = $montoLPH;

//Calculo del F.J.U
// Obtener el porcentaje del F.J.U del modelo ConceptosNomina
    $conceptoFJU = ConceptosNomina::where('codigo_concepto', '5004')
    ->where('tipo_empleado', 'DOC')
    ->first();

    if ($conceptoFJU) {
        $porcentajeFJU = $conceptoFJU->porcentaje;
    } else {
        $porcentajeFJU = 0;
    }

// Calcular el monto FJU
    $montoFJU = $sueldoObrero * $porcentajeFJU / 100;
// Asignar el resultado final al objeto $item
    $item->montoFJU = $montoFJU;

//Calculo del CAFUCAMIDE
// Obtener el porcentaje del CAFUCAMIDE del modelo ConceptosNomina
    $conceptoCafucamide = ConceptosNomina::where('codigo_concepto', '5004')
    ->where('tipo_empleado', 'DOC')
    ->first();
    if ($conceptoCafucamide) {
        $porcentajeCafucamide = $conceptoCafucamide->porcentaje;
    } else {
        $porcentajeCafucamide = 0;
    }
// Calcular el monto Cafucamide
    $montoCafucamide = $sueldoObrero * $porcentajeCafucamide / 100;
// Asignar el resultado final al objeto $item
    $item->montoCafucamide = $montoCafucamide;

//FILAS DEL EXCEL
    $sheet->setCellValue('A' . $row, $item->nro);
    $sheet->setCellValue('B' . $row, $item->cedula);
    $sheet->setCellValue('C' . $row, $item->nombre1 . ' ' . $item->nombre2 . ' ' . $item->apellido1 . ' ' . $item->apellido2);
    $sheet->setCellValue('D' . $row, 'por consultar');
    $sheet->setCellValue('E' . $row, $item->grado);
    $sheet->setCellValue('F' . $row, $item->nombre_cargo);
    $sheet->setCellValue('G' . $row, 'por consultar');
    $sheet->setCellValue('H' . $row, $item->fecha_ingreso);
    $sheet->setCellValue('I' . $row, $item->fechadeldia);
    $sheet->setCellValue('J' . $row, $item->calculo_antiguedad);
    $sheet->setCellValue('K' . $row, $item->antiguedad_admon_publica);
    $sheet->setCellValue('L' . $row, $item->total_antiguedad);
    $sheet->setCellValue('M' . $row, $item->sueldo_obrero);
    $sheet->setCellValue('N' . $row, $item->prima_antiguedad);
    $sheet->setCellValue('O' . $row, $item->monto_prima_profesionalizacion);
    $sheet->setCellValue('P' . $row, $item->monto_prima_tsu);
    $sheet->setCellValue('Q' . $row, $item->resultado_hijos);
    $sheet->setCellValue('R' . $row, $item->resultado_hijos_Estudiando);
    $sheet->setCellValue('S' . $row, $item->resultado_hijos_especiales);
    $sheet->setCellValue('T' . $row, 'por consultar');
    $sheet->setCellValue('U' . $row, $item->montoSSO);
    $sheet->setCellValue('V' . $row, $item->montoSPF);
    $sheet->setCellValue('W' . $row, $item->montoLPH);
    $sheet->setCellValue('X' . $row, $item->montoFJU);
    $sheet->setCellValue('Y' . $row, $item->montoCafucamide);
    

    $row++; // Incrementar el número de fila para el próximo registro

}
// Crear un objeto Writer para generar el archivo Excel
    $writer = new Xlsx($spreadsheet);

// Guardar el archivo en una ubicación temporal
    $tempFilePath = sys_get_temp_dir() . '/NOMINA_PERSONAL_DOCENTES.xlsx';
    $writer->save($tempFilePath);

// Crear una respuesta con el archivo Excel
    $response = new BinaryFileResponse($tempFilePath);
    $response->setContentDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        'NOMINA_PERSONAL_DOCENTES.xlsx'
    );


//dd($montoSSO);
// Devolver la respuesta
return $response;
return view('sireh.nomina.personal_civil.excel-vista', compact('nomina'));



}



}