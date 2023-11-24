<?php

namespace App\Http\Controllers;

use App\Models\ModelEventos;
use App\Models\ModelReporteDres;
use App\Models\Ubicaciones;
use Illuminate\Http\Request;

class Drescontroller extends Controller
{
    public function index(){

        $ubicaciones =Ubicaciones::all();
       $eventos = ModelEventos::all();
        return view('dress.create',compact('ubicaciones','eventos')); 
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
        $data->tn_reporte = $request->n_reporte;
        $data->JRES = $request->JRES;
        $data->fechaR = $request->fechaR;
        $data->grupo_fecho_hora = $request->grupo_fecho_hora;
        $data->p_envia = $request->p_envia;
        $data->unidad = $request->unidad;
        $data->cmdtU = $request->cmdtU;
        $data->clase = $request->clase;
        $data->tipo = $request->tipo;
        $data->event = $request->event;
        $data->descripcion = $request->descripcion;
        $data->lugarO = $request->lugarO;
        $data->fechaO = $request->fechaO;
        $data->situacion = $request->situacion;
        $data->documentos = $request->documentos;
        $data->save();

        return redirect()->route('sireh.personal-militar.view', [$request->id])->with('success', 'Se han actualizado los Datos del Profesional');
    } catch (Exception $e) {
        Log::error("************************* ERROR ************************* \n" . $e);
        return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
    }
}
}