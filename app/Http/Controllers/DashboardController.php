<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(
        DashboardService $dashboardService
    )
    {
        $this->dashboardService = $dashboardService;

    }

    public function index()
    {
        $data = $this->dashboardService->getProjectStatistics();
        // dd($data['projects']);
        return Inertia::render('Dashboard', [
            'projects' => $data['projects'],
            'projectCount' => $data['projectCount'],
            'activeCount' => $data['activeCount'],
            'completedCount' => $data['completedCount'],
            'notstartedCount' => $data['notstartedCount'],
            'latestProjects' => $data['latestProjects'],
            'user' => Auth::user(),
        ]);
    }
}
