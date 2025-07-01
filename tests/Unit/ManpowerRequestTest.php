<?php

use App\Http\Requests\ManpowerRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->rules = (new ManpowerRequest())->rules();
    $this->messages = (new ManpowerRequest())->messages();
});

test('passes validation with valid manpower data', function () {
    $designation = $this->user->designations()->create([
        'name' => 'Developer', 
        'rate_per_day' => 100.00,
    ]);

    $data = [
        'manpower' => [
            [
                'designation_id' => $designation->id,
                'rate_per_day' => $designation->rate_per_day,
                'no_of_people' => 2,
                'total_day' => 5,
                'remark' => 'Skilled workers',
                'total_cost' => 1000.00,
            ],
        ],
    ];

    $validator = Validator::make($data, $this->rules);

    expect($validator->passes())->toBeTrue();
});

test('fails validation with invalid manpower data', function () {
    $data = [
        'manpower' => [
            [
                'designation_id' => null,
                'rate_per_day' => 'not a number',
                'no_of_people' => 'not a number',
                'total_day' => 'not a number',
                'remark' => 'Only remark is valid',
                'total_cost' => 'not a number',
            ],
        ],
    ];

    $validator = Validator::make($data, $this->rules, $this->messages);

    expect($validator->passes())->toBeFalse();

    $errors = $validator->errors()->toArray();

    expect($errors)->toHaveKeys([
        'manpower.0.designation_id',
        'manpower.0.rate_per_day',
        'manpower.0.no_of_people',
        'manpower.0.total_day',
        'manpower.0.total_cost',
    ]);

    expect($errors['manpower.0.designation_id'][0])->toBe('Required.');
    expect($errors['manpower.0.rate_per_day'][0])->toBe('Invalid value.');
    expect($errors['manpower.0.no_of_people'][0])->toBe('Invalid value.');
    expect($errors['manpower.0.total_day'][0])->toBe('Invalid value.');
    expect($errors['manpower.0.total_cost'][0])->toBe('Invalid value.');
});

test('passes validation with multiple data entry', function () {
    $designation = $this->user->designations()->create([
        'name' => 'Engineer', 
        'rate_per_day' => 100.00,
    ]);

    $data = [
        'manpower' => [
            [
                'designation_id' => $designation->id,
                'rate_per_day' => $designation->rate_per_day,
                'no_of_people' => 2,
                'total_day' => 5,
                'remark' => 'Skilled workers',
                'total_cost' => 1000.00,
            ],
            [
                'designation_id' => $designation->id,
                'rate_per_day' => $designation->rate_per_day,
                'no_of_people' => 3,
                'total_day' => 4,
                'remark' => 'Experienced workers',
                'total_cost' => 1200.00,
            ],
        ],
    ];

    $validator = Validator::make($data, $this->rules);

    expect($validator->passes())->toBeTrue();
});

test('fails validation when manpower is missing', function () {
    $data = [];

    $validator = Validator::make($data, $this->rules);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->toArray())->toHaveKey('manpower');
});

test('fails validation when a required field in manpower is missing', function () {
    $data = [
        'manpower' => [
            [
                'designation_id' => null,
                'rate_per_day' => null,
                'no_of_people' => null,
                'total_day' => null,
                'total_cost' => null,
            ],
        ],
    ];

    $validator = Validator::make($data, $this->rules);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->toArray())->toHaveKeys([
        'manpower.0.designation_id',
        'manpower.0.rate_per_day',
        'manpower.0.no_of_people',
        'manpower.0.total_day',
        'manpower.0.total_cost',
    ]);
});
