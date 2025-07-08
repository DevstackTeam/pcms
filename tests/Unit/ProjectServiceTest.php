<?php

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\User;
use App\Services\ProjectService;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->service = new ProjectService();
});

test('stores a project', function () {
    $data = [
        'name' => 'Mobile App',
        'description' => 'Test Description',
        'client' => 'Petronas',
        'status' => ProjectStatus::ACTIVE->value,
    ];

    $project = $this->service->store($data);

    expect($project)->toBeInstanceOf(Project::class);
    expect($project->name)->toBe('Mobile App');
    expect($project->description)->toBe('Test Description');
    expect($project->client)->toBe('Petronas');
    expect($project->status)->toBe(ProjectStatus::ACTIVE);

    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'user_id' => $project->user_id,
        'name' => 'Mobile App',
        'description' => 'Test Description',
        'client' => 'Petronas',
        'status' => ProjectStatus::ACTIVE->value,
    ]);
});

test('updates a project', function () {
    $project = $this->user->projects()->create([
        'name' => 'Old Name',
        'description' => 'Old Description',
        'client' => 'Old Client',
        'status' => ProjectStatus::NOT_STARTED->value,
    ]);

    $data = [
        'name' => 'New Name',
        'description' => 'New Description',
        'client' => 'New Client',
        'status' => ProjectStatus::COMPLETED->value,
    ];

    $updated = $this->service->update($project, $data);

    expect($updated->name)->toBe('New Name');
    expect($updated->description)->toBe('New Description');
    expect($updated->client)->toBe('New Client');
    expect($updated->status)->toBe(ProjectStatus::COMPLETED);
});

test('searches projects by name and status', function () {
    $this->user->projects()->createMany([
        [
            'name' => 'Website Redesign',
            'description' => 'Redesigning the company website',
            'client' => 'TechCorp',
            'status' => ProjectStatus::ACTIVE->value,
        ],
        [
            'name' => 'Mobile App Development',
            'description' => 'Building a new mobile app',
            'client' => 'Devstack',
            'status' => ProjectStatus::NOT_STARTED->value,
        ],
        [
            'name' => 'E-commerce Platform',
            'description' => 'Trusted e-commerce platform',
            'client' => 'Amazon',
            'status' => ProjectStatus::ACTIVE->value,
        ],
    ]);

    $results = $this->service->search('Website', 'Active');

    expect($results)->toHaveCount(1);
});

test('searches projects by name only', function () {
    $this->user->projects()->createMany([
        [
            'name' => 'Web App Redesign',
            'description' => 'Redesigning the company website',
            'client' => 'TechCorp',
            'status' => ProjectStatus::ACTIVE->value,
        ],
        [
            'name' => 'Mobile App Development',
            'description' => 'Building a new mobile app',
            'client' => 'Devstack',
            'status' => ProjectStatus::NOT_STARTED->value,
        ],
        [
            'name' => 'E-commerce Platform',
            'description' => 'Trusted e-commerce platform',
            'client' => 'Amazon',
            'status' => ProjectStatus::ACTIVE->value,
        ],
        [
            'name' => 'Online Banking App',
            'description' => 'Easy online banking',
            'client' => 'Maybank',
            'status' => ProjectStatus::COMPLETED->value,
        ],
    ]);

    $results = $this->service->search('App', '');

    expect($results)->toHaveCount(3);
});

test('searches projects by status only', function () {
    $this->user->projects()->createMany([
        [
            'name' => 'Web App Redesign',
            'description' => 'Redesigning the company website',
            'client' => 'TechCorp',
            'status' => ProjectStatus::ACTIVE->value,
        ],
        [
            'name' => 'Mobile App Development',
            'description' => 'Building a new mobile app',
            'client' => 'Devstack',
            'status' => ProjectStatus::NOT_STARTED->value,
        ],
        [
            'name' => 'E-commerce Platform',
            'description' => 'Trusted e-commerce platform',
            'client' => 'Amazon',
            'status' => ProjectStatus::ACTIVE->value,
        ],
        [
            'name' => 'Online Banking App',
            'description' => 'Easy online banking',
            'client' => 'Maybank',
            'status' => ProjectStatus::COMPLETED->value,
        ],
    ]);

    $results = $this->service->search('', 'Active');

    expect($results)->toHaveCount(2);
});

test('search returns empty when no results found', function () {
    $this->user->projects()->createMany([
        [
            'name' => 'Web App Redesign',
            'description' => 'Redesigning the company website',
            'client' => 'TechCorp',
            'status' => ProjectStatus::ACTIVE->value,
        ],
        [
            'name' => 'Mobile App Development',
            'description' => 'Building a new mobile app',
            'client' => 'Devstack',
            'status' => ProjectStatus::NOT_STARTED->value,
        ],
        [
            'name' => 'E-commerce Platform',
            'description' => 'Trusted e-commerce platform',
            'client' => 'Amazon',
            'status' => ProjectStatus::ACTIVE->value,
        ],
        [
            'name' => 'Online Banking App',
            'description' => 'Easy online banking',
            'client' => 'Maybank',
            'status' => ProjectStatus::COMPLETED->value,
        ],
    ]);

    $results = $this->service->search('Keje.my', 'Not Started');

    expect($results)->toBeEmpty();
});
