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

    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $projects = $this->projectService->search($search, $status);

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
            'status' => ProjectStatus::cases(),
            'filters' => ['status' => $status, 'search' => $search],
        ]);
    }

    public function create()
    {
        return Inertia::render('Projects/Create', [
            'status' => ProjectStatus::cases(),
        ]);
    }

    public function store(ProjectRequest $request)
    {
        $project = $this->projectService->store($request->validated());

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        return Inertia::render('Projects/Show', [
            'project' => $project
        ]);
    }

    public function edit(Project $project)
    {
        return Inertia::render('Projects/Edit', [
            'project' => $project,
            'status' => ProjectStatus::cases(),
        ]);
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $project = $this->projectService->update($project, $request->validated());

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
