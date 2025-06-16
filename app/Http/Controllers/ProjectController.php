<?php

// app/Http/Controllers/ProjectController.php

namespace App\Http\Controllers;

use App\Models\Project;
use Inertia\Inertia;

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
        return Inertia::render('Project/Create');
    }

    public function edit(Project $project)
    {
        return Inertia::render('Project/Edit', [
            'project' => $project
        ]);
    }
}
