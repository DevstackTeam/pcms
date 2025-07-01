<?php

namespace Database\Factories;

use App\Models\Designation;
use App\Models\Scenario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manpower>
 */
class ManpowerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'designation_id' => Designation::factory(),
            'scenario_id' => Scenario::factory(),
            'rate_per_day' => fake()->numberBetween(100, 1000),
            'no_of_people' => fake()->numberBetween(1, 10),
            'total_day' => fake()->numberBetween(1, 30),
            'remark' => fake()->sentence(),
            'total_cost' => fake()->numberBetween(1000, 30000),
        ];
    }
}
