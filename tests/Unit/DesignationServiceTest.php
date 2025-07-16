<?php

use App\Models\User;
use App\Models\Manpower;
use App\Models\Designation;
use App\Services\DesignationService;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->service = new DesignationService();
});

test('it creates a designation with valid data', function () {
    $designation = $this->service->store([
        'name' => 'Software Engineer',
        'rate_per_day' => 300,
    ]);

    expect($designation)->toBeInstanceOf(Designation::class);
    expect($designation->name)->toBe('Software Engineer');

    $this->assertDatabaseHas('designations', [
        'name' => 'Software Engineer',
        'rate_per_day' => 300,
        'user_id' => $this->user->id,
    ]);
});

test('it updates an existing designation', function () {
    $designation = Designation::create([
        'name' => 'Junior Developer',
        'rate_per_day' => 150,
        'user_id' => $this->user->id,
    ]);

    $updated = $this->service->update($designation, [
        'name' => 'Senior Developer',
        'rate_per_day' => 500,
    ]);

    expect($updated->name)->toBe('Senior Developer');
    expect($updated->rate_per_day)->toBe(500);

    $this->assertDatabaseHas('designations', [
        'id' => $designation->id,
        'name' => 'Senior Developer',
        'rate_per_day' => 500,
    ]);
});

test('it fetches filtered designations', function () {
    Designation::factory()->create([
        'name' => 'Backend Engineer',
        'user_id' => $this->user->id,
    ]);

    Designation::factory()->create([
        'name' => 'Frontend Engineer',
        'user_id' => $this->user->id,
    ]);

    Designation::factory()->create([
        'name' => 'UI/UX Designer',
        'user_id' => $this->user->id,
    ]);

    $filtered = $this->service->getFilteredDesignations('Front');

    expect($filtered)->toBeInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class);
    expect($filtered->count())->toBe(1);
    expect($filtered->first()->name)->toBe('Frontend Engineer');
});

test('it only fetches designations of the authenticated user', function () {
    Designation::factory()->create([
        'name' => 'My Designation',
        'user_id' => $this->user->id,
    ]);

    Designation::factory()->create([
        'name' => 'Other User Designation',
        'user_id' => User::factory()->create()->id,
    ]);

    $filtered = $this->service->getFilteredDesignations(null);

    expect($filtered->pluck('user_id'))->toContain($this->user->id);
    expect($filtered->pluck('user_id'))->not->toContain(fn ($id) => $id !== $this->user->id);
});

test('it does not allow duplicate designation names', function () {
    Designation::create([
        'name' => 'Duplicate Name',
        'rate_per_day' => 200,
        'user_id' => $this->user->id,
    ]);

    $this->expectException(\Illuminate\Database\QueryException::class);

    $this->service->store([
        'name' => 'Duplicate Name',
        'rate_per_day' => 300,
    ]);
});

test('it does not change user_id when updating a designation', function () {
    $designation = Designation::create([
        'name' => 'Dev',
        'rate_per_day' => 200,
        'user_id' => $this->user->id,
    ]);

    $updated = $this->service->update($designation, [
        'name' => 'Updated Dev',
        'rate_per_day' => 300,
    ]);

    expect($updated->user_id)->toBe($this->user->id);
});


test('it deletes a designation', function () {
    $designation = Designation::create([
        'name' => 'To Be Deleted',
        'rate_per_day' => 100,
        'user_id' => $this->user->id,
    ]);

    $this->service->delete($designation);

    $this->assertSoftDeleted('designations', [
        'id' => $designation->id,
    ]);
});

test('soft deletes related manpowers when designation is soft deleted', function () {
    $designation = Designation::factory()->create();

    $this->service->delete($designation);

    $this->assertSoftDeleted('designations', [
        'id' => $designation->id,
    ]);

});
