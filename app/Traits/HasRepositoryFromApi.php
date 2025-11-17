<?php

namespace App\Traits;

use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Api\V1\Repositories\Post\PostRepositoryInterface;
use App\Api\V1\Repositories\Notification\NotificationRepositoryInterface;

trait HasRepositoryFromApi
{
    protected function getSettingRepository()
    {
        return app(SettingRepositoryInterface::class);
    }

    protected function getPostRepository()
    {
        return app(PostRepositoryInterface::class);
    }

    protected function getNotificationRepository()
    {
        return app(NotificationRepositoryInterface::class);
    }
}
