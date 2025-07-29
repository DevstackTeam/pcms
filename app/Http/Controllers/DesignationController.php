<?php
namespace App\Http\Controllers;

use App\Http\Requests\DesignationRequest;
use App\Models\Designation;
use App\Services\DesignationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class DesignationController extends Controller
{
    protected DesignationService $designationService;

    public function __construct(DesignationService $designationService)
    {
        $this->designationService = $designationService;
    }

    public function index(Request $request)
    {
        /** @disregard P1013 Undefined method 'user'.intelephense */
        $user = auth()->user();

        if (! $user->hasAnyPermission(['view-designation', 'create-designation', 'edit-designation', 'delete-designation'])) {
            abort(403);
        }

        $search = $request->input('search');

        $designations = $this->designationService->getFilteredDesignations($search);

        return Inertia::render('Designations', [
            'designations' => $designations,
            'filters' => ['search' => $search],
            'flash' => ['success' => session('success')],
        ]);
    }

    public function store(DesignationRequest $request)
    {
        Gate::authorize('create-designation');

        $designation = $this->designationService->store($request->only('name', 'rate_per_day'));

        return redirect()
            ->route('designations.index')
            ->with('success', 'Designation created.');
    }

    public function update(DesignationRequest $request, Designation $designation)
    {
        Gate::authorize('edit-designation');

        $this->designationService->update($designation, $request->only('name', 'rate_per_day'));

        return redirect()->route('designations.index')
            ->with('success', 'Designation updated.');
    }

    public function destroy(Designation $designation)
    {
        Gate::authorize('delete-designation');

        $this->designationService->delete($designation);

        return redirect()->route('designations.index')
            ->with('success', 'Designation deleted.');
    }
}
