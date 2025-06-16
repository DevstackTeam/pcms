<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectService
{
    public function store(array $data): Project
    {
        $project = Project::create([
            'user_id' => Auth::user()->id,
            'name' => $data['name'],
            'description' => $data['description'],
            'client' => $data['client'],
            'status' => $data['status'],
        ]);

        return $project;
    }

    public function update(Project $project, array $data): Project
    {
        $project->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'client' => $data['client'],
            'status' => $data['status'],
        ]);

        return $project;
    }
}
