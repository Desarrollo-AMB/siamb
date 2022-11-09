<?php

namespace App\Http\Controllers\Auxiliares;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;

use App\Models\Universidades;

class UniversidadesController extends Controller
{
    public function index()
    {
        $tipo_universidad = Config::get('constants.tipo_universidad');
        $adscrita_aviacion = Config::get('constants.adscrita_aviacion');
        return view('auxiliares.universidades.index', compact('tipo_universidad', 'adscrita_aviacion'));
    }

    //Obtiene los cargos, exclusivo por api para el Datatable
    public function UniversidadesData(Request $request){
        $universidades = Universidades::select(
            'id',
            'codigo_universidad',
            'nombre',
            'tipo_universidad',
            'adscrita_aviacion'
        );
        $datatable= Datatables::of($universidades)
            ->addColumn('actions', 'auxiliares.universidades._actions')
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
        $tipo_universidad = Config::get('constants.tipo_universidad');
        $adscrita_aviacion = Config::get('constants.adscrita_aviacion');
        return view('auxiliares.universidades.create',compact('tipo_universidad', 'adscrita_aviacion'));
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
            'codigo_universidad' => 'required|unique:universidades,codigo_universidad',
            'nombre' => 'required',
            'tipo_universidad' => 'required',
            'adscrita_aviacion' => 'required'
        ]);

        $universidades = new Universidades();
        $universidades->codigo_universidad = $request->codigo_universidad;
        $universidades->nombre = strtoupper($request->nombre);
        $universidades->tipo_universidad = $request->tipo_universidad;
        $universidades->adscrita_aviacion = $request->adscrita_aviacion;
        $universidades->save();

        // $input = $request;
        // $universidad = Universidades::create($input);

        return redirect()->route('auxiliares.universidades.index')
            ->with('success','Universidad creada satisfactoriamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $universidades = Universidades::find($id);
        $tipo_universidad = Config::get('constants.tipo_universidad');
        $adscrita_aviacion = Config::get('constants.adscrita_aviacion');
        return view('auxiliares.universidades.edit',compact('universidades', 'tipo_universidad', 'adscrita_aviacion'));
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
            'nombre' => ['required'],
            'tipo_universidad' => ['required'],
            'adscrita_aviacion' => ['required']
        ]);

        $universidades = Universidades::find($id);
        $universidades->nombre = strtoupper($request->input('nombre'));
        $universidades->tipo_universidad = $request->input('tipo_universidad');
        $universidades->adscrita_aviacion = $request->input('adscrita_aviacion');
        $universidades->save();

        return redirect()->route('auxiliares.universidades.index')
            ->with('success','Universidad actualizada con éxito');
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
        $universidades = Universidades::find($id);
        $universidades->delete();
        return response()->json(['success' => true]);
    }
}
