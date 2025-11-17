<?php

namespace App\Api\V1\Repositories\User;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    public function getUserPaginate($search, $limit);
    public function getUserNearBy($userId, $paginate);
}