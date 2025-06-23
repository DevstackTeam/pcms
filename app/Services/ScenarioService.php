<?php

namespace App\Services;

use App\Models\Scenario;

class ScenarioService
{
    public function store(array $data): Scenario
    {
        $data['final_cost'] = round(
            $data['total_cost'] + ($data['total_cost'] * $data['markup'] / 100),
            2
        );

        return Scenario::create($data);
    }
}
