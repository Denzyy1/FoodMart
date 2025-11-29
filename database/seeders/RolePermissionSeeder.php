<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Product permissions
            'view products',
            'create products',
            'edit products',
            'delete products',
            
            // User management permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            'assign roles',
            
            // Category permissions
            'manage categories',
            
            // Order permissions
            'view orders',
            'manage orders',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // User role - basic browsing
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->syncPermissions(['view products']);

        // Admin role - manage products
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions([
            'view products',
            'create products',
            'edit products',
            'delete products',
            'manage categories',
            'view orders',
            'manage orders',
        ]);

        // Super Admin role - full access
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $superAdminRole->syncPermissions(Permission::all());
    }
}
