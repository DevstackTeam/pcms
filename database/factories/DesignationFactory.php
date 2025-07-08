<?php

namespace Database\Factories;

use App\Models\Designation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DesignationFactory extends Factory
{
    protected $model = Designation::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->jobTitle,
            'rate_per_day' => $this->faker->numberBetween(100, 1000),
            'user_id' => User::factory(), // Make sure UserFactory exists too
        ];
    }
}
