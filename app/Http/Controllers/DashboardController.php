<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        ]);
    }
}
