<?php

namespace App\Admin\Repositories\Admin;

use App\Admin\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface AdminRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * make query
     *
     * @return mixed
     */
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
    public function getAllRoles();
    public function searchAllLimit(string $keySearch = '', array $meta = [], array $select = ['id', 'fullname', 'email'], int $limit = 10, int $role = 0): Collection;
}
