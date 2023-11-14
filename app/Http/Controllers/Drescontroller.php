<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Drescontroller extends Controller
{
    public function index(){
        return view('dress.create');
    }


    public function armamento() {
        // Lógica para cargar los datos y devolver una vista parcial o JSON, según tus necesidades
        // Por ejemplo:
        return view('dress.armamento'); // Carga la vista "armamento.blade.php"
    }
}
