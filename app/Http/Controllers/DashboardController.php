<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\DashboardService;

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

        return Inertia::render('Dashboard', [
            'projects' => $data['projects'],
            'projectCount' => $data['projectCount'],
            'activeCount' => $data['activeCount'],
            'completedCount' => $data['completedCount'],
            'notstartedCount' => $data['notstartedCount'],
            'latestProjects' => $data['latestProjects'],
        ]);
    }
}
