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
