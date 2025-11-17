<?php

namespace App\Admin\Repositories\Notification;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface NotificationRepositoryInterface extends EloquentRepositoryInterface
{
    public function getByAdminIdAndPaginate($adminId);
    public function getByUserIdAndPaginate($userId);
    public function getByPartnerIdAndPaginate($page = 1, $perPage = 10);
    public function readAllByPartnerId();
    public function deleteByPartnerId();
    public function getUnreadByPartnerId();
    public function multipleAction($action, $ids);
    
}
