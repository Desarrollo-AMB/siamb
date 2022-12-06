<?php

namespace App\Http\Controllers\Auxiliares;

use App\Http\Controllers\Controller;
use App\Models\Base;
use App\Models\Estados;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;


use App\Models\Ubicaciones;

class UbicacionesController extends Controller
{
    public function index()
    {
        $tipo_unidad= Config::get('constants.tipo_unidad');
        return view('auxiliares.ubicaciones.index',compact('tipo_unidad'));
    }

    //Obtiene los cargos, exclusivo por api para el Datatable
    public function UbicacionesData(Request $request){
    /* $ubicaciones = Ubicaciones::
        select(
            'ubicaciones.id','ubicaciones.codigo_ubicacion',
            'ubicaciones.descripcion',
            'ubicaciones.tipo_unidad_organizacional',
            'estados.id_estado as estado',
            'ubicaciones.tipo_unidad',
            'ubicaciones.redi',
            'ubicaciones.zodi',
            'ubicaciones.situacion');
        $ubicaciones->join('nomina','nomina.codigo_ubicacion','=','ubicaciones.codigo_ubicacion');
        $ubicaciones->join('estados','estados.id_estado','=','ubicaciones.codigo_estado'*/

        $ubicaciones = Ubicaciones::join('estados','estados.id_estado','=','ubicaciones.codigo_estado');

        $ubicaciones->select(
            'id','codigo_ubicacion','descripcion','tipo_unidad_organizacional',
            'estados.estado as codigo_estado','tipo_unidad','redi','zodi','situacion',

        );


        $datatable= Datatables::of($ubicaciones)
            ->addColumn('actions', 'auxiliares.ubicaciones._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $estados = Estados::all();
        $bases = Base::all();
        $redi= Config::get('constants.redi');
        $tipo_unidad= Config::get('constants.tipo_unidad');
        return view('auxiliares.ubicaciones.create',compact('redi', 'estados','tipo_unidad','bases'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [

            'codigo_ubicacion' => 'required|unique:ubicaciones,codigo_ubicacion',
            'descripcion' => 'required',
            'tipo_unidad' => 'required',
            'codigo_estado' =>'required',
            'base' => 'required',
            'redi' => 'required',
            'zodi' => 'required'

        ]);
        $ubicaciones = new Ubicaciones();
        $ubicaciones->codigo_ubicacion=$request->codigo_ubicacion;
        $ubicaciones->descripcion=$request->descripcion;
        $ubicaciones->tipo_unidad=$request->tipo_unidad;
        $ubicaciones->codigo_estado=$request->codigo_estado;
        $ubicaciones->base=$request->base;
        $ubicaciones->redi=$request->redi;
        $ubicaciones->zodi=$request->zodi;
        $ubicaciones->save();

        //$input = $request;
        //$ubicaciones = Ubicaciones::create($input);

        return redirect()->route('auxiliares.ubicaciones.index')
            ->with('success','Ubicacion creada satisfactoriamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ubicaciones = Ubicaciones::find($id);
        $estados = Estados::all();
        $bases = Base::all();
        $redi= Config::get('constants.redi');
        $tipo_unidad= Config::get('constants.tipo_unidad');
        return view('auxiliares.ubicaciones.edit',compact('ubicaciones','redi', 'estados','tipo_unidad','bases'));
    }

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
            'descripcion' => [
                'required'
            ],
        ]);

        $ubicaciones = Ubicaciones::find($id);
        $ubicaciones->descripcion= strtolower($request->input('descripcion'));
        $ubicaciones->tipo_unidad = $request->input('tipo_unidad');
        $ubicaciones->base = $request->input('base');
        $ubicaciones->codigo_estado = $request->input('codigo_estado');
        $ubicaciones->redi = $request->input('redi');
        $ubicaciones->zodi = $request->input('zodi');
        $ubicaciones->situacion = $request->input('situacion');
        $ubicaciones->save();

        return redirect()->route('auxiliares.ubicaciones.index')
            ->with('success','Ubicacion actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //\DB::table("cargos")->where('id',$id)->delete();

        $ubicaciones=Ubicaciones::find($id);
        $ubicaciones->delete();
       return response()->json(['success' => true]);
    }
}
