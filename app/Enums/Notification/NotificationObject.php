<?php

namespace App\Enums\Notification;

use App\Supports\Enum;

enum NotificationObject: string
{
    use Enum;
    
    case All = 'all';
    case Partner = 'partner';
    case User = 'user';
    case Only = 'only'; // chỉ định
}
