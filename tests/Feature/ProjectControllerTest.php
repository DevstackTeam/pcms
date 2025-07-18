<?php

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('renders projects index page with all projects list', function () {
    Project::factory(5)->create([
        'user_id' => $this->user->id,
    ]);

    $response = $this->get(route('projects.index'));

    $response->assertInertia(fn ($page) =>
        $page->component('Projects/Index')
            ->has('projects.data', 5)
    );
});

test('renders projects index page with searched projects', function () {
    Project::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Project Alpha',
    ]);

    Project::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Project Beta',
    ]);

    Project::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Project Gamma',
    ]);

    Project::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Alpha Omega',
    ]);

    $response = $this->get(route('projects.index', ['search' => 'Alpha']));

    $response->assertInertia(fn ($page) =>
        $page->component('Projects/Index')
            ->has('projects.data', 2)
            ->where('projects.data.0.name', 'Project Alpha')
            ->where('projects.data.1.name', 'Alpha Omega')
    );
});

test('renders projects index page with projects filtered by status', function () {
    Project::factory()->create([
        'user_id' => $this->user->id,
        'status' => ProjectStatus::NOT_STARTED->value,
    ]);

    Project::factory()->create([
        'user_id' => $this->user->id,
        'status' => ProjectStatus::ACTIVE->value,
    ]);

    Project::factory()->create([
        'user_id' => $this->user->id,
        'status' => ProjectStatus::ACTIVE->value,
    ]);

    Project::factory()->create([
        'user_id' => $this->user->id,
        'status' => ProjectStatus::ACTIVE->value,
    ]);

    $response = $this->get(route('projects.index', ['status' => ProjectStatus::ACTIVE->value]));

    $response->assertInertia(fn ($page) =>
        $page->component('Projects/Index')
            ->has('projects.data', 3)
            ->where('projects.data.0.status', ProjectStatus::ACTIVE->value)
            ->where('projects.data.1.status', ProjectStatus::ACTIVE->value)
            ->where('projects.data.2.status', ProjectStatus::ACTIVE->value)
    );
});

test('renders projects index page with searched projects and filtered by status', function () {
    Project::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Website Redesign',
        'status' => ProjectStatus::NOT_STARTED->value,
    ]);

    Project::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Website Revamp',
        'status' => ProjectStatus::ACTIVE->value,
    ]);

    Project::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Mobile App',
        'status' => ProjectStatus::COMPLETED->value,
    ]);

    Project::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Website Launch',
        'status' => ProjectStatus::ACTIVE->value,
    ]);

    $response = $this->get(route('projects.index', [
        'search' => 'Web',
        'status' => ProjectStatus::ACTIVE->value,
    ]));

    $response->assertInertia(fn ($page) =>
        $page->component('Projects/Index')
            ->has('projects.data', 2)
            ->where('projects.data.0.name', 'Website Revamp')
            ->where('projects.data.0.status', ProjectStatus::ACTIVE->value)
            ->where('projects.data.1.name', 'Website Launch')
            ->where('projects.data.1.status', ProjectStatus::ACTIVE->value)
    );
});

test('renders projects create page with project status enum', function () {
    $response = $this->get(route('projects.create'));

    $response->assertInertia(fn ($page) =>
        $page->component('Projects/Create')
            ->has('status', count(ProjectStatus::cases()))
    );
});

test('redirects user to projects show page after creating project', function () {
    $data = [
        'name' => 'New Project',
        'description' => 'Project description',
        'client' => 'Client Name',
        'status' => ProjectStatus::NOT_STARTED->value,
    ];

    $response = $this->post(route('projects.store', $data));

    $project = Project::first();

    $response->assertStatus(302);
    $response->assertRedirect(route('projects.show', $project->id));
});

test('displays success message after creating project', function () {
    $data = [
        'name' => 'New Project',
        'description' => 'Project description',
        'client' => 'Client Name',
        'status' => ProjectStatus::NOT_STARTED->value,
    ];

    $response = $this->post(route('projects.store', $data));

    $response->assertSessionHas('success', 'Project created successfully.');
});

test('renders projects show page with correct project data', function () {
    $project = Project::factory()->create([
        'user_id' => $this->user->id
    ]);

    $response = $this->get(route('projects.show', $project->id));

    $response->assertInertia(fn ($page) =>
        $page->component('Projects/Show')
            ->has('project')
            ->where('project.id', $project->id)
            ->where('project.name', $project->name)
            ->where('project.description', $project->description)
            ->where('project.client', $project->client)
            ->where('project.status', $project->status)
    );
});

test('renders projects edit page with correct project data and project status enum', function () {
    $project = Project::factory()->create([
        'user_id' => $this->user->id
    ]);

    $response = $this->get(route('projects.edit', $project->id));

    $response->assertInertia(fn ($page) =>
        $page->component('Projects/Edit')
            ->has('project')
            ->where('project.id', $project->id)
            ->where('project.name', $project->name)
            ->where('project.description', $project->description)
            ->where('project.client', $project->client)
            ->where('project.status', $project->status)
            ->has('status')
    );
});

test('redirects user to projects show page after updating project', function () {
    $project = Project::factory()->create([
        'user_id' => $this->user->id
    ]);

    $data = [
        'name' => 'Updated Project',
        'description' => 'Updated description',
        'client' => 'Updated Client',
        'status' => ProjectStatus::ACTIVE->value,
    ];

    $response = $this->patch(route('projects.update', $project->id), $data);

    $response->assertStatus(302);
    $response->assertRedirect(route('projects.show', $project->id));
});

test('displays success message after updating project', function () {
    $project = Project::factory()->create([
        'user_id' => $this->user->id
    ]);

    $data = [
        'name' => 'Updated Project',
        'description' => 'Updated description',
        'client' => 'Updated Name',
        'status' => ProjectStatus::NOT_STARTED->value,
    ];

    $response = $this->patch(route('projects.update', $project->id), $data);

    $response->assertSessionHas('success', 'Project updated successfully.');
});

test('redirects user to projects index page after deleting project', function () {
    $project = Project::factory()->create([
        'user_id' => $this->user->id
    ]);

    $response = $this->delete(route('projects.destroy', $project->id));

    $response->assertStatus(302);
    $response->assertRedirect(route('projects.index'));
});

test('displays success message after deleting project', function () {
    $project = Project::factory()->create([
        'user_id' => $this->user->id
    ]);

    $response = $this->delete(route('projects.destroy', $project->id));

    $response->assertSessionHas('success', 'Project deleted successfully.');
});
