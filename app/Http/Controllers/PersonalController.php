<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Empleado;
use DataTables;

class PersonalController extends Controller
{
    
    
    public function ingresoPersonal()
    {
        $user_id=auth()->user()->id;
        $user = User::find($user_id);
        
        return view('sireh.personal.ingreso', compact('user'));
    }


    public function empleadosSinUser(Request $request){
        //dd($request->query());
        $start=$request->query()['start'];
        $length=$request->query()['length'];
        $count_empleados = Empleado::with(['nomina', 'nomina.cargo','nomina.ubicacion','nomina.tipo_empleado'])
        ->whereNull('user_id')
        ->count();
        $empleados = Empleado::with(['nomina', 'nomina.cargo','nomina.ubicacion','nomina.tipo_empleado'])
        ->whereNull('user_id')
        ->offset($start)->limit($length+$start)
        ->get();

        return Datatables::of($empleados)
            ->addColumn('actions', 'users._actions')
            ->rawColumns(['actions'])
            ->setTotalRecords($count_empleados)
            ->toJson();
    }

}
