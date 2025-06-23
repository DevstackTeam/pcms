<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Scenario;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScenarioController extends Controller
{
    public function index(Project $project)
    {
       $scenarios = $project->scenarios()->latest()->get();

        return Inertia::render('Scenario/Index', [
            'project' => $project,
            'scenarios' => $scenarios,
        ]);
    }

    public function create(Project $project)
    {
        $designations = Designation::all();

        return Inertia::render('Scenario/Create', [
            'project' => $project,
            'designations' => $designations,
        ]);
    }

    public function store(Project $project, Request $request)
    {
        $validated = $request->validate([
            'duration' => 'required|numeric',
            'remark' => 'nullable|string',
            'markup' => 'required|numeric',
            'total_cost' => 'required|numeric',
            'final_cost' => 'required|numeric',

            'manpower' => 'required|array',
            'manpower.*.designation_id' => 'required|exists:designations,id',
            'manpower.*.rate_per_day' => 'required|numeric',
            'manpower.*.no_of_people' => 'required|integer',
            'manpower.*.total_day' => 'required|integer',
            'manpower.*.total_cost' => 'required|numeric',
        ]);

        $scenario = $project->scenarios()->create([
            'duration' => $validated['duration'],
            'remark' => $validated['remark'],
            'markup' => $validated['markup'],
            'total_cost' => $validated['total_cost'],
            'final_cost' => $validated['final_cost'],
        ]);

        foreach ($validated['manpower'] as $mp) {
            $scenario->manpowers()->create([
                'designation_id' => $mp['designation_id'],
                'rate_per_day' => $mp['rate_per_day'],
                'no_of_people' => $mp['no_of_people'],
                'total_day' => $mp['total_day'],
                'total_cost' => $mp['total_cost'],
            ]);
        }

        return redirect()
            ->route('projects.scenarios.index', $project)
            ->with('success', 'Scenario created successfully.');
    }

    public function show(Project $project, Scenario $scenario)
    {
        $manpowers = $scenario->manpowers()->with('designation')->get();

        return Inertia::render('Scenario/Show', [
            'project' => $project,
            'scenario' => $scenario,
            'manpowers' => $manpowers,
        ]);
    }

    public function edit(Project $project, Scenario $scenario)
    {
        $designations = Designation::all();
        $manpowers = $scenario->manpowers()->get();

        return Inertia::render('Scenario/Edit', [
            'scenario' => $scenario,
            'project' => $project,
            'manpowers' => $manpowers,
            'designations' => $designations,
        ]);
    }

    public function update(Project $project, Request $request, Scenario $scenario)
    {
        $validated = $request->validate([
            'markup' => 'required|numeric',
            'duration' => 'required|string',
            'remark' => 'nullable|string',
            'total_cost' => 'required',
            'final_cost' => 'required',

            'manpower' => 'required|array',
            'manpower.*.designation_id' => 'required|exists:designations,id',
            'manpower.*.rate_per_day' => 'required|numeric',
            'manpower.*.no_of_people' => 'required|integer',
            'manpower.*.total_day' => 'required|integer',
            'manpower.*.total_cost' => 'required|numeric',
        ]);

        $scenario->update([
            'duration' => $validated['duration'],
            'remark' => $validated['remark'],
            'markup' => $validated['markup'],
            'total_cost' => $validated['total_cost'],
            'final_cost' => $validated['final_cost'],
        ]);

        $scenario->manpowers()->delete();

        foreach ($validated['manpower'] as $mp) {
            $scenario->manpowers()->create([
                'designation_id' => $mp['designation_id'],
                'rate_per_day' => $mp['rate_per_day'],
                'no_of_people' => $mp['no_of_people'],
                'total_day' => $mp['total_day'],
                'total_cost' => $mp['total_cost'],
            ]);
        }

        return redirect()
            ->route('projects.scenarios.index', $project)
            ->with('success', 'Scenario updated.');
    }

    public function destroy(Project $project, Scenario $scenario)
    {
        $scenario->delete();
    
        return redirect()
            ->route('projects.scenarios.index', $project)
            ->with('success', 'Scenario deleted successfully');
    }
}


