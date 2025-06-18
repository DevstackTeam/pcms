<?php

namespace App\Http\Controllers;

use App\Models\Scenario;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScenarioController extends Controller
{
    public function index()
    {
        $scenarios = Scenario::with('project')->get(); 

        return Inertia::render('Scenario/Index', [
            'scenarios' => $scenarios,
        ]);
    }

   public function projectScenarios(Project $project)
{
    $scenarios = $project->scenarios()->with('project')->latest()->get(); // No 'manpowers'

    return Inertia::render('Scenario/Index', [
        'project' => $project,
        'scenarios' => $scenarios,
    ]);
}


    public function create()
    {
        $projects = Project::select('id', 'name')->get();

        return Inertia::render('Scenario/Create', [
            'projects' => $projects,
        ]);
    }

    public function store(Request $request)
    {
        // You'll likely expand this later with manpower saving
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'markup' => 'required|numeric',
            'duration' => 'required|string',
            'remark' => 'nullable|string',
        ]);

        $scenario = Scenario::create([
            'project_id' => $request->project_id,
            'markup' => $request->markup,
            'duration' => $request->duration,
            'remark' => $request->remark,
            'total_cost' => 0, // will update after adding manpower
            'final_cost' => 0,
        ]);

        return redirect()->route('scenarios.index')->with('success', 'Scenario created successfully.');
    }

    public function show(Scenario $scenario)
    {
        return Inertia::render('Scenario/Show', [
            'scenario' => $scenario->load('project',),
        ]);
    }

    public function edit(Scenario $scenario)
    {
        $projects = Project::select('id', 'name')->get();

        return Inertia::render('Scenario/Edit', [
            'scenario' => $scenario,
            'projects' => $projects,
        ]);
    }

    public function update(Request $request, Scenario $scenario)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'markup' => 'required|numeric',
            'duration' => 'required|string',
            'remark' => 'nullable|string',
        ]);

        $scenario->update($request->only('project_id', 'markup', 'duration', 'remark'));

        return redirect()->route('scenarios.index')->with('success', 'Scenario updated.');
    }

    public function destroy(Scenario $scenario)
    {
        $scenario->delete();

        return redirect()->route('scenarios.index')->with('success', 'Scenario deleted.');
    }
}
