<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'create_account']);
        Permission::create(['name' => 'login']);
        Permission::create(['name' => 'reset_password']);
        Permission::create(['name' => 'edit_account']);
        Permission::create(['name' => 'create_plant']);
        Permission::create(['name' => 'edit_plant']);
        Permission::create(['name' => 'delete_plant']);
        Permission::create(['name' => 'view_plants']);
        Permission::create(['name' => 'edit_categories']);
        Permission::create(['name' => 'delete_categories']);
        Permission::create(['name' => 'edit_roles']);
        Permission::create(['name' => 'delete_roles']);

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(permission::all());

        $sellerRole = Role::create(['name' => 'seller']);
        $sellerRole->givePermissionTo(['create_plant', 'edit_plant', 'delete_plant']);

        $customerRole = Role::create(['name' => 'customer']);
        $customerRole->givePermissionTo(['view_plants', 'create_account', 'login', 'reset_password', 'edit_account']);

           
        
    }
}
