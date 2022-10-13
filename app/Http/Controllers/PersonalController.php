<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Empleado;
use App\Models\EmpleadosOtroComponente;
use App\Models\TiposEmpleado;
use App\Models\Estados;

use DataTables;
use Illuminate\Support\Str;
use Config;

class PersonalController extends Controller
{
    
    
    public function ingresoPersonal()
    {
        $user_auth=auth()->user();
      
        $tipos_emp = TiposEmpleado::all();
        $generos = Config::get('constants.sexo');
        $edos_civil = Config::get('constants.edo_civil');
        $estados = Estados::all();
        return view('sireh.personal.ingreso', compact('user_auth','tipos_emp','generos','edos_civil','estados'));
    }


    public function empleadosSinUser(Request $request){
       
        $empleados = Empleado::whereNull('user_id'); 
        $empleados->join('nomina','nomina.codigo_empleado','=','empleados.codigo_empleado');
        $empleados->join('tipos_empleados','tipos_empleados.tipo_emp','=','nomina.tipo_emp');
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','nomina.codigo_ubicacion');
        $empleados->join('cargos','cargos.codigo_cargo','=','nomina.codigo_cargo');
        $empleados->select(
            'empleados.codigo_empleado',
            'empleados.cedula',
            'empleados.nombre1',
            'empleados.nombre2',
            'empleados.apellido1',
            'empleados.apellido2',
            'tipos_empleados.descripcion as tipo_empleado',
            'cargos.nombre_cargo as cargo',
            'ubicaciones.descripcion as ubicacion',
        );
        $datatable= Datatables::of($empleados)
            ->addColumn('actions', 'users._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function notEmpleadosSinUser(Request $request){
       
        $empleados = EmpleadosOtroComponente::whereNull('user_id'); 
        $empleados->join('ubicaciones','ubicaciones.codigo_ubicacion','=','empleados_otro_componente.codigo_ubicacion');
        $empleados->select(
            'empleados_otro_componente.id',
            'empleados_otro_componente.cedula',
            'empleados_otro_componente.nombre1',
            'empleados_otro_componente.nombre2',
            'empleados_otro_componente.apellido1',
            'empleados_otro_componente.apellido2',
            'ubicaciones.descripcion as ubicacion',
        );
        $datatable= Datatables::of($empleados)
            ->addColumn('actions', 'users._actions2')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

}
