<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Scenario;
use App\Models\Designation;
use App\Services\ScenarioService;
use App\Http\Requests\ScenarioRequest;
use Inertia\Inertia;

class ScenarioController extends Controller
{
    protected ScenarioService $scenarioService;

    public function __construct(ScenarioService $scenarioService)
    {
        $this->scenarioService = $scenarioService;
    }

    public function index(Project $project)
    {
        $scenarios = Scenario::with('project')->latest()->get();

        return Inertia::render('Scenarios/Index', [
            'project' => $project,
            'scenarios' => $scenarios,
        ]);
    }

    public function show( Project $project, Scenario $scenario)
    {
        return Inertia::render('Scenarios/Show', [
            'scenario' => $scenario,
            'project' => $project,
        ]);
    }

    public function destroy(Project $project, Scenario $scenario)
{
    $scenario->delete();

    return redirect()
        ->route('projects.scenarios.index', $project->id)
        ->with('success', 'Scenario deleted.');
}

    public function create(Project $project)
    {
        return Inertia::render('Scenarios/Create', [
            'project' => $project,
            'projectId' => $project->id,
            'designations' => Designation::select('id', 'name', 'rate_per_day')->get(),
        ]);
    }

    public function store(ScenarioRequest $request, Project $project)
    {
        $data = $request->validated();
        $data['project_id'] = $project->id;

        $scenario = $this->scenarioService->store($data);

        return redirect()->route('projects.scenarios.index', $project->id)
                        ->with('success', 'Scenario created successfully.');
    }

    public function edit(Project $project, Scenario $scenario)
    {
        return Inertia::render('Scenarios/Edit', [
            'project' => $project,
            'scenario' => $scenario,
            'projects' => Project::select('id', 'name')->get(),
            'designations' => Designation::select('id', 'name', 'rate_per_day')->get(),
        ]);
    }

    public function update(ScenarioRequest $request, Project $project, Scenario $scenario)
    {
        $scenario->update($request->validated());

        return redirect()
            ->route('projects.scenarios.index', $project->id)
            ->with('success', 'Scenario updated successfully.');
    }
}
