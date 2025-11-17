<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

trait SendMail
{
    use HasRepositoryFromAdmin;

    /**
     * Gửi mail đến danh sách người nhận.
     *
     * @param array $recipients Danh sách thông tin người nhận (mỗi phần tử chứa 'email').
     * @param Mailable $notification Instance của lớp Mailable cần gửi.
     */
    public function sendMail(array $recipients, Mailable $instance)
    {
        $notificateRepository = $this->getNotificationRepository();
        // Giả sử đối tượng $notification có thuộc tính instance chứa ID thông báo
        // $notificate = $notificateRepository->findOrFail($instance->id);

        foreach ($recipients as $recipient) {
            if (isset($recipient['email']) && filter_var($recipient['email'], FILTER_VALIDATE_EMAIL)) {
                Mail::to($recipient['email'])->send(clone $instance);
            }
        }
    }
}
