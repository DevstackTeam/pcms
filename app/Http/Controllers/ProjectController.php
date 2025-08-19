<?php

namespace App\Http\Controllers;

use App\Enums\ProjectStatus;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
        /** @disregard P1013 Undefined method 'user'.intelephense */
        $user = auth()->user();

        if (! $user->hasAnyPermission(['Create Project', 'View Project', 'Update Project', 'Delete Project'])) {
            abort(403);
        }

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
        Gate::authorize('Create Project');

        return Inertia::render('Projects/Create', [
            'status' => ProjectStatus::cases(),
        ]);
    }

    public function store(ProjectRequest $request)
    {
        Gate::authorize('Create Project');

        $project = $this->projectService->store($request->validated());

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        Gate::authorize('View Project');

        return Inertia::render('Projects/Show', [
            'project' => $project
        ]);
    }

    public function edit(Project $project)
    {
        Gate::authorize('Update Project');

        return Inertia::render('Projects/Edit', [
            'project' => $project,
            'status' => ProjectStatus::cases(),
        ]);
    }

    public function update(ProjectRequest $request, Project $project)
    {
        Gate::authorize('Update Project');

        $project = $this->projectService->update($project, $request->validated());

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        Gate::authorize('Delete Project');

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
