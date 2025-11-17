<?php

namespace App\Api\V1\Repositories\Deal;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface DealRepositoryInterface extends EloquentRepositoryInterface
{
    public function findOrFailWithStatus($id, $status = null);
    public function getDealByCurrentUser($limit = 10);
    public function findDeal($id);
    public function getDeal($user_id);
}