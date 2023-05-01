<?php

namespace App\Http\Controllers;

use App\Models\ConceptosNomina;
use App\Models\User;
use Illuminate\Http\Request;

class NominaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

//Ver nomina
    public function primas(Request $request)
    {
        $data = ConceptosNomina::
            select('*',)
            ->where ('tipo', 'A')
            ->get();
      //dd($data);
        return view('sireh.nomina.primas',compact('data'));
    }

//Editar prima
    public function edit(Request $request)
    {
        $data = ConceptosNomina::
            select('*',)
            ->where ('tipo', 'A')
            ->get();
      //dd($data);
        return view('sireh.nomina.prima-edit',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

//Nueva prima
    public function nueva(Request $request)
    {

        return view('sireh.nomina.nueva-prima');


    }


}