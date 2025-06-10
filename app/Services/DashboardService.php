<?php

namespace App\Services;

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

        $projectCount = $projects->count();
        $activeCount = $projects->where('status', 'Active')->count();
        $completedCount = $projects->where('status', 'Completed')->count();
        $notstartedCount = $projects->where('status', 'Not Started')->count();

        return [
            'projects' => $projects,
            'projectCount' => $projectCount,
            'activeCount' => $activeCount,
            'completedCount' => $completedCount,
            'notstartedCount' => $notstartedCount,
        ];
    }
}