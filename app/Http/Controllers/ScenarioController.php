<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Project;
use App\Models\Scenario;
use App\Models\Designation;
use App\Services\ScenarioService;
use App\Http\Requests\ScenarioRequest;

class ScenarioController extends Controller
{
    protected ScenarioService $scenarioService;

    public function __construct(ScenarioService $scenarioService)
    {
        $this->scenarioService = $scenarioService;
    }

    public function index()
    {
        $scenarios = Scenario::with('project')->latest()->get();

        return Inertia::render('Scenarios/Index', [
            'scenarios' => $scenarios,
        ]);
    }

    public function projectScenarios(Project $project)
    {
        $scenarios = $project->scenarios()->with('project')->latest()->get();

        return Inertia::render('Scenarios/Index', [
            'project' => $project,
            'scenarios' => $scenarios,
        ]);
    }

    public function create(Project $project)
    {
        return Inertia::render('Scenarios/Create', [
            'projectId' => $project->id,
            'designations' => Designation::select('id', 'name', 'rate_per_day')->get(),
        ]);
    }

    public function store(ScenarioRequest $request)
    {
        $scenario = $this->scenarioService->store($request->validated());

        return redirect()
            ->route('scenarios.index')
            ->with('success', 'Scenario created successfully.');
    }

    public function show(Scenario $scenario)
    {
        $scenario->load('project', 'manpowers');

        return Inertia::render('Scenarios/Show', [
            'scenario' => $scenario,
        ]);
    }

    public function edit(Scenario $scenario)
    {
        $projects = Project::select('id', 'name')->get();

        return Inertia::render('Scenarios/Edit', [
            'scenario' => $scenario,
            'projects' => $projects,
        ]);
    }

    public function update(ScenarioRequest $request, Scenario $scenario)
    {
        $scenario->update($request->validated());

        return redirect()
            ->route('scenarios.index')
            ->with('success', 'Scenario updated successfully.');
    }

    public function destroy(Scenario $scenario)
    {
        $scenario->delete();

        return redirect()
            ->route('scenarios.index')
            ->with('success', 'Scenario deleted.');
    }
}
