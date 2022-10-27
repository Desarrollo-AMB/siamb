<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\Empleado;
use App\Models\EmpleadosOtroComponente;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $data = User::with(['empleado','notempleado'])->orderBy('name','ASC')->get();//->paginate(2);
        return view('users.index',compact('data'));
            //->with('i', ($request->input('page', 1) - 1) * 10);
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $codigo_empleado = $request->codigo_empleado;
        $componente_aviacion = $request->componente_aviacion;
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->except(['codigo_empleado']);
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        // $user->assignRole($request->input('roles'));
        $user->roles()->sync($request->input('roles'));
        if ($codigo_empleado){
            if($componente_aviacion==1){
                $empleado = Empleado::where('codigo_empleado', $codigo_empleado)->first();
                $empleado->user_id = $user->id;
                $empleado->update();
            }else{
                $notempleado = EmpleadosOtroComponente::where('id', $codigo_empleado)->first();
                $notempleado->user_id = $user->id;
                $notempleado->update();
            }
        }
        return redirect()->route('users.index')
            ->with('success','Usuario creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with(['empleado'])->find($id);
        $roles = Role::all();
        $userRole =$user->roles->pluck('id','id')->all() ;
        //dd($roles,$userRole);
        return view('users.edit',compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request->input('roles'));
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
 
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->roles()->sync($request->input('roles'));
        //assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success','Usuario actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            User::find($id)->delete();
            Empleado::where('user_id',$id)->update(['user_id'=>null]);
            EmpleadosOtroComponente::where('user_id',$id)->update(['user_id'=>null]);
            return redirect()->route('users.index')
                ->with('success','Usuario eliminado satisfactoriamente');
        }catch (\Exception $e) {
            Log::error("************************* ERROR ************************* \n" . $e);
            return response()->json(['error' => $e->getMessage()], 500, ['X-Header-One' => 'Header Value']);
        }
    }
}