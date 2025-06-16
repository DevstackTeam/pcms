<?php

// app/Http/Controllers/ProjectController.php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Project;
use App\Enums\ProjectStatusEnum;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Project/Index', [
            'projects' => Project::paginate(10)
        ]);
    }

    public function create()
    {
        return Inertia::render('Project/Create', [
            'statusOptions' => ProjectStatusEnum::toLabels()
        ]);
    }

    public function edit(Project $project)
    {
        return Inertia::render('Project/Edit', [
            'project' => $project
        ]);
    }
    public function show(Project $project)
{
    return Inertia::render('Project/View', [
        'project' => $project,
    ]);
}
}
