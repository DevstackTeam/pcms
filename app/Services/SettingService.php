<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SettingService
{
    public function updateEmail(User $user, array $data): void
    {
        $user->update([
            'email' => $data['email'],
        ]);
    }

    public function updatePassword(User $user, array $data): bool
    {
        if (!Hash::check($data['current_password'], (string) $user->password)) {
            return false;
        }

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return true;
    }
}
