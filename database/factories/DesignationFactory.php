<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Designation>
 */
class DesignationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
        'Junior Developer',
        'Senior Developer',
        'Project Manager',
        'Software Engineer',
        'Frontend Developer',
        'Backend Developer',
        'Full Stack Developer',
        'DevOps Engineer',
        'QA Engineer',
        'Business Analyst',
        'Scrum Master',
        'Tech Lead',
        'System Architect',
    ];

        return [
            'user_id' => User::factory(),
            'name' => fake()->unique()->randomElement($titles),
            'rate_per_day' => fake()->numberBetween(100, 1000),
        ];
    }
}
