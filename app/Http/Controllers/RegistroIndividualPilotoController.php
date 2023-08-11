<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fam0001B1Tripulacion;
use App\Models\Fam0001B1TripulacionAterrizajes;
use App\Models\EmpleadoFuncion;

class RegistroIndividualPilotoController extends Controller
{

    public function ingresar_horas_tripulante()
    {
        $tripulantes = EmpleadoFuncion::with('empleado')
        ->join('funcion_tripulante', 'empleado_funcion.id_funcion', '=', 'funcion_tripulante.id')
        ->join('nomina','nomina.codigo_empleado','=','empleado_funcion.codigo_empleado')
        ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
        ->select(
            'empleado_funcion.*',
            'funcion_tripulante.*',
            'grados_militares.siglas'
        )
        ->get();
        //dd($tripulantes);
        return view('dao.personal.militar.individual_vuelo.ingresar_horas_piloto', compact('tripulantes'));
    }

    public function obtener_tripulante(Request $request)
    {

        $tripulante = EmpleadoFuncion::join('nomina','nomina.codigo_empleado','=','empleado_funcion.codigo_empleado')
        ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
        ->join('funcion_tripulante','funcion_tripulante.id','=','empleado_funcion.id_funcion')
        ->join('empleados','empleados.codigo_empleado','=','empleado_funcion.codigo_empleado')
        ->where('empleado_funcion.codigo_empleado', $request->codigo_empleado)
        ->select(
            'empleado_funcion.codigo_empleado',
            'empleado_funcion.id as id_empleado_funcion',
            'grados_militares.siglas',
            'empleados.apellido1',
            'empleados.nombre1',
            'empleados.cedula',
            'funcion_tripulante.id as id_funcion',
            'funcion_tripulante.codigo',
        )
        ->get()
        ->first();

        $check_b1_tripulante = Fam0001B1Tripulacion::where('cedula', $tripulante->cedula)
        ->where('fam0001_id', 999999)
        ->where('fam0001_a1_mision_id', 999999)
        ->get();

        if(count($check_b1_tripulante) > 0){
            $tripulante->hv = $check_b1_tripulante[0]->hv;
            $tripulante->hv1 = $check_b1_tripulante[0]->hv1;
            $tripulante->hv2 = $check_b1_tripulante[0]->hv2;
            $tripulante->hv3 = $check_b1_tripulante[0]->hv3;
            $tripulante->hv4 = $check_b1_tripulante[0]->hv4;
        } else{
            $tripulante->hv = 0;
            $tripulante->hv1 = 0;
            $tripulante->hv2 = 0;
            $tripulante->hv3 = 0;
            $tripulante->hv4 = 0;
        }



        //return response()->json($request);
        return response()->json(
            [
                'success' => true,
                'message' => 'successfully',
                'data' => $tripulante
            ]
        );
    }

    public function store_b1_anterior(Request $request)
    {
        $check_b1_tripulante = Fam0001B1Tripulacion::where('cedula', $request->cedula)
        ->where('fam0001_id', 999999)
        ->where('fam0001_a1_mision_id', 999999)
        ->get();

        if(count($check_b1_tripulante) > 0){

            $B1 = Fam0001B1Tripulacion::where('cedula', $request->cedula)
            ->where('fam0001_id', 999999)
            ->where('fam0001_a1_mision_id', 999999)
            ->update([
                'hv' => $request->hv,
                'hv1' => $request->hv1,
                'hv2' => $request->hv2,
                'hv3' => $request->hv3,
                'hv4' => $request->hv4,
            ]);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data inserted successfully'
                ]
            );

        } else{

            $B1 = new Fam0001B1Tripulacion;
            $B1->fam0001_id = 999999;
            $B1->fam0001_a1_mision_id = 999999;

            $B1->grado_nombre_id = $request->grado_nombre_id;
            $B1->grado_nombre_data = $request->grado_nombre_data;
            $B1->cedula = $request->cedula;
            $B1->codigo_funcion = $request->codigo_funcion;
            $B1->funcion = $request->funcion;

            $B1->hv = $request->hv;
            $B1->cod1 = $request->cod1;
            $B1->cod2 = $request->cod2;
            $B1->cod3 = $request->cod3;
            $B1->cod4 = $request->cod4;
            $B1->hv1 = $request->hv1;
            $B1->hv2 = $request->hv2;
            $B1->hv3 = $request->hv3;
            $B1->hv4 = $request->hv4;

            $B1->completado = 'completado';
            $B1->user_id = auth()->id();
            $B1->save();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data inserted successfully'
                ]
            );
        }
    }

    /*public function store_aterrizaje(Request $request)
    {

        $loop = count($request->aterrizajeData);

        for ($i=0; $i < $loop; $i++) {
            $B1_aterrizajes = new Fam0001B1TripulacionAterrizajes;

            $B1_aterrizajes->ov_ota_om = $request->aterrizajeData[$i]['ov_ota_om'];
            $B1_aterrizajes->fam0001_id = $request->aterrizajeData[$i]['fam0001_id'];
            $B1_aterrizajes->fam0001_a1_mision_id = $request->aterrizajeData[$i]['fam0001_a1_mision_id'];

            $B1_aterrizajes->TIP_ATERRIZAJE = $request->aterrizajeData[$i]['TIP_ATERRIZAJE'];
            $B1_aterrizajes->CANTIDAD = $request->aterrizajeData[$i]['CANTIDAD'];

            $B1_aterrizajes->save();

        }
        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'data' => $loop
            ]
        );
    }*/

}