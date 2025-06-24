<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManpowerRequest;
use App\Http\Requests\ScenarioRequest;
use App\Models\Designation;
use App\Models\Scenario;
use App\Models\Project;
use App\Services\ScenarioService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScenarioController extends Controller
{
    protected $scenarioService;

    public function __construct(ScenarioService $scenarioService)
    {
        $this->scenarioService = $scenarioService;
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
        $designations = Designation::all();

        return Inertia::render('Scenarios/Create', [
            'project' => $project,
            'designations' => $designations,
        ]);
    }

    public function store(Project $project, ScenarioRequest $scenario_request, ManpowerRequest $mp_request)
    {
        $scenario = $this->scenarioService->store($scenario_request->validated(), $project);

        foreach ($mp_request['manpower'] as $mp) {
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

        return Inertia::render('Scenarios/Show', [
            'project' => $project,
            'scenario' => $scenario,
            'manpowers' => $manpowers,
        ]);
    }

    public function edit(Project $project, Scenario $scenario)
    {
        $designations = Designation::all();
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
        $scenario->update([
            'duration' => $scenario_request['duration'],
            'remark' => $scenario_request['remark'],
            'markup' => $scenario_request['markup'],
            'total_cost' => $scenario_request['total_cost'],
            'final_cost' => $scenario_request['final_cost'],
        ]);

        $scenario->manpowers()->delete();

        foreach ($mp_request['manpower'] as $mp) {
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


