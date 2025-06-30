<?php

namespace Tests\Feature;

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_stores_valid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $validData = [
            'id' => 1,
            'name' => 'New Project',
            'description' => 'Build a new system',
            'client' => 'ACME Corp.',
            'status' => ProjectStatus::ACTIVE->value, 
        ];

        $response = $this->post(route('projects.store'), $validData);

        $this->assertDatabaseHas('projects', [
            'id' => 1,
            'name' => 'New Project',
            'description' => 'Build a new system',
            'client' => 'ACME Corp.',
            'status' => ProjectStatus::ACTIVE->value,
        ]);

        $response->assertRedirectToRoute('projects.show', 1); 

        $response->assertSessionHas('success', 'Project created successfully.');
    }

    #[Test]
    public function it_rejects_invalid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $invalidData = [
            'name' => null,
            'client' => null,
            'status' => 'NotAStatus',
        ];

        $response = $this->post(route('projects.store'), $invalidData);

        $response->assertSessionHasErrors(['name', 'client', 'status']);
    }

    #[Test]
    public function it_updates_project_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::create([
            'user_id' => $user->id,
            'name' => 'Old Name',
            'client' => 'Old Client',
            'description' => 'Old Description',
            'status' => ProjectStatus::ACTIVE->value,
        ]);

        $updatedData = [
            'name' => 'New Name',
            'client' => 'New Client',
            'description' => 'New Description',
            'status' => ProjectStatus::COMPLETED->value,
        ];

        $response = $this->patch(route('projects.update', $project->id), $updatedData);

        $response->assertRedirect(route('projects.show', $project->id));

        $response->assertSessionHas('success', 'Project updated successfully.');

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'New Name',
            'client' => 'New Client',
            'status' => ProjectStatus::COMPLETED->value,
        ]);
    }

    #[Test]
    public function it_deletes_project()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::create([
            'user_id' => $user->id,
            'name' => 'Delete Me',
            'client' => 'Some Client',
            'status' => ProjectStatus::NOT_STARTED->value,
            'description' => 'Temporary project.',
        ]);

        $response = $this->delete(route('projects.destroy', $project->id));

        $response->assertRedirect(route('projects.index'));

        $response->assertSessionHas('success', 'Project deleted successfully.');
    }

    #[Test]
    public function it_returns_projects_index_page_with_filters()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Project::create([
            'user_id' => $user->id,
            'name' => 'Website Redesign',
            'client' => 'Client A',
            'description' => null,
            'status' => ProjectStatus::ACTIVE->value,
        ]);

        Project::create([
            'user_id' => $user->id,
            'name' => 'Website Revamp',
            'client' => 'Client B',
            'description' => null,
            'status' => ProjectStatus::ACTIVE->value,
        ]);

        Project::create([
            'user_id' => $user->id,
            'name' => 'Mobile App',
            'client' => 'Client C',
            'description' => null,
            'status' => ProjectStatus::COMPLETED->value,
        ]);

        $response = $this->get(route('projects.index', [
            'search' => 'Website',
            'status' => ProjectStatus::ACTIVE->value,
        ]));

        $response->assertOk();

        $response->assertInertia(fn ($page) => 
            $page->component('Projects/Index')
                ->has('projects.data', 2)
                ->where('filters.search', 'Website')
                ->where('filters.status', ProjectStatus::ACTIVE->value)
                ->where('status', array_map(fn($case) => $case->value, ProjectStatus::cases()))
        );
    }
}
