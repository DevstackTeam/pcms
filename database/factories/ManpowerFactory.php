<?php

namespace Database\Factories;

use App\Models\Manpower;
use App\Models\Scenario;
use App\Models\Designation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManpowerFactory extends Factory
{
    protected $model = Manpower::class;

    public function definition(): array
    {
        return [

            'designation_id' => Designation::factory(),
            'scenario_id' => Scenario::factory(),
            'total_day' => $this->faker->numberBetween(1, 30),
            'rate_per_day' => $this->faker->randomFloat(2, 100, 1000),
            'no_of_people' => $this->faker->numberBetween(1, 10),
            'remark' => $this->faker->sentence(),
            'total_cost' => $this->faker->randomFloat(2, 1000, 10000),
        ];
    }
}
