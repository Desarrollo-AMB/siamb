<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Administrador', 
            'username' => 'admin', 
            'email' => 'admin@siamb.test',
            'password' => bcrypt('admin')
        ]);

        $role = Role::create(['name' => 'administrador']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);

        $role = Role::create(['name' => 'comandante_unidad']);
        $role = Role::create(['name' => 'disciplina']);
        $role = Role::create(['name' => 'admindeporte']);
        $role = Role::create(['name' => 'usudeporte']);

    }
}
