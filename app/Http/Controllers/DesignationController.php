<?php
namespace App\Http\Controllers;

use App\Http\Requests\DesignationRequest;
use App\Models\Designation;
use App\Services\DesignationService;
use Illuminate\Http\Request;
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
        $designation = $this->designationService->store($request->only('name', 'rate_per_day'));

        return redirect()
            ->route('designations.index')
            ->with('success', 'Designation created.');
    }

    public function update(DesignationRequest $request, Designation $designation)
    {
        $this->designationService->update($designation, $request->only('name', 'rate_per_day'));

        return redirect()->route('designations.index')
            ->with('success', 'Designation updated.');
    }

    public function destroy(Designation $designation)
    {
        $this->designationService->delete($designation);

        return redirect()->route('designations.index')
            ->with('success', 'Designation deleted.');
    }
}
