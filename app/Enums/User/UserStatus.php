<?php

namespace App\Enums\User;

use App\Admin\Support\Enum;

enum UserStatus: string
{
    use Enum;

    case Active = 'active';
    case Inactive = 'inactive';
    case Draft = 'draft';
    case Locked = 'locked';

    public function badge(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'danger',
            self::Draft => 'warning',
            self::Locked => 'dark',
        };
    }
}
