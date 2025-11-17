<?php

namespace App\Enums\Notification;

use App\Supports\Enum;

enum NotificationType: int
{
    use Enum;
    case Sound = 1;
    case Speed = 2;
    public static function getNotificationType()
    {
        return [
            self::Sound->value => 'Sound',
            self::Speed->value => 'Speed',
        ];
    }
}
