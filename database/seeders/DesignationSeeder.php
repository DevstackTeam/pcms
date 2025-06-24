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
        $now = now();

        Designation::create([
            'user_id' => 1,
            'name' => 'Senior Developer',
            'rate_per_day' => 150.00,
            'created_at' => $now->copy()->addSeconds(1),
            'updated_at' => $now->copy()->addSeconds(1),
        ]);

        Designation::create([
            'user_id' => 1,
            'name' => 'Junior Developer',
            'rate_per_day' => 100.00,
            'created_at' => $now->copy()->addSeconds(2),
            'updated_at' => $now->copy()->addSeconds(2),
        ]);

        Designation::create([
            'user_id' => 1,
            'name' => 'Tester',
            'rate_per_day' => 80.00,
            'created_at' => $now->copy()->addSeconds(3),
            'updated_at' => $now->copy()->addSeconds(3),
        ]);

        Designation::create([
            'user_id' => 1,
            'name' => 'Business Analyst',
            'rate_per_day' => 230.00,
            'created_at' => $now->copy()->addSeconds(4),
            'updated_at' => $now->copy()->addSeconds(4),
        ]);
    }
}
