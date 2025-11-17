<?php

namespace App\Enums\Classroom;

use App\Supports\Enum;

enum ClassroomFilter: string
{
    use Enum;
    case All = 'all';
    case Registered = 'registered';
    case NotRegister = 'not_register';
}
