<?php

namespace App\Http\Controllers\Parte;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Base;
use App\Models\CategoriasMilitares;
use App\Models\Empleado;
use App\Models\Estados;
use App\Models\Nomina;
use App\Models\parte_general;
use Dompdf\Dompdf;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;
use Dompdf\Adapter\PDFLib;

use App\Models\Ubicaciones;
use Illuminate\Support\Facades\DB;

class PartegeneralController extends Controller
{
    public function index()
    {

        $nomina_count = Nomina::where('situacion', ['A', 'S'])
            ->whereIn('tipo_emp', ['MIL', 'TRP'])
            ->count();
        $presente_count = DB::table('parte_general')
            ->join('nomina', 'parte_general.codigo_empleado', '=', 'nomina.codigo_empleado')
            ->where('nomina.situacion', ['A', 'S'])
            ->whereIn('nomina.tipo_emp', ['MIL', 'TRP'])
            ->where('parte_general.situacion', 'presente')
            ->count();

        $ausentes_count = $nomina_count - $presente_count;

        $categorias = Nomina::join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
            ->where('Nomina.situacion', ['A', 'S'])
            ->whereIn('Nomina.tipo_emp', ['MIL', 'TRP'])
            ->select(
                \DB::raw('count(*) as total'),
                \DB::raw('sum(case when datos_militares.codigo_categoria in ("1","4") then 1 else 0 end) as comando'),
                \DB::raw('sum(case when datos_militares.codigo_categoria = "5" then 1 else 0 end) as tecnico'),
                \DB::raw('sum(case when datos_militares.codigo_categoria = "6" then 1 else 0 end) as asimiladotc'),
                \DB::raw('sum(case when datos_militares.codigo_categoria = "2" then 1 else 0 end) as asimilado'),
                \DB::raw('sum(case when datos_militares.codigo_categoria = "7" then 1 else 0 end) as tropacmd'),
                \DB::raw('sum(case when datos_militares.codigo_categoria = "8" then 1 else 0 end) as trp')
            )
            ->get();


        // Conteo de la tabla parte_general
        $parte_generales = Nomina::join('parte_general', 'nomina.codigo_empleado', '=', 'parte_general.codigo_empleado')
            ->where('Nomina.situacion', ['A', 'S'])
            ->whereIn('Nomina.tipo_emp', ['MIL', 'TRP'])
            ->select(
                \DB::raw('count(*) as total'),
                \DB::raw('sum(parte_general.situacion = "presente") as totalq'),
                \DB::raw('sum(parte_general.situacion = "reposo") as total2'),
                \DB::raw('sum(parte_general.situacion = "comision") as total3')
            )
            ->groupBy('Nomina.situacion')
            ->get();




        return view('sireh.personal.militar.parte.index', compact('parte_generales', 'nomina_count', 'ausentes_count', 'categorias'));
    }
    public function indexparte()
    {
        $user_id = auth()->user()->id; //obtener el id del usuario que ha iniciado sesión

        $codigo_ubicacion = DB::table('nomina')
            ->join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
            ->where('empleados.user_id', '=', $user_id)
            ->select('nomina.codigo_ubicacion')
            ->first()
            ->codigo_ubicacion;
        $parte = parte_general::
        select('fecha');
        $nominas = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
            ->where('ubicaciones.codigo_ubicacion', '=', $codigo_ubicacion)
            ->select(
                'nomina.grado_militar',
                'empleados.nombre1',
                'empleados.apellido1',
                'ubicaciones.descripcion',
                'grados_militares.siglas',
                'datos_militares.codigo_categoria',
                'nomina.codigo_empleado',
                'nomina.codigo_ubicacion',
                'nomina.grado_militar'
            )
            ->get();


        return view('sireh.personal.militar.parte.create', compact('nominas','parte'));
    }



