<?php

namespace Tests\Unit;

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\User;
use App\Services\ProjectService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProjectServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ProjectService $service;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->service = new ProjectService();
    }

    #[Test]
    public function test_stores_a_project()
    {
        $data = [
            'name' => 'Mobile App',
            'description' => 'Test Description',
            'client' => 'Petronas',
            'status' => ProjectStatus::ACTIVE->value,
        ];

        $project = $this->service->store($data);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'user_id' => $project->user_id,
            'name' => 'Mobile App',
            'description' => 'Test Description',
            'client' => 'Petronas',
            'status' => ProjectStatus::ACTIVE->value,
        ]);

        $this->assertInstanceOf(Project::class, $project);
    }

    #[Test]
    public function test_updates_a_project()
    {
        $project = $this->user->projects()->create([
            'name' => 'Old Name',
            'description' => 'Old Description',
            'client' => 'Old Client',
            'status' => ProjectStatus::NOT_STARTED->value,
        ]);

        $data = [
            'name' => 'New Name',
            'description' => 'New Description',
            'client' => 'New Client',
            'status' => ProjectStatus::COMPLETED->value,
        ];

        $updated = $this->service->update($project, $data);

        $this->assertEquals('New Name', $updated->name);
        $this->assertEquals('New Description', $updated->description);
        $this->assertEquals('New Client', $updated->client);
        $this->assertEquals(ProjectStatus::COMPLETED, $updated->status);
    }

    #[Test]
    public function test_searches_projects_by_name_and_status()
    {
        $this->user->projects()->create([
            'name' => 'Website Redesign',
            'description' => 'Redesigning the company website',
            'client' => 'TechCorp',
            'status' => ProjectStatus::ACTIVE->value,
        ]);

        $this->user->projects()->create([
            'name' => 'Mobile App Development',
            'description' => 'Building a new mobile app',
            'client' => 'Devstack',
            'status' => ProjectStatus::NOT_STARTED->value,
        ]);

        $this->user->projects()->create([
            'name' => 'E-commerce Platform',
            'description' => 'Trusted e-commerce platform',
            'client' => 'Amazon',
            'status' => ProjectStatus::ACTIVE->value,
        ]);

        $results = $this->service->search('Website', 'Active');

        $this->assertCount(1, $results); 
    }

    #[Test]
    public function test_searches_projects_by_name_only()
    {
        $this->user->projects()->create([
            'name' => 'Web App Redesign',
            'description' => 'Redesigning the company website',
            'client' => 'TechCorp',
            'status' => ProjectStatus::ACTIVE->value,
        ]);

        $this->user->projects()->create([
            'name' => 'Mobile App Development',
            'description' => 'Building a new mobile app',
            'client' => 'Devstack',
            'status' => ProjectStatus::NOT_STARTED->value,
        ]);

        $this->user->projects()->create([
            'name' => 'E-commerce Platform',
            'description' => 'Trusted e-commerce platform',
            'client' => 'Amazon',
            'status' => ProjectStatus::ACTIVE->value,
        ]);

        $this->user->projects()->create([
            'name' => 'Online Banking App',
            'description' => 'Easy online banking',
            'client' => 'Maybank',
            'status' => ProjectStatus::COMPLETED->value,
        ]);

        $results = $this->service->search('App', '');

        $this->assertCount(3, $results); 
    }

    #[Test]
    public function test_searches_projects_by_status_only()
    {
        $this->user->projects()->create([
            'name' => 'Web App Redesign',
            'description' => 'Redesigning the company website',
            'client' => 'TechCorp',
            'status' => ProjectStatus::ACTIVE->value,
        ]);

        $this->user->projects()->create([
            'name' => 'Mobile App Development',
            'description' => 'Building a new mobile app',
            'client' => 'Devstack',
            'status' => ProjectStatus::NOT_STARTED->value,
        ]);

        $this->user->projects()->create([
            'name' => 'E-commerce Platform',
            'description' => 'Trusted e-commerce platform',
            'client' => 'Amazon',
            'status' => ProjectStatus::ACTIVE->value,
        ]);

        $this->user->projects()->create([
            'name' => 'Online Banking App',
            'description' => 'Easy online banking',
            'client' => 'Maybank',
            'status' => ProjectStatus::COMPLETED->value,
        ]);

        $results = $this->service->search('', 'Active');

        $this->assertCount(2, $results); 
    }

    #[Test]
    public function test_search_return_empty_when_no_results_found()
    {
        $this->user->projects()->create([
            'name' => 'Web App Redesign',
            'description' => 'Redesigning the company website',
            'client' => 'TechCorp',
            'status' => ProjectStatus::ACTIVE->value,
        ]);

        $this->user->projects()->create([
            'name' => 'Mobile App Development',
            'description' => 'Building a new mobile app',
            'client' => 'Devstack',
            'status' => ProjectStatus::NOT_STARTED->value,
        ]);

        $this->user->projects()->create([
            'name' => 'E-commerce Platform',
            'description' => 'Trusted e-commerce platform',
            'client' => 'Amazon',
            'status' => ProjectStatus::ACTIVE->value,
        ]);

        $this->user->projects()->create([
            'name' => 'Online Banking App',
            'description' => 'Easy online banking',
            'client' => 'Maybank',
            'status' => ProjectStatus::COMPLETED->value,
        ]);

        $results = $this->service->search('Keje.my', 'Not Started');

        $this->assertEmpty($results); 
    }
}
