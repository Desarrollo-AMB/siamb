<?php

namespace App\Http\Controllers;
use App\Models\AeronaveUnidades;
use App\Models\AeronaveModelo;
use App\Models\AeronaveMatricula;
use App\Models\ComponenteOrganismo;
use App\Models\Base;

use Illuminate\Http\Request;

class FormaFAMController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $aeronaveModelos = AeronaveModelo::get();
        $matriculas = AeronaveMatricula::get();
        $unidad = AeronaveUnidades::get();
        $componentes = ComponenteOrganismo::get();
        $bases = Base::get();
        return view('forms.index', compact('aeronaveModelos','matriculas','unidad','componentes', 'bases'));
    }

    public function matriculas(Request $request)
    {
        $id = AeronaveMatricula::where('aeronave_id', $request->id)->get();
        return response()->json($id);
    }
}
