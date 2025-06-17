<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case COMPLETED = 'Completed';
    case ACTIVE = 'Active';
    case NOT_STARTED = 'Not Started';
}
