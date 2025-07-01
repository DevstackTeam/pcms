<?php

namespace Tests\Unit;

use App\Enums\ProjectStatus;
use App\Http\Requests\ProjectRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProjectRequestTest extends TestCase
{
    private array $rules;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rules = (new ProjectRequest())->rules();
    }

    #[Test]
    public function test_passes_validation_with_valid_data()
    {
        $data = [
            'name' => 'Web Redesign',
            'description' => 'This is a test project.',
            'client' => 'Acme Inc.',
            'status' => ProjectStatus::ACTIVE->value,
        ];

        $validator = Validator::make($data, $this->rules);

        $this->assertTrue($validator->passes());
    }

    #[Test]
    public function test_fails_validation_with_invalid_status()
    {
        $data = [
            'name' => 'Project Beta',
            'description' => 'Invalid status test.',
            'client' => 'Beta Corp',
            'status' => 'Invalid Status',
        ];

        $validator = Validator::make($data, $this->rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('status', $validator->errors()->toArray());
    }

    #[Test]
    public function test_fails_validation_with_missing_required_fields()
    {
        $data = [
            'name' => null,
            'description' => 'Test description',
            'client' => null,
            'status' => null,
        ];

        $validator = Validator::make($data, $this->rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
        $this->assertArrayHasKey('client', $validator->errors()->toArray());
        $this->assertArrayHasKey('status', $validator->errors()->toArray());
    }

    #[Test]
    public function test_passes_validation_with_nullable_description()
    {
        $data = [
            'name' => 'Keje.my',
            'description' => null,
            'client' => 'Devstack',
            'status' => ProjectStatus::NOT_STARTED->value,
        ];

        $validator = Validator::make($data, $this->rules);

        $this->assertTrue($validator->passes());
    }
}
