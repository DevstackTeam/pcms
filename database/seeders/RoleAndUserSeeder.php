<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view-designation',
            'create-designation',
            'edit-designation',
            'delete-designation',
            'view-project',
            'create-project',
            'edit-project',
            'delete-project',
            'view-scenario',
            'create-scenario',
            'edit-scenario',
            'delete-scenario',
            'view-manpower',
            'create-manpower',
            'delete-manpower',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create admin role and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($permissions);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo(['view-designation', 'view-project', 'view-scenario', 'view-manpower']);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Create regular user
        $user = User::create([
            'name' => 'Regular User',
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('user');
    }
}
