<?php

namespace App\Enums\Reschedule;

use App\Supports\Enum;

enum RescheduleStatus: string
{
    use Enum;
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function badge(): string
    {
        return match ($this) {
            self::Pending => 'bg-blue',
            self::Approved => 'bg-green',
            self::Rejected => 'bg-red',
        };
    }
}
