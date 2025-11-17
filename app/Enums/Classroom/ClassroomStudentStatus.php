<?php

namespace App\Enums\Classroom;

use App\Supports\Enum;

enum ClassroomStudentStatus: int
{
    use Enum;
    case Active = 1;
    case InActive = 2;

    public function badge(): string
    {
        return match ($this) {
            self::Active => 'bg-blue',
            self::InActive => 'bg-green',
        };
    }
}
