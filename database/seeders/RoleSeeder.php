<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Guest' => [
                'access_dashboard',
            ],
            'SuperUsuario' => [
                'access_dashboard',
                'read_users',
                'create_users',
                'edit_users',
                'delete_users',
                'read_roles',
                'create_roles',
                'edit_roles',
                'delete_roles',
            ],
        ];

       foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);
            $role->givePermissionTo($permissions);
        }
    }
}
