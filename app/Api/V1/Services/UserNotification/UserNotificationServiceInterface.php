<?php

namespace App\Api\V1\Services\UserNotification;

use Illuminate\Http\Request;

interface UserNotificationServiceInterface
{
    /**
     * Cập nhật
     *
     * @param Illuminate\Http\Request $request
     * @return boolean
     */
    public function update(Request $request, $user_receiver_id);

    public function approve($user_receiver_id);
    public function reject($user_receiver_id);
}
