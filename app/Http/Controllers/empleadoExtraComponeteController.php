<?php

namespace App\Http\Controllers;

use App\Models\Cargos;
use App\Models\Estados;
use App\Models\Nivel;
use App\Models\Profesion;
use App\Models\TiposEmpleado;
use App\Models\UbicacionDetallada;
use App\Models\Ubicaciones;
use App\Models\Universidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class empleadoExtraComponeteController extends Controller
{
    public function ingresoPersonal()
    {
        $user_auth=auth()->user();

        $tipos_emp = TiposEmpleado::all();
        $nacionalidades = Config::get('constants.nacionalidad');
        $generos = Config::get('constants.sexo');
        $edos_civil = Config::get('constants.edo_civil');
        $estados = Estados::all();
        $ubicaciones = Ubicaciones::all();
        $ubicaciones_det = UbicacionDetallada::all();
        $niveles = Nivel::all();
        $cargos = Cargos::all();
        $universidades = Universidades::all();
        $profesiones = Profesion::all();

        return view('extra_component.ingreso',
            compact(
                'user_auth', 'tipos_emp', 'generos', 'edos_civil',
                'estados', 'ubicaciones', 'ubicaciones_det', 'niveles',
                'cargos', 'nacionalidades', 'universidades', 'profesiones'
            )
        );
    }


    public function registraPersonal(Request $request){

        $this->validate($request,
            [
                'tipo_emp' => 'required',
                'cedula' => 'required|unique:empleados,cedula',
                'nombre1' => 'required',
                'apellido1' => 'required',
                'ubicacion' => 'required',
            ],
            [
                'tipo_emp.required' => 'Tipo de empleado es requerido',
                'nombre1.required' => 'El primer nombre es requerido',
                'apellido1.required' => 'El primer apellido es requerido'
            ]
        );
        try {
            $codigo_empleado = Empleado::max('codigo_empleado')+1;
            if ($request->file("foto")){
                $ext = $request->file('foto')->getClientOriginalExtension();
                $file_name = 'empleado_'. $request->cedula . '.' . $ext;

                $path_foto = 'fotos/empleados/' . $file_name;
                if(file_exists($path_foto)){
                    unlink($path_foto); // Eliminamos la imagen previa si existe.
                }
                Image::make($request->file('foto'))->save( public_path($path_foto));
            }else{
                $path_foto = null;
            }

            $empleado = new Empleado;
            $empleado->codigo_empleado = $codigo_empleado;
        


            return redirect()->route('extra.ingreso_personal')->with('success', 'Se ha ingresado al Personal');
        } catch (Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }
}
