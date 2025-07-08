<?php

use App\Models\Project;
use App\Models\Scenario;
use App\Models\Manpower;

test('scenario belongs to a project', function () {
    $project = Project::factory()->create();
    $scenario = Scenario::factory()->create(['project_id' => $project->id]);

    expect($scenario->project)->toBeInstanceOf(Project::class);
    expect($scenario->project->id)->toBe($project->id);
});

test('scenario has many manpowers', function () {
    $scenario = Scenario::factory()->create();

    $manpowerA = Manpower::factory()->create(['scenario_id' => $scenario->id]);
    $manpowerB = Manpower::factory()->create(['scenario_id' => $scenario->id]);

    expect($scenario->manpowers)->toHaveCount(2);
    expect($scenario->manpowers->pluck('id'))->toContain($manpowerA->id, $manpowerB->id);
});

test('scenario has correct fillable attributes', function () {
    $scenario = new Scenario();

    expect($scenario->getFillable())->toMatchArray([
        'project_id',
        'markup',
        'duration',
        'remark',
        'total_cost',
        'final_cost',
    ]);
});

test('scenario casts cost fields as float', function () {
    $scenario = Scenario::factory()->create([
        'total_cost' => '1234.33',
        'final_cost' => '2345.67',
    ]);

    expect($scenario->total_cost)->toBeFloat();
    expect($scenario->final_cost)->toBeFloat();
});
