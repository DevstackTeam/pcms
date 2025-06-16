<?php

namespace Database\Seeders;

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
        Project::truncate();

        Project::create([
            'user_id' => 2,
            'name' => 'Website Redesign',
            'description' => 'Redesign the client website for better UX.',
            'client' => 'Acme Inc.',
            'status' => 'Completed',
        ]);

        Project::create([
            'user_id' => 2,
            'name' => 'Mobile App Development Mobile App Development Mobile App Development',
            'description' => 'Develop a mobile app for order tracking.',
            'client' => 'Beta Corp.',
            'status' => 'Not Started',
        ]);

        Project::create([
            'user_id' => 2,
            'name' => 'Data Migration Data Migration Data Migration Data Migration Data Migration',
            'description' => 'Migrate data from legacy system.',
            'client' => 'Gamma LLC',
            'status' => 'Active',
        ]);
    }
}
