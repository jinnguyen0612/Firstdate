<?php

namespace App\Traits;

trait SendNotification
{
    use HasRepositoryFromAdmin, NotifiesViaFirebase;
    public function sendNotificationRecord($notificationRecord, $deviceToken): void
    {
        if ($notificationRecord && $deviceToken) {
            $this->sendFirebaseNotification(
                [$deviceToken],
                null,
                $notificationRecord->title,
                $notificationRecord->message,
                $notificationRecord->id
            );
        }
    }
}
