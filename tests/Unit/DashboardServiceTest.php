<?php

use App\Models\Project;
use App\Services\DashboardService;
use App\Enums\ProjectStatus;

test('returns correct project statistics with enum statuses', function () {
    Project::factory()->count(2)->create(['status' => ProjectStatus::ACTIVE->value]);
    Project::factory()->create(['status' => ProjectStatus::COMPLETED->value]);
    Project::factory()->create(['status' => ProjectStatus::NOT_STARTED->value]);

    $latest = Project::factory()->count(3)->create([
        'status' => ProjectStatus::ACTIVE->value,
        'created_at' => now()->addMinutes(5)
    ]);

    $service = new DashboardService();
    $stats = $service->getProjectStatistics();

    expect($stats['projectCount'])->toBe(7) 
        ->and($stats['activeCount'])->toBe(5)
        ->and($stats['completedCount'])->toBe(1)
        ->and($stats['notstartedCount'])->toBe(1)
        ->and($stats['latestProjects'])->toHaveCount(3);

    expect($stats['latestProjects']->pluck('id')->sort()->values())->toEqual(
        $latest->pluck('id')->sort()->values()
    );
});
