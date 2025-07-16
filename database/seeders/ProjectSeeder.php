<?php

namespace Database\Seeders;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        Project::create([
            'user_id' => 1,
            'name' => 'Website Redesign',
            'description' => 'Redesign the client website for better UX.',
            'client' => 'Acme Inc.',
            'status' => ProjectStatus::COMPLETED->value,
            'created_at' => $now->copy()->addSeconds(1),
            'updated_at' => $now->copy()->addSeconds(1),
        ]);

        Project::create([
            'user_id' => 1,
            'name' => 'Mobile App Development ',
            'description' => 'Develop a mobile app for order tracking.',
            'client' => 'Beta Corp.',
            'status' => ProjectStatus::ACTIVE->value,
            'created_at' => $now->copy()->addSeconds(2),
            'updated_at' => $now->copy()->addSeconds(2),
        ]);

        Project::create([
            'user_id' => 1,
            'name' => 'Web App Development',
            'description' => 'Develop Web App.',
            'client' => 'Gamma LLC',
            'status' => ProjectStatus::NOT_STARTED->value,
            'created_at' => $now->copy()->addSeconds(3),
            'updated_at' => $now->copy()->addSeconds(3),
        ]);
    }
}
