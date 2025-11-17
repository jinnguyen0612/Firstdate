<?php

namespace App\Api\V1\Services\Notification;

use App\Models\Notification;
use Illuminate\Support\Facades\Request;

interface NotificationServiceInterface
{

    public function soundNotification($location, $type);

    public function speedNotification($location, $type);
}
