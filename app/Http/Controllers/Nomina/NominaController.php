<?php

namespace App\Http\Controllers\Nomina;

use App\Http\Controllers\Controller;
use App\Models\asignaciones;
use App\Models\ConceptosNomina;
use App\Models\Empleado;
use Illuminate\Http\Request;

class NominaController extends Controller
{

 //INDEX PRINCIPAL DE NOMINA
    public function indexNomina()
    {
        return view('sireh.nomina.index');
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
        return view('sireh.nomina.sueldo_base');
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
    public function editPrima (ConceptosNomina $registro){

       // $prima = ConceptosNomina::find($id);
        return view('sireh.nomina.personal_militar.primas-edit',compact('registro'));
    }
//UPDATE PRIMAS
/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $registro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $registro)
    {

        $this->validate($request, [

            'descripcion' => 'required',
            'porcentaje' => 'required',
        ]);

        $universidades = ConceptosNomina::find($registro);
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

public function deletePrimaAsignada($id)
{
    $asignacion = asignaciones::find($id);
    $asignacion->delete();

    return view('sireh.nomina.personal_militar.actuales-primas');
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
    $codigo_concepto = $request->input('codigo_concepto');
    $cedula = $request->input('cedula');
    $empleado_nombre = $request->input('nombre');
    $empleado_apellido = $request->input('apellido');
    $cedula = $request->input('cedula');
    $codigo_empleado = $request->input('codigo_empleado');
    $tipo = $request->input('tipo');

    $conceptos_nomina = ConceptosNomina::
        select('codigo_concepto', 'descripcion', 'tipo')
        ->where('tipo', 'A')
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
            return view('sireh.nomina.personal_militar.actuales-primas',compact('asignaciones', 'conceptos_nomina', 'dataemp'));
        }

        $asignacion = new asignaciones();
        $asignacion->codigo_empleado = $codigo_empleado;
        $asignacion->id_concepto = $codigo_concepto;
        $asignacion->tipo_concepto = $tipo;
        $asignacion->save();

//return('no existe');
    return view('sireh.nomina.personal_militar.actuales-primas',compact('asignaciones', 'conceptos_nomina', 'dataemp'))->render();

}

                                    //SECCION DE DEDUCCIONES

//Ver deducciones
    public function deducciones(Request $request)
    {
        $data = ConceptosNomina::
            select('*',)
            ->where ('tipo', 'D')
            ->get();
      //dd($data);
        return view('sireh.nomina.personal_militar.deducciones',compact('data'));
    }
//EDIT PRIMA 2
public function editdeducciones (ConceptosNomina $registro){

    // $prima = ConceptosNomina::find($id);
     return view('sireh.nomina.personal_militar.deducciones-edit',compact('registro'));
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
//return($codigo_empleado);
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
                return view('sireh.nomina.personal_militar.actuales_deducciones',compact('asignaciones', 'conceptos_nomina', 'dataemp'));
            }

            $asignacion = new asignaciones();
            $asignacion->codigo_empleado = $codigo_empleado;
            $asignacion->id_concepto = $codigo_concepto;
            $asignacion->tipo_concepto = $tipo;
            $asignacion->save();

    //return('no existe');
        return view('sireh.nomina.personal_militar.actuales_deducciones',compact('asignaciones', 'conceptos_nomina', 'dataemp'))->render();

    }


}