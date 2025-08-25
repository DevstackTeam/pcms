<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Services\PermissionSeederService;
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

        foreach (PermissionSeederService::permissions() as $module) {
            foreach ($module as $name) {
                Permission::create(['name' => $name]);
            }
        }
        
        $superAdminRole = Role::create(['name' => User::TYPE_SUPER_ADMIN]);
        $superAdminRole->givePermissionTo(PermissionSeederService::super_admin());

        $adminRole = Role::create(['name' => User::TYPE_ADMIN]);
        $adminRole->givePermissionTo(PermissionSeederService::admin());

        $userRole = Role::create(['name' => User::TYPE_USER]);
        $userRole->givePermissionTo(PermissionSeederService::user());

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
        ]);
        
        $superAdmin->assignRole(User::TYPE_SUPER_ADMIN);

        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole(User::TYPE_ADMIN);

        $user = User::create([
            'name' => 'Regular User',
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole(User::TYPE_USER);
    }
}
