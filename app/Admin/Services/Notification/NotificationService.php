<?php

namespace App\Admin\Services\Notification;

use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\Partner\PartnerRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Enums\Notification\NotificationObject;
use App\Enums\Notification\NotificationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class NotificationService implements NotificationServiceInterface
{
    use AuthService;

    protected $data;

    protected $repository;

    public function __construct(
        NotificationRepositoryInterface $repository,
        private PartnerRepositoryInterface $partnerRepository,
        private UserRepositoryInterface $userRepository,

    ) {
        $this->repository = $repository;
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
            throw($th);
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
            unset($this->data['user_id']);
            $this->repository->create($this->data);
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
            unset($this->data['partner_id']);
            $this->repository->create($this->data);
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
