<?php

namespace App\Admin\Repositories\AppTitle;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface AppTitleRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
}
