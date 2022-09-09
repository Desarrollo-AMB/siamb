<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use Illuminate\Support\Facades\File;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
        ];
 
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }*/
        app()['cache']->forget('spatie.permission.cache');

        $permissionsToCreate = [];

        $json = File::get("database/data/permissions.json");
        $permissions = json_decode($json);
        foreach ($permissions as $permission) {
            foreach ($permission->labels as $label) {
                $permissionsToCreate[] = [
                    'name'       => $label->name,
                    'route_name' => $label->route_name,
                    'group'      => $permission->group,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Permission::insert($permissionsToCreate);
    }
}
