<?php

use App\Models\Project;
use App\Models\Scenario;
use App\Models\User;
use App\Services\ScenarioService;


beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->project = Project::factory()->create(['user_id' => $this->user->id]);
    $this->service = new ScenarioService();
});

test('it creates a scenario for a project', function () {
    $scenario = $this->service->store([
        'duration' => 5,
        'remark' => 'Test scenario creation',
        'markup' => 10.5,
        'total_cost' => 1000,
        'final_cost' => 1105,
    ],
     $this->project);

    expect($scenario)->toBeInstanceOf(Scenario::class);
    expect($scenario->duration)->toBe(5);
    expect($scenario->remark)->toBe('Test scenario creation');

    $this->assertDatabaseHas('scenarios', [
        'project_id' => $this->project->id,
        'duration' => 5,
        'remark' => 'Test scenario creation',
        'markup' => 10.5,
        'total_cost' => 1000,
        'final_cost' => 1105,
    ]);
});

test('it updates an existing scenario', function () {
    $scenario = Scenario::factory()->create([
        'project_id' => $this->project->id,
        'duration' => 3,
        'remark' => 'Old remark',
        'markup' => 5.0,
        'total_cost' => 500,
        'final_cost' => 525,
    ]);

    $updated = $this->service->update([
        'duration' => 10,
        'remark' => 'Updated remark',
        'markup' => 15.0,
        'total_cost' => 2000,
        'final_cost' => 2300,
    ], $scenario);

    expect($updated->duration)->toBe(10);
    expect($updated->remark)->toBe('Updated remark');

    $this->assertDatabaseHas('scenarios', [
        'id' => $scenario->id,
        'duration' => 10,
        'remark' => 'Updated remark',
        'markup' => 15.0,
        'total_cost' => 2000,
        'final_cost' => 2300,
    ]);
});

test('it deletes a scenario', function () {
    $scenario = Scenario::factory()->create([
        'project_id' => $this->project->id,
        'remark' => 'To be deleted',
    ]);

    $this->service->delete($scenario);

    $this->assertSoftDeleted('scenarios', [
        'id' => $scenario->id,
        'remark' => 'To be deleted',
    ]);
});
