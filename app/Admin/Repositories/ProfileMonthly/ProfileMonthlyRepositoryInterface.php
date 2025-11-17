<?php

namespace App\Admin\Repositories\ProfileMonthly;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface ProfileMonthlyRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
}
