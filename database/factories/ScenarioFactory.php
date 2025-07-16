<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Scenario>
 */
class ScenarioFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'markup' => fake()->numberBetween(5, 30),
            'duration' => fake()->numberBetween(1, 12),
            'remark' => fake()->sentence(),
            'total_cost' => fake()->numberBetween(1000, 10000),
            'final_cost' => fake()->numberBetween(1000, 10000),
        ];
    }
}