    //Obtiene los cargos, exclusivo por api para el Datatable
    public function UbicacionesData(Request $request)
    {
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

        $ubicaciones = Ubicaciones::join('estados', 'estados.id_estado', '=', 'ubicaciones.codigo_estado');

        $ubicaciones->select(
            'id',
            'codigo_ubicacion',
            'descripcion',
            'tipo_unidad_organizacional',
            'estados.estado as codigo_estado',
            'tipo_unidad',
            'redi',
            'zodi',
            'situacion',

        );


        $datatable = Datatables::of($ubicaciones)
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
        $redi = Config::get('constants.redi');
        $tipo_unidad = Config::get('constants.tipo_unidad');
        return view('sireh.personal.militar.part.create', compact('redi', 'estados', 'tipo_unidad', 'bases'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $nominas = $request->input('nominas');
            $fecha = $request->input('fecha');

            // Comprobar si la fecha ya existe para una ubicación específica
            foreach ($nominas as $nomina) {
                $parteExistente = parte_general::where([
                    ['fecha', '=', $fecha],
                    ['codigo_ubicacion', '=', $nomina['codigo_ubicacion']]
                ])->first();

                if ($parteExistente) {
                    $mensajeError = 'Ya existe un parte para la fecha y ubicación especificadas';
                    return redirect()->back()->withErrors( $mensajeError);
                }
            }

            // Guardar las nuevas nominas
            foreach ($nominas as $nomina) {
                $parte = new parte_general;
                $parte->fecha = $fecha;
                $parte->codigo_empleado = $nomina['codigo_empleado'];
                $parte->codigo_ubicacion = $nomina['codigo_ubicacion'];
                $parte->codigo_categoria = $nomina['codigo_categoria'];
                $parte->grado_militar = $nomina['grado_militar'];
                $parte->situacion = $nomina['situacion'];
                $parte->observacion = $nomina['observacion'];
                $parte->save();
            }

            return redirect()->route('sireh.personal.militar.parte.create')->with('success_message', 'Parte fue ingresado con éxito');
        } catch (\Exception $e) {
            return redirect()->route('sireh.personal.militar.parte.create')->with('errors', 'Errors al guardar los datos: '.$e->getMessage());
        }
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
        $redi = Config::get('constants.redi');
        $tipo_unidad = Config::get('constants.tipo_unidad');
        return view('auxiliares.ubicaciones.edit', compact('ubicaciones', 'redi', 'estados', 'tipo_unidad', 'bases'));
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
        $ubicaciones->descripcion = strtolower($request->input('descripcion'));
        $ubicaciones->tipo_unidad = $request->input('tipo_unidad');
        $ubicaciones->base = $request->input('base');
        $ubicaciones->codigo_estado = $request->input('codigo_estado');
        $ubicaciones->redi = $request->input('redi');
        $ubicaciones->zodi = $request->input('zodi');
        $ubicaciones->situacion = $request->input('situacion');
        $ubicaciones->save();

        return redirect()->route('auxiliares.ubicaciones.index')
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
        //\DB::table("cargos")->where('id',$id)->delete();

        $ubicaciones = Ubicaciones::find($id);
        $ubicaciones->delete();
        return response()->json(['success' => true]);
    }


    public function ParteReportes()
    {
        $ubicaciones = Ubicaciones::all();
        $categorias_militares =  CategoriasMilitares::whereIn('tipo_emp',['MIL','MEX','TRP'])->get();
        return view('sireh.personal.militar.parte.reporte.reportes', compact(
            'categorias_militares','ubicaciones'
        ));
    }



    public function reporteParteUnidad(Request $request) {
        $this->validate($request,
        //dd($request),
            [
                'fecha' => 'required',
                'parametros' => 'required|array|min:1',
                'parametros.*' => 'required|string|distinct',

            ],
            [
                'fecha' => 'La fecha es requerida',
                'parametros.*.required' => 'la ubicacion es requerida',
            ]
        );
        $nameParametro =array_key_first($request->parametros);
        $valueParametro = $request->parametros[$nameParametro];
        $fechas = $request->fecha;
//dd([$valueParametro]);
////obtener los datos del la tabala nomina////////////
           $nomina_count = Nomina::where('situacion', ['A', 'S'])
        ->whereIn('nomina.tipo_emp', ['MIL', 'TRP'])
        ->whereIn('nomina.codigo_ubicacion', [$valueParametro])
        ->count();
    $presente_count = DB::table('parte_general')
        ->join('nomina', 'parte_general.codigo_empleado', '=', 'nomina.codigo_empleado')
        ->where('nomina.situacion', ['A', 'S'])
        ->whereIn('nomina.tipo_emp', ['MIL', 'TRP'])
        ->where('parte_general.situacion', 'presente')
        ->whereIn('parte_general.codigo_ubicacion', [$valueParametro])
        ->whereIn('parte_general.fecha',[$fechas])
        ->count();
             $ausentes_count = $nomina_count - $presente_count;

             ///OBTENER LISTA DEL PERSONAL //
    $lista
//dd($presente_count);
        $datas = Nomina::join('parte_general','nomina.codigo_empleado','=','parte_general.codigo_empleado')
            ->join('ubicaciones','nomina.codigo_ubicacion','=','ubicaciones.codigo_ubicacion')
            ->join('datos_militares','datos_militares.codigo_empleado','=','nomina.codigo_empleado')
            ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
            ->where('parte_general.fecha', [$fechas])
            ->whereIn('parte_general.codigo_ubicacion', [$valueParametro])
            ->select(
                'nomina.nombre1 as nombre','nomina.apellido1 as  apellido','nomina.cedula as cedula','ubicaciones.descripcion as ubicacion',
                \DB::raw('count(*) as total'),
                \DB::raw('sum(parte_general.situacion = "presente") as totalq'),
                \DB::raw('sum(parte_general.situacion = "reposo") as total2'),
                \DB::raw('sum(parte_general.situacion = "comision") as total3'),
                \DB::raw('sum(case when parte_general.codigo_categoria in ("1","4") then 1 else 0 end) as comando'),
                \DB::raw('sum(case when parte_general.codigo_categoria = "5" then 1 else 0 end) as tecnico'),
                \DB::raw('sum(case when parte_general.codigo_categoria = "6" then 1 else 0 end) as asimiladotc'),
                \DB::raw('sum(case when parte_general.codigo_categoria = "2" then 1 else 0 end) as asimilado'),
                \DB::raw('sum(case when parte_general.codigo_categoria = "7" then 1 else 0 end) as tropacmd'),
                \DB::raw('sum(case when parte_general.codigo_categoria = "8" then 1 else 0 end) as trp')
        )->first();
       //dd($datas->tecnico);
        if(!$datas){
            return back()
            ->with('warning','No se puede generar el reporte, no existen registros que corresponda a la cedula');
        }




        $pdf = \PDF::loadView('sireh.personal.militar.parte.reporte.rep_parte_unidad', compact('datas', 'nomina_count', 'ausentes_count'));

        return $pdf->stream('parte.pdf',array('Attachment'=>0));
        //return view('bienestar_social.reporte_devolucion5', compact('datas'));

    }


}
