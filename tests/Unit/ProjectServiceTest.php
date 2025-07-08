<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use App\Services\ProjectService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Enums\ProjectStatus;
use PHPUnit\Framework\Attributes\Test;


class ProjectServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_project_with_valid_data()
    {
        // Arrange: create and authenticate user
        $user = User::factory()->create();
        $this->actingAs($user);

        $service = new ProjectService();

        // Act: call the service method with valid data
        $project = $service->store([
            'name' => 'PCMS System',
            'description' => 'Manages costing projects',
            'client' => 'ABC Corp',
            'status' => ProjectStatus::ACTIVE->value,
        ]);

        // Assert: project is in DB and has expected data
        $this->assertDatabaseHas('projects', [
            'name' => 'PCMS System',
            'description' => 'Manages costing projects',
            'client' => 'ABC Corp',
            'status' => ProjectStatus::ACTIVE->value,
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Project::class, $project);
        $this->assertEquals('PCMS System', $project->name);
        $this->assertEquals('ABC Corp', $project->client);
    }
}
