<?php

use App\Http\Requests\ScenarioRequest;
use Illuminate\Support\Facades\Validator;

test('scenario request authorizes by default', function () {
    $request = new ScenarioRequest();

    expect($request->authorize())->toBeTrue();
});

test('scenario request passes with valid data', function () {
    $data = [
        'duration' => 10,
        'remark' => 'A valid remark',
        'total_cost' => 5000,
        'markup' => 5,
        'final_cost' => 5250,
    ];

    $validator = Validator::make($data, (new ScenarioRequest())->rules());

    expect($validator->fails())->toBeFalse();
});

test('scenario request fails when required fields are missing', function () {
    $data = [];

    $validator = Validator::make($data, (new ScenarioRequest())->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->keys())->toContain('duration', 'total_cost', 'markup', 'final_cost');
});

test('scenario request allows null remark', function () {
    $data = [
        'duration' => 3,
        'remark' => null,
        'total_cost' => 200,
        'markup' => 5,
        'final_cost' => 210,
    ];

    $validator = Validator::make($data, (new ScenarioRequest())->rules());

    expect($validator->fails())->toBeFalse();
});

test('scenario request fails if total_cost is negative', function () {
    $data = [
        'duration' => 3,
        'remark' => 'Invalid cost',
        'total_cost' => -100,
        'markup' => 5,
        'final_cost' => 210,
    ];

    $validator = Validator::make($data, (new ScenarioRequest())->rules(), (new ScenarioRequest())->messages());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('total_cost'))->toBe('Invalid value for Total Cost');
});

test('scenario request fails if markup is negative', function () {
    $data = [
        'duration' => 3,
        'remark' => 'Invalid markup',
        'total_cost' => 200,
        'markup' => -5,
        'final_cost' => 190,
    ];

    $validator = Validator::make($data, (new ScenarioRequest())->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('markup'))->toBeTrue();
});
