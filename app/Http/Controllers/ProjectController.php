<?php

// app/Http/Controllers/ProjectController.php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Project;
use App\Enums\ProjectStatusEnum;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

public function index(Request $request)
{

    $query = Project::query();

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    return Inertia::render('Project/Index', [
        'projects' => $query->paginate(10)->withQueryString(),
        'statusOptions' => ProjectStatusEnum::toValues(),
        'statusLabels' => ProjectStatusEnum::toLabels(),
        'filters' => $request->only(['search', 'status']), // so Vue can track state
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
            'project' => $project,
            'statusOptions' => ProjectStatusEnum::toLabels(),
        ]);
    }
    public function show(Project $project)
{
    return Inertia::render('Project/View', [
        'project' => $project,
    ]);
}
}
