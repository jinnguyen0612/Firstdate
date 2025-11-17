<?php

namespace App\Api\V1\Services\Notification;

use App\Api\V1\Services\Notification\NotificationServiceInterface;
use App\Models\Notification;
use App\Enums\Notification\{NotificationType, NotificationStatus, NotificationContactType};
use App\Traits\SendMail;
use App\Traits\SendNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Mail\Mailable;
use App\Mail\SoundNotification;
use App\Mail\SpeedNotification;

class NotificationService implements NotificationServiceInterface
{
    use SendMail, SendNotification;

    protected $userRepository;

    public function __construct() {}

    /**
     * Xử lý thông báo chung cho các loại (âm thanh, tốc độ)
     *
     * @param  object   $user
     * @param  string   $location
     * @param  int      $type          Loại thông báo (1: sound, 2: speed)
     * @param  int      $contact_type  Phương thức liên hệ (2: email, 3: push)
     * @param  string   $mailableClass Lớp Mailable cần sử dụng (SoundNotification hoặc SpeedNotification)
     * @return void
     */
    private function processNotification($user, $location, $type, string $mailableClass): void
    {
        // Lấy danh sách người nhận và thông tin phương thức thông báo của user
        $recipients   = $this->userRepository->getNotificationRecipients($user->id);
        $checkMethods = $this->userRepository->getCheckMethod($user->id);

        // Xây dựng dữ liệu thông báo chung
        $data = [
            'user_id'  => $user->id,
            'title'    => $this->getNotificationTitle($type),
            'message'  => $this->getNotificationMessage($type, $user->fullname),
            'location' => $location ?: 'location',
            'status'   => NotificationStatus::NOT_READ->value,
            'type'     => $type,
        ];

        // Mapping giữa contact type và thuộc tính kiểm tra trong checkMethods
        $contactMapping = [
            NotificationContactType::EMAIL->value          => 'is_email_notification',
            NotificationContactType::SMS->value            => 'is_sms_notification',
            NotificationContactType::PUSHNOTIFICATION->value => 'is_push_notification',
        ];

        // Xác định các kiểu thông báo được bật (chỉ lặp 1 lần qua checkMethods)
        $enabledTypes = [];
        foreach ($checkMethods as $method) {
            foreach ($contactMapping as $contactType => $property) {
                if (!empty($method->$property) && $method->$property == 1) {
                    $enabledTypes[$contactType] = true;
                }
            }
        }

        // Với mỗi kiểu thông báo được bật, tạo notification record và gửi thông báo
        foreach (array_keys($enabledTypes) as $contactType) {
            $notification = Notification::create(array_merge($data, [
                'contact_type' => $contactType,
            ]));

            switch ($contactType) {
                case NotificationContactType::EMAIL->value:
                    /** @var Mailable $mailNotification */
                    $mailNotification = new $mailableClass($notification);
                    $this->sendMail($recipients->toArray(), $mailNotification);
                    break;

                case NotificationContactType::PUSHNOTIFICATION->value:
                    foreach ($recipients as $recipient) {
                        if (!empty($recipient->device_token)) {
                            $this->sendNotificationRecord($notification, $recipient->device_token);
                        }
                    }
                    break;

                // case NotificationContactType::SMS->value:
                //     foreach ($recipients as $recipient) {
                //         if (!empty($recipient->phone)) {
                //             $this->sendSms($recipient->phone, $data['message']);
                //         }
                //     }
                //     break;

                default:
                    Log::info('Invalid contact_type for notification.', ['contact_type' => $contactType]);
                    break;
            }
        }
    }

    /**
     * Trả về tiêu đề thông báo dựa trên loại thông báo.
     */
    private function getNotificationTitle($type): string
    {
        return match ($type) {
            NotificationType::Sound->value => 'Cảnh báo âm thanh lớn!',
            NotificationType::Speed->value => 'Cảnh báo tốc độ cao!',
            default                        => 'Thông báo khác',
        };
    }

    /**
     * Trả về nội dung thông báo dựa trên loại thông báo và tên người dùng.
     */
    private function getNotificationMessage($type, string $fullname): string
    {
        return match ($type) {
            NotificationType::Sound->value => "Cứu {$fullname}, vừa phát hiện âm thanh vượt ngưỡng, có khả năng xảy ra tai nạn.",
            NotificationType::Speed->value => "{$fullname} đang chạy vượt quá tốc độ, có khả năng xảy ra tai nạn.",
            default                        => "Thông báo của {$fullname}",
        };
    }


    /**
     * Thông báo âm thanh (Sound Notification)
     *
     * @param  string $location
     * @param  int    $type          (chỉ được tạo khi type = 1)
     * @param  int    $contact_type
     * @return JsonResponse
     */
    public function soundNotification($location, $type): JsonResponse
    {
        $user = auth()->user();
        if (!$user || !$user->isSound) {
            return response()->json([
                'status'  => 400,
                'message' => 'User not authorized for sound notifications.'
            ], 400);
        }

        // Nếu $type khác 1, chặn tạo notification
        if ($type != NotificationType::Sound->value) {
            Log::info("Sound notification not created because type is not sound.", ['type' => $type]);
            return response()->json([
                'status'  => 400,
                'message' => 'Invalid notification type for sound notifications.'
            ], 400);
        }

        try {
            DB::transaction(function () use ($user, $location, $type) {
                $this->processNotification($user, $location, $type, SoundNotification::class);
            });
            return response()->json([
                'status'  => 200,
                'message' => 'Sound notification sent successfully.'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in soundNotification: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'status'  => 500,
                'message' => 'Error sending notification.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Thông báo tốc độ (Speed Notification)
     *
     * @param  string $location
     * @param  int    $type          (chỉ được tạo khi type = 2)
     * @param  int    $contact_type
     * @return JsonResponse
     */
    public function speedNotification($location, $type): JsonResponse
    {
        $user = auth()->user();
        if (!$user || !$user->isSpeed) {
            return response()->json([
                'status'  => 400,
                'message' => 'User not authorized for speed notifications.'
            ], 400);
        }

        // Nếu $type khác 2, chặn tạo notification
        if ($type != NotificationType::Speed->value) {
            Log::info("Speed notification not created because type is not speed.", ['type' => $type]);
            return response()->json([
                'status'  => 400,
                'message' => 'Invalid notification type for speed notifications.'
            ], 400);
        }

        try {
            DB::transaction(function () use ($user, $location, $type) {
                $this->processNotification($user, $location, $type, SpeedNotification::class);
            });
            return response()->json([
                'status'  => 200,
                'message' => 'Speed notification sent successfully.'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in speedNotification: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'status'  => 500,
                'message' => 'Error sending notification.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
