<?php

namespace App\Http\Controllers\Nomina;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NominaController extends Controller
{
    public function indexNomina()
    {
        return view('sireh.nomina.index');
    }

    public function militarNomina()
    {
        return view('sireh.nomina.militar');
    }

}

