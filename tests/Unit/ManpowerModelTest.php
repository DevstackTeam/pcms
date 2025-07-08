<?php

use App\Models\Designation;
use App\Models\Manpower;
use App\Models\Scenario;

beforeEach(function () {
    $this->manpower = Manpower::factory()->create();
});

test('allows mass assignment for fillable fields', function () {
    $data = [
        'designation_id' => 1,
        'scenario_id' => 1,
        'total_day' => 5,
        'rate_per_day' => 100,
        'no_of_people' => 3,
        'remark' => 'Test',
        'total_cost' => 1500,
    ];

    $manpower = Manpower::create($data);

    foreach ($data as $key => $value) {
        expect($manpower->$key)->toEqual($value);
    }
});

test('manpower belongs to designation', function () {
    $designation = $this->manpower->designation;

    expect($designation)->toBeInstanceOf(Designation::class);
    expect($designation->id)->toEqual($this->manpower->designation_id);
});

test('manpower belongs to scenario', function () {
    $scenario = $this->manpower->scenario;

    expect($scenario)->toBeInstanceOf(Scenario::class);
    expect($scenario->id)->toEqual($this->manpower->scenario_id);
});
