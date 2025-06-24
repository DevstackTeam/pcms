<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Scenario;

class ScenarioService
{
    public function store(array $data, Project $project): Scenario
    {
        return $project->scenarios()->create([
            'duration' => $data['duration'],
            'remark' => $data['remark'],
            'markup' => $data['markup'],
            'total_cost' => $data['total_cost'],
            'final_cost' => $data['final_cost'],
        ]);
    }

    public function update(array $data, Scenario $scenario): Scenario
    {
        $scenario->update([
            'duration' => $data['duration'],
            'remark' => $data['remark'],
            'markup' => $data['markup'],
            'total_cost' => $data['total_cost'],
            'final_cost' => $data['final_cost'],
        ]);

        return $scenario;
    }
}
