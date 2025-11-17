<?php

namespace App\Enums;

use App\Supports\Enum;

enum WithdrawStatus: int
{
    use Enum;

    case Pending = 1;
    case Confirmed = 2;
    case Cancelled = 3;

    public function badge(): string
    {
        return match ($this) {
            self::Confirmed => 'bg-green',
            self::Cancelled => 'bg-red',
            self::Pending => 'bg-orange',
        };
    }
}
