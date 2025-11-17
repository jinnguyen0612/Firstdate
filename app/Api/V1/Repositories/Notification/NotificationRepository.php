<?php

namespace App\Api\V1\Repositories\Notification;

use App\Admin\Repositories\Notification\NotificationRepository as AdminNotificationRepository;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationRepository extends AdminNotificationRepository implements NotificationRepositoryInterface
{
    protected $model;

    public function __construct(Notification $note)
    {
        $this->model = $note;
    }

    public function get()
    {
        return $this->model->get();
    }

    public function detail($id)
    {
        return $this->model->detail($id);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function getUserNotifications($userId, Request $request)
    {
        $data = $request->all();

        $limit = isset($data['limit']) ? (int) $data['limit'] : 10;
        $status = $data['status'] ?? null;

        if (auth('user')->check()) {
            $query = $this->getByQueryBuilder(['user_id' => $userId]);
        } else {
            $query = $this->getByQueryBuilder(['partner_id' => $userId]);
        }

        if ($status) {
            $query->where('status', $status);
        }

        return $query->simplePaginate($limit);
    }
}
