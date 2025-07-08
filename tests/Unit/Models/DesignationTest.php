<?php

use App\Models\Designation;
use App\Models\User;
use App\Models\Manpower;

test('designation has a user relationship', function () {
    $user = User::factory()->create();
    $designation = Designation::factory()->create(['user_id' => $user->id]);

    expect($designation->user)->toBeInstanceOf(User::class);
    expect($designation->user->id)->toBe($user->id);
});

test('designation has many manpowers relationship', function () {
    $designation = Designation::factory()->create();
    $manpower1 = Manpower::factory()->create(['designation_id' => $designation->id]);
    $manpower2 = Manpower::factory()->create(['designation_id' => $designation->id]);

    expect($designation->manpowers)->toHaveCount(2);
    expect($designation->manpowers->first())->toBeInstanceOf(Manpower::class);
});
 
test('designation fillable attributes work correctly', function () {
    $designation = Designation::factory()->make([
        'name' => 'Test Role',
        'rate_per_day' => 100,
    ]);

    expect($designation->name)->toBe('Test Role');
    expect($designation->rate_per_day)->toBe(100);
});
