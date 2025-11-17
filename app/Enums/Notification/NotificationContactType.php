<?php

namespace App\Enums\Notification;

use App\Supports\Enum;

enum NotificationContactType: int
{
    use Enum;
    case SMS = 1;
    case EMAIL = 2;
    case PUSHNOTIFICATION = 3;
}
