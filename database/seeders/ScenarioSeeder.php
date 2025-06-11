<?php

namespace Database\Seeders;

use App\Models\Scenario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScenarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Scenario::create([
            'project_id' => 1,
            'markup' => 2,
            'duration' => '3 months',
            'remark' => 'High priority project with tight deadlines.',
            'total_cost' => 15000.00,
            'final_cost' => 18000.00,
        ]);

        Scenario::create([
            'project_id' => 1,
            'markup' => 4,
            'duration' => '4 months',
            'remark' => 'High priority project with tight deadlines.',
            'total_cost' => 13000.00,
            'final_cost' => 14000.00,
        ]);

        Scenario::create([
            'project_id' => 1,
            'markup' => 2,
            'duration' => '2 months',
            'remark' => 'High priority project with tight deadlines.',
            'total_cost' => 18000.00,
            'final_cost' => 19000.00,
        ]);

        Scenario::create([
            'project_id' => 2,
            'markup' => 4,
            'duration' => '6 months',
            'remark' => 'High priority project with tight deadlines.',
            'total_cost' => 11000.00,
            'final_cost' => 13000.00,
        ]);

        Scenario::create([
            'project_id' => 2,
            'markup' => 1,
            'duration' => '4 months',
            'remark' => 'High priority project with tight deadlines.',
            'total_cost' => 12000.00,
            'final_cost' => 14000.00,
        ]);
    }
}
