<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @disregard P1013 Undefined method 'user'.intelephense */
        $user = auth()->user();

        if (! $user->hasAnyPermission(['view-user', 'create-user', 'edit-user', 'delete-user'])) {
            abort(403);
        }

        return Inertia::render('Users/Index', [
            'users' => User::with('roles')->get() 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create-user');

        return Inertia::render('Users/Create', [
            'roles' => Role::pluck('name')->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        Gate::authorize('create-user');

        $user = $this->userService->store($request->validated());

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('view-user');

        return Inertia::render('Users/Show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('edit-user');

        return Inertia::render('Users/Edit', [
            'user' => $user,
            'userRoles' => $user->roles()->pluck('name')->all(),
            'roles' => Role::pluck('name')->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        Gate::authorize('edit-user');

        $user = $this->userService->update($user, $request->validated());

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete-user');

        $this->userService->delete($user);

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
