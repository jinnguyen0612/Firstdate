<?php

namespace App\Api\V1\Repositories\Teacher;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface TeacherRepositoryInterface extends EloquentRepositoryInterface
{
    public function getTeacherPaginate($search, $limit);

}