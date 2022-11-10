<?php

namespace App\Http\Controllers\Auxiliares;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;

use App\Models\Profesion;

class ProfesionesController extends Controller
{
    public function index()
    {
        return view('auxiliares.profesiones.index');
    }

    //Obtiene los cargos, exclusivo por api para el Datatable
    public function profesionesData(Request $request){
        $profesiones = Profesion::select(
            'id',
            'codigo_profesion',
            'descripcion'
        );
        $datatable= Datatables::of($profesiones)
            ->addColumn('actions', 'auxiliares.profesiones._actions')
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
        return view('auxiliares.profesiones.create');
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
            'codigo_profesion' => 'required|unique:profesiones,codigo_profesion',
            'descripcion' => 'required'
        ]);

        $Profesiones = new Profesion();
        $Profesiones->codigo_profesion = $request->codigo_profesion;
        $Profesiones->descripcion = strtoupper($request->descripcion);
        $Profesiones->save();

        //$input = $request;
        //$profesiones = Profesion::create($input);

        return redirect()->route('auxiliares.profesiones.index')
            ->with('success','Profesión creada satisfactoriamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profesiones = Profesion::find($id);
        return view('auxiliares.profesiones.edit',compact('profesiones'));
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

        $profesiones = Profesion::find($id);
        $profesiones->descripcion = strtoupper($request->input('descripcion'));
        $profesiones->save();

        return redirect()->route('auxiliares.profesiones.index')
            ->with('success','Profesión actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //\DB::table("profesiones")->where('id',$id)->delete();
        $profesiones = Profesion::find($id);
        $profesiones->delete();
        return response()->json(['success' => true]);
    }
}
