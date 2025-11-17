<?php

namespace App\Enums\Classroom;

use App\Supports\Enum;

enum ClassroomType: string
{
    use Enum;
    case Group = 'group';
    case OneToOne = 'one_to_one';

    public function badge(): string
    {
        return match ($this) {
            self::Group => 'bg-blue',
            self::OneToOne => 'bg-green',
        };
    }
}
