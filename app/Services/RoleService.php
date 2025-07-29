<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleService
{
    public function store(array $data): Role
    {
        return Role::create(['name' => $data['name']]);
    }

    public function update(Role $role, array $data): Role
    {
        $role->update(['name' => $data['name']]);

        return $role;
    }

    public function delete(Role $role): void
    {
        $role->delete();
    }
}
