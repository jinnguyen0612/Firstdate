<?php

namespace App\Admin\Repositories\AppTitleVideo;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface AppTitleVideoRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
}
