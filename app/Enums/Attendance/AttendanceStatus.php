<?php

namespace App\Enums\Attendance;

use App\Supports\Enum;

enum AttendanceStatus: string
{
    use Enum;
    case NotStart = 'not_start';
    case Present = 'present';
    case Absent = 'absent';

    public function badge(): string
    {
        return match ($this) {
            self::NotStart => 'bg-blue',
            self::Present => 'bg-green',
            self::Absent => 'bg-red',
        };
    }
}
