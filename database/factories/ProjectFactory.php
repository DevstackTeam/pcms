<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use App\Enums\ProjectStatus; // if you use enums
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
       return [
        'user_id' => User::factory(),
        'name' => fake()->company(),
        'description' => fake()->sentence(),
        'client' => fake()->company(),
        'status' => ProjectStatus::ACTIVE->value,
];

    }
}
