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
            'duration' => fake()->numberBetween(1, 10),
            'remark' => fake()->sentence(),
            'markup' => fake()->randomFloat(2, 0, 50),
            'total_cost' => fake()->numberBetween(1000, 10000),
            'final_cost' => fake()->numberBetween(1100, 12000),
        ];
    }
}
