<?php

namespace App\Admin\Repositories\Deal;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface DealRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
    public function findOrFailWithRelation($id, $relations);
}
