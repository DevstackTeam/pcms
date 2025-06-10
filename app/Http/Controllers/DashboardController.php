<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = Project::withCount('scenarios')->get();

        // dd($projects); // Debugging line to check the projects

        $projectCount = $projects->count(); // Count all projects
        $activeCount = $projects->where('status', 'Active')->count();
        $completedCount = $projects->where('status', 'Completed')->count();
        $notstartedCount = $projects->where('status', 'Not Started')->count();

        // dd($completedCount);
        // dd($projectCount);

        return Inertia::render('Dashboard');
    }
}
