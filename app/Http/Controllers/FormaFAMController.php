<?php

namespace App\Http\Controllers;
use App\Models\AeronaveUnidades;
use App\Models\AeronaveModelo;
use App\Models\AeronaveMatricula;
use App\Models\ComponenteOrganismo;
use App\Models\Base;
use App\Models\EmpleadoFuncion;
use App\Models\Empleado;
use App\Models\Fam0001;
use App\Models\VueloOrdenadaPor;
use App\Models\VueloEnApoyo;
use App\Models\UnidadesConsumible;
use App\Models\UnidadesMedidas;
use App\Models\Fam0001A1Mision;
use App\Models\CodigoTipoMision;
use App\Models\Fam0001A1MisionConsumible;

use Illuminate\Http\Request;

class FormaFAMController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //HEADER
        $aeronaveModelos = AeronaveModelo::get();
        $matriculas = AeronaveMatricula::get();
        $unidad = AeronaveUnidades::get();
        $componentes = ComponenteOrganismo::get();
        $bases = Base::get();
        $jefeMaquina = EmpleadoFuncion::with('empleado')->get();
        //A1-MISION
        $vueloOrdenadaPor = VueloOrdenadaPor::get();
        $enApoyo = VueloEnApoyo::get();
        $consumibles = UnidadesConsumible::get();
        $unidadesMedida = UnidadesMedidas::get();
        $codigoMision = CodigoTipoMision::get();

        //dd($jefeMaquina);
        return view('forms.index', compact('codigoMision','consumibles','unidadesMedida','enApoyo','vueloOrdenadaPor','jefeMaquina', 'aeronaveModelos','matriculas','unidad','componentes', 'bases'));
    }

    public function aeronaves_grupos(Request $request)
    {
        $aeronaves = AeronaveModelo::where('codigo_unidad', $request->unidad)->get();
        return response()->json($aeronaves);
    }

    public function seriales(Request $request)
    {
        $selectedUnidad = AeronaveMatricula::where('aeronave_id', $request->id)->whereNotNull('serial')->get();
        return response()->json($selectedUnidad);
    }

    public function matriculas(Request $request)
    {
        $selectedMatricula = AeronaveMatricula::where('aeronave_id', $request->id)->get();
        return response()->json($selectedMatricula);
    }

    public function steps()
    {
        $headerData = Fam0001::get();
        $A1_data = Fam0001A1Mision::where('completado',"paso2")->get();
        return response()->json(["headerData"=>$headerData, "A1_data"=>$A1_data]);
    }

    public function store(Request $request)
    {
        $fam0001 = new Fam0001;
        $fam0001->fecha = $request->fecha;
        $fam0001->ov_ota_om = $request->ov_ota_om;
        $fam0001->componente_organismo = $request->componente_organismo;
        $fam0001->unidad = $request->unidad;
        $fam0001->aeronave_modelo = $request->aeronave_modelo;
        $fam0001->serial = $request->serial;
        $fam0001->matricula = $request->matricula;
        $fam0001->base_estacion = $request->base_estacion;
        $fam0001->jefe_maquina = $request->jefe_maquina;
        $fam0001->completado = $request->completado;
        $fam0001->save();

        $dataFam001 = [
            "id" => $fam0001->id,
            "ov_ota_om" => $request->ov_ota_om, 
        ];
            
        //return response()->json($request);
        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'data' => $dataFam001
            ]
        );
    }

    public function store_a1(Request $request)
    {
        $A1 = new Fam0001A1Mision;
        $A1->ordenada_por = $request->ordenada_por;
        $A1->en_apoyo = $request->en_apoyo;
        $A1->codigo = $request->codigo;
        $A1->ruta_desde = $request->ruta_desde;
        $A1->ruta_hasta = $request->ruta_hasta;
        $A1->encend = $request->encend;
        $A1->despeg = $request->despeg;
        $A1->aterriz = $request->aterriz;
        $A1->apag = $request->apag;
        $A1->registro_manual = $request->registro_manual;
        $A1->horometro = $request->horometro;
        $A1->ind_vuelo = $request->ind_vuelo;
        $A1->toque_desp = $request->toque_desp;
        $A1->low_go = $request->low_go;
        $A1->total = $request->total;
        $A1->ciclos_tren = $request->ciclos_tren;
        $A1->ov_ota_om = $request->ov_ota_om;
        $A1->fam0001_id = $request->fam0001_id;
        $A1->completado = $request->completado;
        $A1->save();

        $A1_id = Fam0001A1Mision::select('id')->where('id',$A1->id)->get();
        $A1_data = Fam0001A1Mision::where('fam0001_id',$request->fam0001_id)->get();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'data' => $A1_data,
                'A1_id' => $A1_id
            ]
        );

    }

    public function consumibles()
    {
        $consumibles = UnidadesConsumible::get();
        $unidades = UnidadesMedidas::get();
        return response()->json(["consumibles"=>$consumibles, "unidades"=>$unidades]);
    }

    public function store_a1_consumibles(Request $request)
    {

        $loop = count($request->consumiblesDATA);

        for ($i=0; $i < $loop; $i++) { 
            $A1_cosumibles = new Fam0001A1MisionConsumible;
            $A1_cosumibles->ov_ota_om = $request->consumiblesDATA[$i]['ov_ota_om'];
            $A1_cosumibles->fam0001_id = $request->consumiblesDATA[$i]['fam0001_id'];
            $A1_cosumibles->fam0001_a1_mision_id = $request->consumiblesDATA[$i]['fam0001_a1_mision_id'];

            $A1_cosumibles->consumible = $request->consumiblesDATA[$i]['consumiblesArray'];
            $A1_cosumibles->unidad = $request->consumiblesDATA[$i]['unidadesArray'];
            $A1_cosumibles->cantidad = $request->consumiblesDATA[$i]['cantidad'];

            $A1_cosumibles->save();
        
        }
        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully',
                'data' => $loop
            ]
        );
    }

    public function delete_a1_mision(Request $request)
    {
        Fam0001A1Mision::find($request->id)->delete();
        return response()->json([
                'success' => true,
                'message' => 'Data Eliminada'
            ]
        );
    } 

    public function editar_a1_mision(Request $request)
    {
        $editFam = Fam0001A1Mision::where('id', $request->id)->get();
        return response()->json([
                'success' => true,
                'message' => 'Data',
                'data' => $editFam
            ]
        );
    }

    public function actualizar_a1_mision(Request $request)
    {

        //$dd = $request->except('id');

        $editMision = Fam0001A1Mision::where('id', $request->id)->update($request->except('id'));

        return response()->json([
                'success' => true,
                'message' => 'Data',
                'editMision' => $editMision
            ]
        );
    } 

    
}
