<?php

namespace App\Enums\User;


use App\Supports\Enum;

enum Relationship: string
{
    use Enum;

    case SeriousDating = "serious_dating";
    case CasualDating = "casual_dating";
    case LookingForFriends = "looking_for_friends";

    public function color(): string
    {
        return match ($this) {
            self::SeriousDating => 'green',
            self::CasualDating => 'pink',
            self::LookingForFriends => 'purple',
        };
    }

}
