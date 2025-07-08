<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManpowerRequest;
use App\Http\Requests\ScenarioRequest;
use App\Models\Designation;
use App\Models\Scenario;
use App\Models\Project;
use App\Services\ManpowerService;
use App\Services\ScenarioService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScenarioController extends Controller
{
    protected $scenarioService;
    protected $manpowerService;

    public function __construct(ScenarioService $scenarioService, ManpowerService $manpowerService)
    {
        $this->scenarioService = $scenarioService;
        $this->manpowerService = $manpowerService;
    }

    public function index(Project $project)
    {
       $scenarios = $project->scenarios()->latest()->get();

        return Inertia::render('Scenarios/Index', [
            'project' => $project,
            'scenarios' => $scenarios,
        ]);
    }

    public function create(Project $project)
    {
        $designations = Designation::orderBy('name')->get();

        return Inertia::render('Scenarios/Create', [
            'project' => $project,
            'designations' => $designations,
        ]);
    }

    public function store(Project $project, ScenarioRequest $scenario_request, ManpowerRequest $mp_request)
    {
        $scenario = $this->scenarioService->store($scenario_request->validated(), $project);

        $this->manpowerService->storeMany($mp_request->validated()['manpower'], $scenario);

        return redirect()
            ->route('projects.scenarios.index', $project)
            ->with('success', 'Scenario created successfully.');
    }

    public function show(Project $project, Scenario $scenario)
    {
        $manpowers = $scenario->manpowers()->with('designation')->get();

        return Inertia::render('Scenarios/Show', [
            'project' => $project,
            'scenario' => $scenario,
            'manpowers' => $manpowers,
        ]);
    }

    public function edit(Project $project, Scenario $scenario)
    {
        $designations = Designation::orderBy('name')->get();
        $manpowers = $scenario->manpowers()->get();

        return Inertia::render('Scenarios/Edit', [
            'scenario' => $scenario,
            'project' => $project,
            'manpowers' => $manpowers,
            'designations' => $designations,
        ]);
    }

    public function update(
        Project $project,
        Scenario $scenario,
        ScenarioRequest $scenario_request,
        ManpowerRequest $mp_request,
    )
    {
        $scenario = $this->scenarioService->update($scenario_request->validated(), $scenario);

        $scenario->manpowers()->delete();

        $this->manpowerService->storeMany($mp_request->validated()['manpower'], $scenario);

        return redirect()
            ->route('projects.scenarios.index', $project)
            ->with('success', 'Scenario updated.');
    }

    public function destroy(Project $project, Scenario $scenario)
    {
        $this->scenarioService->delete($scenario);

        return redirect()
            ->route('projects.scenarios.index', $project)
            ->with('success', 'Scenario deleted successfully');
    }
}


