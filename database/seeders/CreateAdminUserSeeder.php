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

        $pilotos = User::create([
            'name' => 'Piloto', 
            'username' => 'piloto', 
            'email' => 'piloto@siamb.test',
            'password' => bcrypt('123')
        ]);

        $pilotos = User::create([
            'name' => 'Piloto 2', 
            'username' => 'piloto2', 
            'email' => 'piloto2@siamb.test',
            'password' => bcrypt('123')
        ]);

        $pilotos = User::create([
            'name' => 'Piloto 3', 
            'username' => 'piloto3', 
            'email' => 'piloto3@siamb.test',
            'password' => bcrypt('123')
        ]);

        $role = Role::create(['name' => 'administrador', 'guard_name'=>'web']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);

        $role = Role::create(['name' => 'aviacion', 'guard_name'=>'siamb']);

        $role = Role::create(['name' => 'comandante_unidad', 'guard_name'=>'seid']);
        $role = Role::create(['name' => 'disciplina', 'guard_name'=>'seid']);
        $role = Role::create(['name' => 'admindeporte', 'guard_name'=>'seid']);
        $role = Role::create(['name' => 'usudeporte', 'guard_name'=>'seid']);
        $role = Role::create(['name' => 'usuario', 'guard_name'=>'avianet']);
        $role = Role::create(['name' => 'nomina', 'guard_name'=>'avianet']);
        $role = Role::create(['name' => 'usuario', 'guard_name'=>'educacion']);

    }
}
