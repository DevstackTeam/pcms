<?php

namespace App\Services;

use App\Models\Scenario;

class ManpowerService
{
    public function storeMany(array $mp_request, Scenario $scenario): void
    {
        foreach ($mp_request as $mp) {
            $scenario->manpowers()->create([
                'designation_id' => $mp['designation_id'],
                'rate_per_day' => $mp['rate_per_day'],
                'no_of_people' => $mp['no_of_people'],
                'total_day' => $mp['total_day'],
                'total_cost' => $mp['total_cost'],
            ]);
        }
    }
}
