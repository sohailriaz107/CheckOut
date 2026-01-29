<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

  

class PermissionTableSeeder extends Seeder
{

    /**

     * Run the database seeds.

     *

     * @return void

     */

    public function run()
    {
        Permission::create(['name' => 'role-list']);
        Permission::create(['name' => 'role-create']);
        Permission::create(['name' => 'role-edit']);
        Permission::create(['name' => 'role-delete']);
        Permission::create(['name' => 'view-profile']);
        Permission::create(['name' => 'edit-profile']);
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);
        Permission::create(['name' => 'view-users']);
        Permission::create(['name' => 'edit-settings']);
        Permission::create(['name' => 'create-merchents']);
        Permission::create(['name' => 'edit-merchents']);
        Permission::create(['name' => 'delete-merchents']);
        Permission::create(['name' => 'view-merchents']);
        Permission::create(['name' => 'view-all-trascations']);
        Permission::create(['name' => 'view-trascations']);

        $adminRole = Role::create(['name' => 'Admin']);
        $merchantRole = Role::create(['name' => 'Merchant']);
        $managerRole = Role::create(['name' => 'Manager']);

        $adminRole->givePermissionTo([
            'role-list',
            'role-create',
            'role-edit', 
            'role-delete',
            'view-profile',
            'edit-profile',
            'create-users',
            'edit-users',
            'delete-users',
            'view-users',
            'edit-settings',
            'create-merchants',
            'edit-merchants',
            'view-merchants',
            'view-all-trascations',
        ]);

        $merchantRole->givePermissionTo([
            'view-profile',
            'edit-profile',
            'view-trascations',
        ]);

        $managerRole->givePermissionTo([
            'view-profile',
            'edit-profile',
            'create-merchants',
            'edit-merchants',
            'view-merchants',
            'view-all-trascations',
        ]);

    }

}