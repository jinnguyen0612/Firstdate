<?php

namespace App\Admin\Services\Notification;

use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\Partner\PartnerRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Enums\Notification\NotificationObject;
use App\Enums\Notification\NotificationStatus;
use App\Traits\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class NotificationService implements NotificationServiceInterface
{
    use AuthService, SendNotification;

    protected $data;

    protected $repository;

    public function __construct(
        NotificationRepositoryInterface $repository,
        private PartnerRepositoryInterface $partnerRepository,
        private UserRepositoryInterface $userRepository,

    ) {
        $this->repository = $repository;
    }

    public function updateDeviceToken($request)
    {
        try {
            $data = $request->validate([
                'device_token' => 'required|string'
            ]);
            $user = $this->getCurrentUser();
            if ($user) {
                if ($user->device_token == null || $user->device_token != $data['device_token']) {
                    $this->userRepository->update($user->id, [
                        'device_token' => $data['device_token'],
                    ]);
                    return response()->json(['status' => 200, 'message' => 'Update device token success.'], 200);
                } else {
                    return response()->json(['status' => 200, 'message' => 'Device token is up to date.'], 200);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Failed to update token.', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $this->data = $request->validated();
        $this->data['status'] = NotificationStatus::NOT_READ->value;

        try {
            DB::beginTransaction();

            switch ($this->data['notification_object']) {
                case NotificationObject::Partner->value:
                    $this->notifyPartners($this->data['partner_ids'] ?? null);
                    break;

                case NotificationObject::User->value:
                    $this->notifyUsers($this->data['user_ids'] ?? null);
                    break;

                case NotificationObject::All->value:
                case NotificationObject::Only->value:
                    $this->notifyPartners($this->data['partner_ids'] ?? null);
                    $this->notifyUsers($this->data['user_ids'] ?? null);
                    break;
                default:
                    break;
            }

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            throw ($th);
            DB::rollBack();
            return false;
        }

        return true;
    }

    protected function notifyPartners(?array $partnerIds = null)
    {
        if (empty($partnerIds)) {
            $partnerIds = $this->partnerRepository->getQueryBuilder()->pluck('id')->all();
        }
        foreach ($partnerIds as $partnerId) {
            $this->data['partner_id'] = $partnerId;
            $partner = $this->partnerRepository->find($partnerId);
            unset($this->data['user_id']);
            $notification = $this->repository->create($this->data);
            $this->sendNotificationRecord($notification, $partner->device_token);
        }
        unset($this->data['partner_id']);
    }

    protected function notifyUsers(?array $userIds = null)
    {
        if (empty($userIds)) {
            $userIds = $this->userRepository->getQueryBuilder()->pluck('id')->all();
        }

        foreach ($userIds as $userId) {
            $this->data['user_id'] = $userId;
            $user = $this->userRepository->find($userId);
            unset($this->data['partner_id']);
            $notification = $this->repository->create($this->data);
            $this->sendNotificationRecord($notification, $user->device_token);
        }

        unset($this->data['user_id']);
    }


    public function update(Request $request): object|bool
    {

        $this->data = $request->validated();

        return $this->repository->update($this->data['id'], $this->data);
    }

    public function delete($id): object|bool
    {
        return $this->repository->delete($id);
    }
}
