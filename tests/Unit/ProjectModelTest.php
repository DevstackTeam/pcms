<?php

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\Scenario;
use App\Models\User;

test('allows mass assignment for fillable fields', function () {
    $user = User::factory()->create();

    $data = [
        'user_id' => $user->id,
        'name' => 'Test Project',
        'description' => 'Description of the project',
        'client' => 'Test Client',
        'status' => ProjectStatus::ACTIVE,
    ];

    $project = Project::create($data);

    foreach ($data as $key => $value) {
        expect($project->$key)->toEqual($value);
    }
});

test('project status is cast to enum', function () {
    $project = Project::factory()->create([
        'status' => ProjectStatus::ACTIVE->value,
    ]);

    expect($project->status)->toBeInstanceOf(ProjectStatus::class);
    expect($project->status)->toBe(ProjectStatus::ACTIVE);
});

test('project belongs to user', function () {
    $project = Project::factory()->create();
    $user = $project->user;

    expect($user)->toBeInstanceOf(User::class);
    expect($user->id)->toEqual($project->user_id);
});

test('project has many scenarios', function () {
    $project = Project::factory()->create();

    Scenario::factory(3)->create([
        'project_id' => $project->id,
    ]);

    expect($project->scenarios)->toHaveCount(3);

    foreach ($project->scenarios as $scenario) {
        expect($scenario->project_id)->toEqual($project->id);
        expect($scenario)->toBeInstanceOf(Scenario::class);        
    }
});
