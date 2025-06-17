<?php

namespace App\Http\Controllers;

use App\Enums\ProjectStatus;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $projects = $this->projectService->search($search, $status);

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
            'filters' => [
                'status' => $status,
            ],
            'status' => ProjectStatus::cases(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Projects/Create', [
            'status' => ProjectStatus::cases(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        $project = $this->projectService->store($request->validated());

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return Inertia::render('Projects/Show', [
            'project' => $project
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return Inertia::render('Projects/Edit', [
            'project' => $project,
            'status' => ProjectStatus::cases(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $project = $this->projectService->update($project, $request->validated());

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
