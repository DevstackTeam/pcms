<?php

use App\Models\Designation;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

it('shows the designations index page', function () {
    $user = User::factory()->create();
            Designation::factory()->create(['name' => 'Engineer']);

    $this->actingAs($user);

    $this->get(route('designations.index'))
         ->assertOk()
         ->assertInertia(fn (AssertableInertia $page) =>
            $page->component('Designations')
                 ->has('designations')
                 ->has('filters')
        );
});


it('stores a new designation', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $data = ['name' => 'Manager', 'rate_per_day' => 250];

    $this->post(route('designations.store'), $data)
         ->assertRedirect(route('designations.index'));

    expect(Designation::where($data)->exists())->toBeTrue();
});

it('updates a designation', function () {
    $user = User::factory()->create();
    $designation = Designation::factory()->create([
        'name' => 'Old Name',
        'rate_per_day' => 100,
    ]);

    $this->actingAs($user);

    $updatedData = ['name' => 'Updated Name', 'rate_per_day' => 300];

    $this->put(route('designations.update', $designation), $updatedData)
        ->assertRedirect(route('designations.index'));

    expect($designation->fresh())
        ->name->toBe('Updated Name')
        ->rate_per_day->toBe(300);
});

it('deletes a designation', function () {
    $user = User::factory()->create();
    $designation = Designation::factory()->create();

    $this->actingAs($user);

   $this-> delete(route('designations.destroy', $designation))
        ->assertRedirect(route('designations.index'));

    expect(Designation::find($designation->id))->toBeNull();
});
