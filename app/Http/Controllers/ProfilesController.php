<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Empleado;
use App\Models\Profile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfilesController extends Controller
{
    
    public function show()
    {
        $user_id=auth()->user()->id;
        $user = User::find($user_id);
        $profile = Empleado::where('user_id',$user_id)->first();
        if (!$profile){
            //$profile = Profile::where('user_id',$user_id)->first();
            return back()
            ->with('warning','No puede actualizar perfil.');
            /*return redirect()->route('dashboard')
            ->with('warning','Este usuario no se puede actualizar perfil.');*/
        }
        return view('users.profile', compact('profile', 'user'));
    }

    public function updateProfile(User $user, Request $request){
        $profile = Empleado::where('user_id',$user->id)->first();
        if ($profile){
            $validator = Validator::make($request->all(),[
                'foto' => [
                        Rule::requiredIf(function () use ($profile) {
                        if ($profile){
                            return $profile->foto ? false : true;
                        }
                        return true;
                    }),
                    'image',
                    'mimes:jpeg,png,jpg,gif,svg',
                    'max:4096'
                ],
                'nombre1' => 'alpha',
                'nombre2' => 'alpha',
                'apellido1' => 'alpha',
                'apellido2' => 'alpha',
                'telefono' => 'digits_between:8,15',
            ]);
            if ($validator->fails()) 
            {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }
            if ($request->file("foto")){
                $file = $request->file("foto")->store("uploads/avatars");
            }else{
                $file = null;
            }
            
            $profile = Empleado::where( 'user_id',$user->id)->update([
                'foto' => $file ? $file : $profile->foto ,
                'nombre1' => $request->nombre1,
                'nombre2' => $request->nombre1,
                'apellido1' => $request->apellido1,
                'apellido2' => $request->apellido1,
                'telefono' => $request->telefono
            ]);
            return back()
                ->with('success','El Perfil ha sido actualizado satisfactoriamente.');

        }else{
            /*$validator = Validator::make($request->all(),[
                'foto' => [
                    'required',
                    'image',
                    'mimes:jpeg,png,jpg,gif,svg',
                    'max:4096'
                ],
                'nombre1' => 'alpha',
                'nombre2' => 'alpha',
                'apellido1' => 'alpha',
                'apellido2' => 'alpha',
                'telefono' => 'digits_between:8,15',
            ]);*/
            return back()
            ->with('warning','Este usuario no se puede actualizar perfil.');
        }
        
        
    }
}
