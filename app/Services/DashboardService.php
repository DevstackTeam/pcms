<?php

namespace App\Services;

use App\Enums\ProjectStatus;
use App\Models\Project;

class DashboardService
{
    /**
     * Get project statistics.
     *
     * @param \Illuminate\Database\Eloquent\Collection $projects
     * @return array
     */
    public function getProjectStatistics()
    {
        $projects = Project::withCount('scenarios')->get();
        $latestProjects = Project::withCount('scenarios')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $projectCount = $projects->count();
        $activeCount = $projects->where('status', ProjectStatus::ACTIVE->value)->count();
        $completedCount = $projects->where('status', ProjectStatus::COMPLETED->value)->count();
        $notstartedCount = $projects->where('status', ProjectStatus::NOT_STARTED->value)->count();

        return [
            'projects' => $projects,
            'projectCount' => $projectCount,
            'activeCount' => $activeCount,
            'completedCount' => $completedCount,
            'notstartedCount' => $notstartedCount,
            'latestProjects' => $latestProjects,
        ];
    }
}
