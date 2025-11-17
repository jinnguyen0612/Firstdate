<?php

namespace App\Admin\Repositories\User;

use App\Admin\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    public function searchAllLimit(string $keySearch, array $meta, array $select, int $limit);
    public function getQueryBuilderOrderBy(string $column = 'id', string $sort = 'DESC');
    public function findOrFailWithRelation($id, $relation);
}
