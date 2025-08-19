<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Services\RoleService;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @disregard P1013 Undefined method 'user'.intelephense */
        $user = auth()->user();

        if (! $user->hasAnyPermission(['Create Role', 'View Role', 'Update Role', 'Delete Role'])) {
            abort(403);
        }

        return Inertia::render('Roles/Index', [
            'roles' => Role::with('permissions')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('Create Role');

        return Inertia::render('Roles/Create', [
            'permissions' => Permission::pluck('name')->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        Gate::authorize('Create Role');

        $role = $this->roleService->store($request->validated());
        $role->syncPermissions($request->permissions);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        Gate::authorize('View Role');

        return Inertia::render('Roles/Show', [
            'role' => $role,
            'rolePermissions' => $role->permissions()->pluck('name')->all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        Gate::authorize('Update Role');

        return Inertia::render('Roles/Edit', [
            'role' => $role,
            'rolePermissions' => $role->permissions()->pluck('name')->all(),
            'permissions' => Permission::pluck('name')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        Gate::authorize('Update Role');

        $role = $this->roleService->update($role, $request->validated());
        $role->syncPermissions($request->permissions);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        Gate::authorize('Delete Role');

        $this->roleService->delete($role);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
