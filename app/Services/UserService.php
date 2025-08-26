<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function store(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);

        $user->syncRoles($data['roles']);

        return $user;
    }

    public function update(User $user, array $data): User
    {
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = bcrypt($data['password']);
        }

        $user->update($updateData);

        $user->syncRoles($data['roles']);

        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
