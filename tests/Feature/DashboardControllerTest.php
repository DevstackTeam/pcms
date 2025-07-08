<?php

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('renders dashboard page with project statistics', function () {
    Project::factory()->count(9)->create([
        'user_id' => $this->user->id
    ]);

    $response = $this->get(route('dashboard'));

    $response->assertInertia(fn ($page) =>
        $page->component('Dashboard')
            ->has('projects')
            ->has('projectCount')
            ->has('activeCount')
            ->has('completedCount')
            ->has('notstartedCount')
            ->has('latestProjects')
    );
});
