<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PersonalController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    public function ingresoPersonal()
    {
        $user_id=auth()->user()->id;
        $user = User::find($user_id);
        
        return view('sireh.personal.ingreso', compact('user'));
    }

}
