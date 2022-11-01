<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:Listar Roles|Crear Roles|Editar Roles|Eliminar Roles', ['only' => ['index','store']]);
        $this->middleware('permission:Crear Roles|Almacenar Roles', ['only' => ['create','store']]);
        $this->middleware('permission:Editar Roles|Actualizar Roles', ['only' => ['edit','update']]);
        $this->middleware('permission:Eliminar Roles', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('name','ASC')->get(); //->paginate(10);
        return view('roles.index',compact('roles'));
            //->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        $permissionsGrouped = Permission::orderBy('group')->get()
            ->groupBy('group');

        $guard_names=config('constants.guard_names');
        return view('roles.create',compact('permissionsGrouped','guard_names'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            //'name' => 'required|alpha_dash|unique:roles,name',
            'name' => [
                'required',
                'alpha_dash',
                Rule::unique('roles')->where(function ($query) use($request) {
                    return $query->where('name', $request->input('name'))
                    ->where('guard_name', $request->input('guard_name'))
                    ;
                }),
            ]
            //'permission' => 'required',
        ]);

        $role = Role::create([
            'name' => strtolower($request->input('name')),
            'guard_name' => strtolower($request->input('guard_name')),
        ]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success','Rol creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
        $permissionsGrouped = Permission::orderBy('group','ASC')->get()
            ->groupBy('group');
        $guard_names=config('constants.guard_names');
        return view('roles.show',compact('role','rolePermissions','guard_names'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $permissionsGrouped = Permission::orderBy('group','ASC')->get()
            ->groupBy('group');
        $permissionsGrouped=collect($permissionsGrouped)->sortBy(function($item, $key) {
            return count($item);
        });

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        $guard_names=config('constants.guard_names');
        return view('roles.edit',compact('role','permissionsGrouped','rolePermissions','guard_names'));
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

        $this->validate($request, [
            //'name' => 'required|alpha_dash|unique:roles,name,'.$id,
            //'permission' => 'required',
            'name' => [
                'required',
                'alpha_dash',
                Rule::unique('roles')->where(function ($query) use($request, $id) {
                    return $query->where('name', $request->input('name'))
                    ->where('guard_name', $request->input('guard_name'))
                    ->whereNotIn('id', [$id]);
                }),
            ],
        ]);

        $role = Role::find($id);
        $role->name = strtolower($request->input('name'));
        $role->guard_name = $request->input('guard_name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success','Rol actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
            ->with('success','Rol eliminado con éxito');
    }
}
