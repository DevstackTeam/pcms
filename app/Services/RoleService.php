<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleService
{
    public function store(array $data): Role
    {
        $role = Role::create(['name' => $data['name']]);

        $role->syncPermissions($data['permissions']);

        return $role;
    }

    public function update(Role $role, array $data): Role
    {
        $role->update(['name' => $data['name']]);

        $role->syncPermissions($data['permissions']);

        return $role;
    }

    public function delete(Role $role): void
    {
        $role->delete();
    }
}
