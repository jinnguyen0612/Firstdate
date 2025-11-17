<?php

namespace App\Enums\User;


use App\Supports\Enum;

enum DatingTime: string
{
    use Enum;

    case From8To12 = "08:00-12:00";
    case From12To16 = "12:00-16:00";
    case From16To19 = "16:00-19:00";
    case From19To22 = "19:00-22:00";
    case After22 = "After22:00";

    public function color(): string
    {
        return match ($this) {
            self::From8To12 => 'yellow',
            self::From12To16 => 'red',
            self::From16To19 => 'orange',
            self::From19To22 => 'purple',
            self::After22 => 'blue',
        };
    }
}
