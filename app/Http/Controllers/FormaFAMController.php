<?php

namespace App\Http\Controllers;
use App\Models\AeronaveUnidades;
use App\Models\AeronaveModelo;
use App\Models\AeronaveMatricula;
use App\Models\ComponenteOrganismo;

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
        return view('forms.index', compact('aeronaveModelos','matriculas','unidad','componentes'));
    }
    // public function matriculas(Request $request)
    // {
    //     $matriculas = AeronaveMatricula::where('aeronave_id', $request->id)->get();
    //     dd($matriculas);
    //     return response()->json($matriculas);
    // }
}
