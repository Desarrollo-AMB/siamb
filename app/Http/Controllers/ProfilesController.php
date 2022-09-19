<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfilesController extends Controller
{
    
    public function show()
    {
        $user_id=auth()->user()->id;
        $user = User::find($user_id);
        $profile = Profile::where('user_id',$user_id)->first();
        return view('users.profile', compact('profile', 'user'));
    }

    public function updateProfile(User $user, Request $request){
        $profile = Profile::where('user_id',$user->id)->first();
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
                'cedula' => [
                        'required',
                        'digits_between:3,8',
                        'unique:profiles,cedula,'.$profile->id,
                ],
                'nombres' => 'alpha',
                'apellidos' => 'alpha',
                'telefono' => 'digits_between:8,15',
            ]);
        }else{
            $validator = Validator::make($request->all(),[
                'foto' => [
                    'required',
                    'image',
                    'mimes:jpeg,png,jpg,gif,svg',
                    'max:4096'
                ],
                'cedula' => [
                        'required',
                        'digits_between:3,8',
                        'unique:profiles,cedula',
                ],
                'nombres' => 'alpha',
                'apellidos' => 'alpha',
                'telefono' => 'digits_between:8,15',
            ]);
        }
        
        if ($validator->fails()) 
        {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        if ($request->file("foto")){
            $file = $request->file("foto")->store("uploads/avatars");
        }else{
            $file = null;
        }
        
        $profile = Profile::updateOrCreate([
            'user_id' => $user->id,
        ], [
            'foto' => $file ? $file : $profile->foto ,
            'cedula' => $request->cedula,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'telefono' => $request->telefono
        ]);
        return back()
            ->with('success','El Perfil ha sido actualizado satisfactoriamente.');

    }
}
