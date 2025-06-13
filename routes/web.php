<?php

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DesignationController;

Route::get('/', function (Request $request) {
    return Inertia::render('Home', [
        'users' => User::when($request->search, function ($query) use ($request) {
            return $query
                ->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        })->paginate(10)->withQueryString(),

        'searchTerm' => $request->search,
    ]);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::resource('designations', DesignationController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    // Protected API routes

});
