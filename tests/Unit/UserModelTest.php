<?php

use App\Models\Designation;
use App\Models\User;

test('user has many designations', function () {
    $user = User::factory()->create();

    Designation::factory(3)->create([
        'user_id' => $user->id,
    ]);

    expect($user->designations)->toHaveCount(3);

    foreach ($user->designations as $designation) {
        expect($designation->user_id)->toEqual($user->id);
        expect($designation)->toBeInstanceOf(Designation::class);
    }
});
