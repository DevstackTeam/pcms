<?php

use App\Http\Requests\AuthLoginRequest;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rules = (new AuthLoginRequest())->rules();
});

test('passes validation with valid data', function () {
    $data = [
        'email' => 'test@gmail.com',
        'password' => 'password123',
    ];

    $validator = Validator::make($data, $this->rules);
    expect($validator->passes())->toBeTrue();
});

test('fails validation when email is invalid', function () {
    $data = [
        'email' => 'invalid-email',
        'password' => 'password123',
    ];

    $validator = Validator::make($data, $this->rules);
    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->toArray())->toHaveKey('email');
});

test('fails validation when missing required fields', function () {
    $data = [
        'email' => null,
        'password' => null,
    ];

    $validator = Validator::make($data, $this->rules);
    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->toArray())->toHaveKeys(['email', 'password']);
});
