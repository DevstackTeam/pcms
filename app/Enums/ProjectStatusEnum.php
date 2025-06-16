<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self Active()
 * @method static self Completed()
 * @method static self NotStarted()
 */
final class ProjectStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'Active' => 'active',
            'Completed' => 'completed',
            'NotStarted' => 'not started',
        ];
    }

    protected static function labels(): array
    {
        return [
            'Active' => 'Active',
            'Completed' => 'Completed',
            'NotStarted' => 'Not Started',
        ];
    }
}
