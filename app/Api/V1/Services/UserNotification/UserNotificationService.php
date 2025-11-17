<?php

namespace App\Api\V1\Services\UserNotification;

use App\Api\V1\Repositories\UserNotification\UserNotificationRepositoryInterface;
use App\Models\UserNotification;
use App\Enums\Notification\{NotificationType, NotificationStatus, NotificationContactType};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enums\UserNotification\UserNotificationStatus;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;

class UserNotificationService implements UserNotificationServiceInterface
{
    protected $repository;

    public function __construct(UserNotificationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Cập nhật cài đặt thông báo của user_receiver.
     * Nếu có thay đổi is_push_notification thì sẽ gửi yêu cầu xác nhận từ user A sang user B.
     */
    public function update(Request $request, $user_receiver_id)
    {
        // Lấy dữ liệu cần cập nhật
        $data = $request->only(['is_sms_notification', 'is_email_notification', 'is_push_notification']);
        // Lấy thông tin user đang đăng nhập (người gửi)
        $userSenderId = auth()->user()->id;

        DB::beginTransaction();
        try {
            $notification = UserNotification::where('user_receiver_id', $user_receiver_id)
                ->where('user_sender_id', $userSenderId)
                ->first();

            if (!$notification) {
                throw new \Exception('Notification setting not found.');
            }

            $isPushRequested = array_key_exists('is_push_notification', $data) && $data['is_push_notification'] == true;
            if ($isPushRequested) {
                // Nếu có, đặt push notification về chưa kích hoạt (0) và trạng thái PENDING
                $data['is_push_notification']     = 0;
                $data['status_push_notification'] = UserNotificationStatus::PENDING;
            }

            $notification->update($data);

            // Nếu có yêu cầu thay đổi push, gửi yêu cầu xác nhận sang user B
            if ($isPushRequested) {
                $this->handlePushNotification($notification);
            }

            DB::commit();
            return response()->json(['message' => 'User notification settings updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update notification settings: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update notification settings.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Gửi yêu cầu xác nhận bật push notification từ người gửi sang user_receiver.
     *
     * @param UserNotification $userNotification
     * @return void
     */
    private function handlePushNotification(UserNotification $userNotification)
    {
        // Lấy thông tin user receiver qua quan hệ receiver() trong model UserNotification
        $userReceiver = $userNotification->receiver;
        if ($userReceiver) {
            $message = "User {$userNotification->user_sender_id} đã yêu cầu kích hoạt push notification. Vui lòng phê duyệt hoặc từ chối yêu cầu này.";
            $notificationData = [
                'user_id'         => $userReceiver->id,
                'title'           => 'Xác nhận bật thông báo đẩy',
                'message'         => $message,
                'notification_id' => $userNotification->id,
                'status'          => NotificationStatus::NOT_READ->value,
            ];
            // Tạo bản ghi thông báo gửi đến user_receiver
            Notification::create($notificationData);
        } else {
            Log::error("User receiver not found for notification ID: " . $userNotification->id);
        }
    }

    /**
     * Xử lý phê duyệt yêu cầu bật push notification từ user_receiver.
     * Người gửi được xác định từ auth()->user().
     *
     * @param mixed $user_receiver_id
     * @return array
     *
     * @throws \Exception
     */
    public function approve($user_receiver_id)
    {
        // Lấy thông tin user đang đăng nhập (người gửi)
        $userSenderId = auth()->user()->id;

        DB::beginTransaction();
        try {
            $userNotification = UserNotification::where('user_receiver_id', $user_receiver_id)
                ->where('user_sender_id', $userSenderId)
                ->first();
            if (!$userNotification) {
                throw new \Exception('Notification setting not found.');
            }

            $userNotification->update([
                'status_push_notification' => UserNotificationStatus::APPROVED,
                'is_push_notification'     => 1,
            ]);

            $fullname = $userNotification->receiver->fullname ?? 'User';

            // Tạo thông báo gửi về cho người gửi (user_sender)
            $senderNotificationData = [
                'user_id'         => $userNotification->user_sender_id,
                'title'           => 'Yêu cầu bật push notification đã được duyệt',
                'message'         => "{$fullname} đã phê duyệt yêu cầu bật push notification của bạn.",
                'notification_id' => $userNotification->id,
                'status'          => NotificationStatus::NOT_READ->value,
            ];
            Notification::create($senderNotificationData);

            DB::commit();
            return [
                'success' => true,
                'message' => "{$fullname} approved your request.",
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to approve notification: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Xử lý từ chối yêu cầu bật push notification từ user_receiver.
     * Người gửi được xác định từ auth()->user().
     *
     * @param mixed $user_receiver_id
     * @return array
     *
     * @throws \Exception
     */
    public function reject($user_receiver_id)
    {
        // Lấy thông tin user đang đăng nhập (người gửi)
        $userSenderId = auth()->user()->id;

        DB::beginTransaction();
        try {
            $userNotification = UserNotification::where('user_receiver_id', $user_receiver_id)
                ->where('user_sender_id', $userSenderId)
                ->first();
            if (!$userNotification) {
                throw new \Exception('Notification setting not found.');
            }

            $userNotification->update([
                'status_push_notification' => UserNotificationStatus::REJECTED,
                'is_push_notification'     => 0,
            ]);

            $fullname = $userNotification->receiver->fullname ?? 'User';

            // Tạo thông báo gửi về cho người gửi (user_sender)
            $senderNotificationData = [
                'user_id'         => $userNotification->user_sender_id,
                'title'           => 'Yêu cầu bật push notification đã bị từ chối',
                'message'         => "{$fullname} đã từ chối yêu cầu bật push notification của bạn.",
                'notification_id' => $userNotification->id,
                'status'          => NotificationStatus::NOT_READ->value,
            ];
            Notification::create($senderNotificationData);

            DB::commit();
            return [
                'success' => true,
                'message' => "{$fullname} rejected your request.",
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to reject notification: " . $e->getMessage());
            throw $e;
        }
    }
}
