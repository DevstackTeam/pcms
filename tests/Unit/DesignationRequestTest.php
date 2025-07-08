<?php

use App\Models\Designation;
use App\Http\Requests\DesignationRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Route;

test('designation request authorizes by default', function () {
    $request = new DesignationRequest();

    expect($request->authorize())->toBeTrue();
});

test('it passes validation with valid data', function () {
    $data = [
        'name' => 'Backend Developer',
        'rate_per_day' => 300,
    ];

    $validator = Validator::make($data, (new DesignationRequest())->rules());

    expect($validator->fails())->toBeFalse();
});

test('it fails validation if name is missing', function () {
    $data = [
        'name' => '',
        'rate_per_day' => 300,
    ];

    $validator = Validator::make($data, (new DesignationRequest())->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->toArray())->toHaveKey('name');
});

test('it fails validation if rate_per_day is negative', function () {
    $data = [
        'name' => 'QA Tester',
        'rate_per_day' => -50,
    ];

    $validator = Validator::make($data, (new DesignationRequest())->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->toArray())->toHaveKey('rate_per_day');
});

test('it fails validation if name is not unique', function () {
    Designation::factory()->create(['name' => 'Duplicate Name']);

    $data = [
        'name' => 'Duplicate Name',
        'rate_per_day' => 200,
    ];

    $validator = Validator::make($data, (new DesignationRequest())->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->toArray())->toHaveKey('name');
});

test('it allows updating with same designation name', function () {
    $designation = Designation::factory()->create(['name' => 'Same Name']);

    $data = [
        'name' => 'Same Name',
        'rate_per_day' => 500,
    ];

    $request = new DesignationRequest();

    $route = new Route('PUT', '/designations/{designation}', []);
    $requestToSimulate = request()->create('/designations/' . $designation->id, 'PUT', $data);
    $route->bind($requestToSimulate);

    $route->setParameter('designation', $designation);
    $request->setRouteResolver(fn () => $route);

    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeFalse();
});

test('it fails validation if rate_per_day is not numeric', function () {
    $data = [
        'name' => 'Frontend Dev',
        'rate_per_day' => 'abc',
    ];

    $validator = Validator::make($data, (new DesignationRequest())->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->toArray())->toHaveKey('rate_per_day');
});

test('it fails validation if rate_per_day is missing', function () {
    $data = [
        'name' => 'Designer',
    ];

    $validator = Validator::make($data, (new DesignationRequest())->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->toArray())->toHaveKey('rate_per_day');
});

test('it fails validation if both name and rate_per_day are missing', function () {
    $data = [];

    $validator = Validator::make($data, (new DesignationRequest())->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->toArray())->toHaveKeys(['name', 'rate_per_day']);
});

test('it passes validation when updating with a new unique name', function () {
    Designation::factory()->create(['name' => 'Existing Name']);
    $designation = Designation::factory()->create(['name' => 'Old Name']);

    $data = [
        'name' => 'New Unique Name',
        'rate_per_day' => 600,
    ];

    $request = new DesignationRequest();
    $route = new Route('PUT', '/designations/{designation}', []);
    $route->bind(request()->create('/designations/' . $designation->id, 'PUT', $data));
    $route->setParameter('designation', $designation);
    $request->setRouteResolver(fn () => $route);

    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeFalse();
});




