<?php

use App\Enums\ProjectStatus;
use App\Models\User;
use App\Services\ManpowerService;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->project = $this->user->projects()->create([
        'name' => 'Test Project',
        'description' => 'This is a test project.',
        'client' => 'Test Client',
        'status' => ProjectStatus::ACTIVE->value,
    ]);
    $this->scenario = $this->project->scenarios()->create([
        'markup' => 9,
        'duration' => 30,
        'remark' => 'Initial scenario',
        'total_cost' => 10000.00,
        'final_cost' => 11000.00,
    ]);
    $this->service = new ManpowerService();
});

test('stores a manpower', function () {
    $data = [
        'manpower' => [
            [
                'designation_id' => 1,
                'rate_per_day' => 100.00,
                'no_of_people' => 2,
                'total_day' => 5,
                'remark' => 'Skilled workers',
                'total_cost' => 1000.00,
            ],
        ],
    ];

    $this->service->storeMany($data['manpower'], $this->scenario);

    $manpower = $this->scenario->manpowers()->first();

    expect($manpower)->not->toBeNull();
    expect($manpower->designation_id)->toBe(1);
    expect($manpower->rate_per_day)->toEqual(100.00);
    expect($manpower->no_of_people)->toBe(2);
    expect($manpower->total_day)->toBe(5);
    expect($manpower->remark)->toBe('Skilled workers');
    expect($manpower->total_cost)->toEqual(1000.00);
});

