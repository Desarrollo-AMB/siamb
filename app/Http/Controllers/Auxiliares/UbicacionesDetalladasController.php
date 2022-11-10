<?php


namespace App\Http\Controllers\Auxiliares;

use App\Http\Controllers\Controller;
use App\Models\UbicacionDetallada;
use App\Models\Ubicaciones;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;




class UbicacionesDetalladasController extends Controller
{
    public function index()
    {
        $tipo_unidad = Config::get('constants.tipo_unidad');
        return view('auxiliares.ubicacionesDetalladas.index');
    }

    //Obtiene los cargos, exclusivo por api para el Datatable
    public function ubicacionesDetalladasData(Request $request)
    {
        $ubicacion_detallada = UbicacionDetallada::join('ubicaciones', 'ubicaciones.codigo_ubicacion', '=', 'ubicacion_detallada.codigo_ubic_nomina');
        $ubicacion_detallada->select(
            'ubicacion_detallada.id',
            'ubicacion_detallada.codigo_ubicacion',
            'ubicacion_detallada.descripcion',
            'ubicaciones.descripcion as codigo_ubic_nomina',
            'ubicacion_detallada.situacion'
        );

        /*$ubicaciones->join('nomina','nomina.codigo_ubicacion','=','ubicaciones.codigo_ubicacion');
        $ubicaciones->join('estados','estados.id_estado','=','ubicaciones.codigo_estado'




      $ubicaciones = UbicacionDetallada::join('estados','estados.id_estado','=','ubicaciones.codigo_estado');

        $ubicaciones->select(
            'id','codigo_ubicacion','descripcion','tipo_unidad_organizacional',
            'estados.estado as codigo_estado','tipo_unidad','redi','zodi','situacion',

        );*/


        $datatable = Datatables::of($ubicacion_detallada)
            ->addColumn('actions', 'auxiliares.ubicacionesDetalladas._actions')
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

        $ubicaciones = Ubicaciones::all();
        return view('auxiliares.ubicacionesDetalladas.create', compact('ubicaciones'));
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

            'codigo_ubicacion' => 'required|unique:ubicacion_detallada,codigo_ubicacion',
            'descripcion' => 'required',
            'codigo_ubc_nomina' => 'required',
            'fecha_creacion' => 'required'

        ]);
        $ubicacion_detallada = new UbicacionDetallada();
        $ubicacion_detallada->codigo_ubicacion = $request->codigo_ubicacion;
        $ubicacion_detallada->descripcion = $request->descripcion;
        $ubicacion_detallada->codigo_ubic_nomina = $request->codigo_ubc_nomina;
        $ubicacion_detallada->fecha_creacion = $request->fecha_creacion;
        $ubicacion_detallada->save();

        //$input = $request;
        //$ubicaciones = Ubicaciones::create($input);

        return redirect()->route('auxiliares.ubicacionesDetalladas.index')
            ->with('success', 'Ubicacion creada satisfactoriamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ubicacion_detallada = UbicacionDetallada::find($id);
        $ubicaciones = Ubicaciones::all();
        return view('auxiliares.ubicacionesDetalladas.edit', compact('ubicaciones', 'ubicacion_detallada'));
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

        $ubicacion_detallada = UbicacionDetallada::find($id);
        $ubicacion_detallada->descripcion = strtolower($request->input('descripcion'));
        $ubicacion_detallada->codigo_ubic_nomina = $request->input('codigo_ubic_nomina');
        $ubicacion_detallada->fecha_creacion = $request->input('fecha_creacion');
        $ubicacion_detallada->situacion = $request->input('situacion');
        $ubicacion_detallada->save();

        return redirect()->route('auxiliares.ubicacionesDetalladas.index')
            ->with('success', 'Ubicacion actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         UbicacionDetallada::find($id)->delete();
        //\DB::table("cargos")->where('id',$id)->delete();
        return response()->json(['success' => true]);
    }
}
