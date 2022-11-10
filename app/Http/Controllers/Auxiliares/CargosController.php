<?php

namespace App\Http\Controllers\Auxiliares;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;

use App\Models\Cargos;
use App\Models\Estados;

class CargosController extends Controller
{
    public function index()
    {
        return view('auxiliares.cargos.index');
    }

    //Obtiene los cargos, exclusivo por api para el Datatable
    public function cargosData(Request $request)
    {
        $cargos = Cargos::select(
            'id',
            'codigo_cargo',
            'nombre_cargo',
            'situacion',
            'tipo_cargo',
        );
        $datatable = Datatables::of($cargos)
            ->addColumn('actions', 'auxiliares.cargos._actions')
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

        $clasificacion = Config::get('constants.clasificacion_cargo');
        return view('auxiliares.cargos.create', compact('clasificacion'));
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
            'codigo_cargo' => 'required|unique:cargos,codigo_cargo',
            'nombre_cargo' => 'required',
            'tipo_cargo' => 'required'
        ]);

        $input = [
            'codigo_cargo' => $request->codigo_cargo, 
            'nombre_cargo' => $request->nombre_cargo, 
            'tipo_cargo' => $request->tipo_cargo, 
            'situacion' => $request->situacion, 
        ];
       
        $cargo = Cargos::create($input);

        return redirect()->route('auxiliares.cargos.index')
            ->with('success', 'Cargo creado satisfactoriamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cargo = Cargos::find($id);
        $clasificacion = Config::get('constants.clasificacion_cargo');
        return view('auxiliares.cargos.edit', compact('cargo', 'clasificacion'));
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
            'nombre_cargo' => [
                'required'
            ],
        ]);

        $cargo = Cargos::find($id);
        $cargo->nombre_cargo = strtolower($request->input('nombre_cargo'));
        $cargo->tipo_cargo = $request->input('tipo_cargo');
        $cargo->situacion = $request->input('situacion');
        $cargo->save();

        return redirect()->route('auxiliares.cargos.index')
            ->with('success', 'Cargo actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cargo = Cargos::find($id);
        $cargo->delete();
        return response()->json(['success' => true]);
    }
}
