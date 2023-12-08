<?php

namespace App\Http\Controllers;

use App\Models\ModelEventos;
use App\Models\ModelJres;
use App\Models\ModelReporteDres;
use App\Models\Ubicaciones;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class Drescontroller extends Controller
{
    public function index(){

        $ubicaciones =Ubicaciones::all();
       $eventos = ModelEventos::all();
       $jres = ModelJres::all();
       $tipo_evento = config::get('constants.tipo_evento');
        return view('dress.create',compact('ubicaciones','eventos','tipo_evento','jres')); 
    }
    public function getTiposEvento(Request $request)
    {
        // Obtén la clase de evento desde la solicitud
        $claseEvento = $request->input('clase');
   
        // Realiza la lógica para obtener los tipos de evento asociados a la clase (ajusta según tu estructura de datos)
        $tiposEvento = ModelEventos::where('clase', $claseEvento)->get(); // Reemplaza con tu lógica para obtener los tipos de evento
    
        return response()->json($tiposEvento);
    }

    public function reporte (Request $request) {
        $this->validate(
            $request,
            [
                'n_reporte' => 'required',
                'JRES' => 'required',
                'fechaR' => 'required',
                'grupo_fecho_hora' => 'required',
                'p_envia' => 'required',
                'unidad' => 'required',
                'cmdtU' => 'required',
                'clase' => 'required',
                'tipo' => 'required',
                'event' => 'required',
                'descripcion' => 'required',
                'lugarO' => 'required',
                'fechaO' => 'required',
                 'situacion' => 'required',
                 'documentos' => 'required',
            ],
            [
                'n_reporte' => 'el numero de reporte es requerido',
                'JRES' => 'JRES es requerido',
                'fechaR' => 'fecha de reporte es requerido',
                'grupo_fecho_hora' => 'grupo fecho hora es requerido',
                'p_envia' => 'persona envia es requerido',
                'unidad' => 'unidad es requerido',
                'cmdtU' => 'comandante der unidad es requerido',
                'clase' => 'clase  de evento es requerido',
                'tipo' => 'tipo  de evento es requerido',
                'event' => 'evento es requerido ',
                'descripcion' => 'la descripcion es requerida',
                'lugarO' => 'lugar de ocurrencia es requerido',
                'fechaO' => 'fecha de ocurrencia es requerido',
                 'situacion' => 'la situacion es requerida',
                 'documentos' => 'documentos afectados es requerido',
            ]
        );

       try{

       $data = new ModelReporteDres();
        $data->n_reporte = $request->n_reporte;
        $data->JRES = $request->JRES;
        $data->fecha_reporte = $request->fechaR;
        $data->grupo_fecha = $request->grupo_fecho_hora;
        $data->persona_envia = $request->p_envia;
        $data->unidad_involucrada = $request->unidad;
        $data->cmdt_unidad = $request->cmdtU;
        $data->clase_envento = $request->clase;
        $data->tipo_evento = $request->tipo;
        $data->evento = $request->event;
        $data->descripcion = $request->descripcion;
        $data->lugar_ocurrencia = $request->lugarO;
        $data->fecha_ocurrencia = $request->fechaO;
        $data->situacion = $request->situacion;
        $data->documento = $request->documentos;
        $data->save();

        return redirect()->route('dres.view')->with('success', 'Se ha cargado  la información exitosamente');
    } catch (Exception $e) {
        Log::error("************************* ERROR ************************* \n" . $e);
        return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
    }
}
}   