<?php

use App\Models\Designation;
use App\Models\Scenario;
use App\Services\ManpowerService;

beforeEach(function () {
    $this->scenario = Scenario::factory()->create();
    $this->designation1 = Designation::factory()->create();
    $this->designation2 = Designation::factory()->create();
    $this->service = new ManpowerService();
});

test('stores a manpower', function () {
    $data = [
        'manpower' => [
            [
                'designation_id' => $this->designation1->id,
                'rate_per_day' => $this->designation1->rate_per_day,
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
    expect($manpower->designation_id)->toEqual($this->designation1->id);
    expect($manpower->rate_per_day)->toEqual($this->designation1->rate_per_day);
    expect($manpower->no_of_people)->toEqual(2);
    expect($manpower->total_day)->toEqual(5);
    expect($manpower->remark)->toEqual('Skilled workers');
    expect($manpower->total_cost)->toEqual(1000.00);
});

test('stores multiple manpower at one time', function () {
    $data = [
        'manpower' => [
            [
                'designation_id' => $this->designation1->id,
                'rate_per_day' => $this->designation1->rate_per_day,
                'no_of_people' => 2,
                'total_day' => 5,
                'remark' => 'Skilled workers',
                'total_cost' => 1000.00,
            ],
            [
                'designation_id' => $this->designation2->id,
                'rate_per_day' => $this->designation2->rate_per_day,
                'no_of_people' => 3,
                'total_day' => 4,
                'remark' => 'Semi-skilled workers',
                'total_cost' => 1800.00,
            ]
        ],
    ];

    $this->service->storeMany($data['manpower'], $this->scenario);

    $manpowers = $this->scenario->manpowers;

    expect($manpowers)->toHaveCount(2);

    expect($manpowers[0]->designation_id)->toEqual($this->designation1->id);
    expect($manpowers[0]->rate_per_day)->toEqual($this->designation1->rate_per_day);
    expect($manpowers[0]->no_of_people)->toEqual(2);
    expect($manpowers[0]->total_day)->toEqual(5);
    expect($manpowers[0]->remark)->toEqual('Skilled workers');
    expect($manpowers[0]->total_cost)->toEqual(1000.00);

    expect($manpowers[1]->designation_id)->toEqual($this->designation2->id);
    expect($manpowers[1]->rate_per_day)->toEqual($this->designation2->rate_per_day);
    expect($manpowers[1]->no_of_people)->toEqual(3);
    expect($manpowers[1]->total_day)->toEqual(4);
    expect($manpowers[1]->remark)->toEqual('Semi-skilled workers');
    expect($manpowers[1]->total_cost)->toEqual(1800.00);
});
