<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Designation::create([
            'user_id' => 2,
            'name' => 'Senior Developer',
            'rate_per_day' => 150.00,
        ]);

        Designation::create([
            'user_id' => 2,
            'name' => 'Junior Developer',
            'rate_per_day' => 100.00,
        ]);

        Designation::create([
            'user_id' => 2,
            'name' => 'Tester',
            'rate_per_day' => 80.00,
        ]);
    }
}
