<?php

namespace App\Enums\Classroom;

use App\Supports\Enum;

enum ClassroomStatus: string
{
    use Enum;
    case NotStarted = 'not_started';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function badge(): string
    {
        return match ($this) {
            self::NotStarted => 'bg-gray',
            self::InProgress => 'bg-blue',
            self::Completed => 'bg-green',
            self::Cancelled => 'bg-red',
        };
    }
}
