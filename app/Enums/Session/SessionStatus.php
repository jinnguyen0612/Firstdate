<?php

namespace App\Enums\Session;

use App\Supports\Enum;

enum SessionStatus: string
{
    use Enum;
    case Pending = 'pending';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function badge(): string
    {
        return match ($this) {
            self::Pending => 'bg-blue',
            self::Completed => 'bg-green',
            self::Cancelled => 'bg-red',
        };
    }
}
