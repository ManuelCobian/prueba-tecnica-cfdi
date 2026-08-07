<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'access_dashboard',
            'read_users',
            'create_users',
            'edit_users',
            'delete_users',
            'read_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
