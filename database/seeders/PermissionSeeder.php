<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'create_tasks',
            'edit_tasks',
            'delete_tasks',
            'view_tasks',
            'manage_users',
            'view_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


        $adminRole = Role::where('name', 'admin')->first();
        $editorRole = Role::where('name', 'editor')->first();
        $viewerRole = Role::where('name', 'viewer')->first();

        $adminPermissions = Permission::all();

        $adminRole->permissions()->sync($adminPermissions->pluck('id'));


        $editorPermissions = Permission::whereIn('name', ['create_tasks', 'edit_tasks', 'view_tasks'])->get();
        $editorRole->permissions()->sync($editorPermissions->pluck('id'));

  
        $viewerPermissions = Permission::where('name', 'view_tasks')->get();
        $viewerRole->permissions()->sync($viewerPermissions->pluck('id'));
    }
}