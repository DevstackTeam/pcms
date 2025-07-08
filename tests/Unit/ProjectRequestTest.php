<?php

use App\Enums\ProjectStatus;
use App\Http\Requests\ProjectRequest;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rules = (new ProjectRequest())->rules();
});

test('passes validation with valid data', function () {
    $data = [
        'name' => 'Web Redesign',
        'description' => 'This is a test project.',
        'client' => 'Acme Inc.',
        'status' => ProjectStatus::ACTIVE->value,
    ];

    $validator = Validator::make($data, $this->rules);

    expect($validator->passes())->toBeTrue();
});

test('fails validation with invalid status', function () {
    $data = [
        'name' => 'Project Beta',
        'description' => 'Invalid status test.',
        'client' => 'Beta Corp',
        'status' => 'Invalid Status',
    ];

    $validator = Validator::make($data, $this->rules);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->toArray())->toHaveKey('status');
});

test('fails validation with missing required fields', function () {
    $data = [
        'name' => null,
        'description' => 'Test description',
        'client' => null,
        'status' => null,
    ];

    $validator = Validator::make($data, $this->rules);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->toArray())->toHaveKeys(['name', 'client', 'status']);
});

test('passes validation with nullable description', function () {
    $data = [
        'name' => 'Keje.my',
        'description' => null,
        'client' => 'Devstack',
        'status' => ProjectStatus::NOT_STARTED->value,
    ];

    $validator = Validator::make($data, $this->rules);

    expect($validator->passes())->toBeTrue();
});
