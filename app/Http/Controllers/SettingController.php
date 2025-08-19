<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\SettingService;
use App\Http\Requests\UpdateEmailRequest;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Validation\ValidationException;


class SettingController extends Controller
{
    protected SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

public function index()
{
    /** @disregard P1013 Undefined method 'user'.intelephense */
    $user = auth()->user()->load('roles'); // 'roles' must be a relationship

    return Inertia::render('Settings', [
        'user' => $user
    ]);
}

public function updateEmail(UpdateEmailRequest $request)
{
    $request->user()->update([
        'email' => $request->email,
    ]);

    return back()->with('success', 'Email updated.');
}

public function changePassword(UpdatePasswordRequest $request)
{
    $user = $request->user();

    if (!Hash::check($request->current_password, $user->password)) {
        throw ValidationException::withMessages([
            'current_password' => ['The current password is incorrect.'],
        ]);
    }

    $user->update([
        'password' => Hash::make($request->password),
    ]);

    return back()->with('success', 'Password changed.');
}

}
