<?php

namespace App\Admin\Repositories\RejectReason;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface RejectReasonRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
}
