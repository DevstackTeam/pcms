<?php

use App\Models\User;
use App\Models\Project;
use App\Models\Scenario;
use App\Models\Designation;
use Inertia\Testing\AssertableInertia;

it('shows scenario index page for a project', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();
    $scenario = Scenario::factory()->for($project)->create();

    $this->actingAs($user)
        ->get(route('projects.scenarios.index', $project))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) =>
            $page->component('Scenarios/Index')
                 ->has('scenarios')
                 ->where('project.id', $project->id)
        );
});

it('shows create scenario page', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();
    Designation::factory()->count(2)->create();

    $this->actingAs($user)
        ->get(route('projects.scenarios.create', $project))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) =>
            $page->component('Scenarios/Create')
                 ->has('designations')
                 ->where('project.id', $project->id)
        );
});

it('stores a new scenario with manpower', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();
    $designation = Designation::factory()->create();

$data = [
    'duration' => 3,
    'markup' => 10,
    'remark' => 'Test scenario',
    'total_cost' => 1000,
    'final_cost' => 1100,
    'manpower' => [
        [
            'designation_id' => $designation->id,
            'rate_per_day' => 100,
            'no_of_people' => 2,
            'total_day' => 3,
            'total_cost' => 600,
            'remark' => 'Test manpower',
        ]
    ],
];

$this->actingAs($user)
    ->post(route('projects.scenarios.store', $project), $data)
    ->assertRedirect(route('projects.scenarios.index', $project));

    $project->refresh();

    expect($project->scenarios()->where('remark', 'Test scenario')->exists())->toBeTrue();
});

it('shows a scenario detail page', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();
    $scenario = Scenario::factory()->for($project)->create();

    $this->actingAs($user)
        ->get(route('projects.scenarios.show', [$project, $scenario]))
        ->assertOk()
        ->assertInertia(fn ($page) =>
            $page->component('Scenarios/Show')
                 ->where('scenario.id', $scenario->id)
                 ->where('project.id', $project->id)
        );
});

it('shows edit scenario page', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();
    $scenario = Scenario::factory()->for($project)->create();
    Designation::factory()->count(2)->create();

    $this->actingAs($user)
        ->get(route('projects.scenarios.edit', [$project, $scenario]))
        ->assertOk()
        ->assertInertia(fn ($page) =>
            $page->component('Scenarios/Edit')
                 ->where('scenario.id', $scenario->id)
                 ->where('project.id', $project->id)
                 ->has('designations')
        );
});

it('updates a scenario and its manpower', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();
    $scenario = Scenario::factory()->for($project)->create();
    $designation = Designation::factory()->create();

    $updatedScenario = [
        'duration' => 5,
        'markup' => 15,
        'remark' => 'Updated remark',
        'total_cost' => 800,
        'final_cost' => 920,
    ];

    $updatedManpower = [
        'manpower' => [
            [
                'designation_id' => $designation->id,
                'rate_per_day' => 100,
                'no_of_people' => 2,
                'total_day' => 3,
                'total_cost' => 600,
                'remark' => 'Test manpower',
            ],
        ],
    ];

    $this->actingAs($user)
        ->put(route('projects.scenarios.update', [$project, $scenario]), array_merge($updatedScenario, $updatedManpower))
        ->assertRedirect(route('projects.scenarios.index', $project));

    $scenario->refresh();

    expect($scenario->remark)->toBe('Updated remark');
});

it('deletes a scenario', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();
    $scenario = Scenario::factory()->for($project)->create();

    $this->actingAs($user)
        ->delete(route('projects.scenarios.destroy', [$project, $scenario]))
        ->assertRedirect(route('projects.scenarios.index', $project));

    expect(Scenario::find($scenario->id))->toBeNull();
});
