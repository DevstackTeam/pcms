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

    public function index()
    {
        return Inertia::render('Designations', [
            'designations' => Designation::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Designations/Create');
    }

    public function store(DesignationRequest $request)
{

    $designation = $this->designationService->create($request->only('name', 'rate_per_day'));

    // dd($designation);

    return redirect()->route('designations.index', ['designation' => $designation])->with('success', 'Designation created.');
}

    public function edit(Designation $designation)
    {
        return Inertia::render('Designations/Edit', [
            'designation' => $designation
        ]);
    }

    public function update(DesignationRequest $request, Designation $designation)
    {


        $this->designationService->update($designation, $request->only('name', 'rate_per_day'));

        return redirect()->route('designations')->with('success', 'Designation updated.');
    }

    public function destroy(Designation $designation)
    {
        $this->designationService->delete($designation);

        return redirect()->route('designations.index')->with('success', 'Designation deleted.');
    }
}
