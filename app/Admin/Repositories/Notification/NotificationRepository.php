<?php

namespace App\Admin\Repositories\Notification;

use App\Admin\Repositories\EloquentRepository;
use App\Enums\Notification\NotificationStatus;
use App\Models\Notification;

class NotificationRepository extends EloquentRepository implements NotificationRepositoryInterface
{

    public function getModel(): string
    {
        return Notification::class;
    }

    public function getByAdminIdAndPaginate($adminId)
    {
        return $this->model->where('admin_id', $adminId)->orderBy('created_at', 'DESC')->paginate(4);
    }

    public function getByUserIdAndPaginate($userId)
    {
        return $this->model->where('user_id', $userId)->orderBy('created_at', 'DESC')->paginate(10);
    }

    public function getByPartnerIdAndPaginate($page = 1, $perPage = 10)
    {
        return $this->model->whereNotNull('partner_id')->orderBy('created_at', 'DESC')->paginate($perPage, ['*'], 'page', $page);
    }

    public function getUnreadByPartnerId()
    {
        return $this->model->whereNotNull('partner_id')->where('status', NotificationStatus::NOT_READ)->orderBy('created_at', 'DESC')->get();
    }

    public function readAllByPartnerId()
    {
        return $this->model->whereNotNull('partner_id')->update(['status' => NotificationStatus::READ, 'read_at' => now()]);
    }

    public function deleteByPartnerId()
    {
        return $this->model->whereNotNull('partner_id')->where('status', NotificationStatus::READ)->delete();
    }

    public function multipleAction($action, $ids) 
    {
        if($action == 'read') {
            return $this->model->whereIn('id', $ids)->update(['status' => NotificationStatus::READ, 'read_at' => now()]);
        }
        if($action == 'delete') {
            return $this->model->whereIn('id', $ids)->delete();
        }
    }
}
