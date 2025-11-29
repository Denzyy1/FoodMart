<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run role and permission seeder first
        $this->call([
            RolePermissionSeeder::class,
            CategorySeeder::class,
        ]);

        // Create Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@foodmart.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
            ]
        );
        $superAdmin->assignRole('superadmin');

        // Create Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@foodmart.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->assignRole('admin');

        // Create regular User
        $user = User::firstOrCreate(
            ['email' => 'user@foodmart.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password123'),
            ]
        );
        $user->assignRole('user');
    }
}
