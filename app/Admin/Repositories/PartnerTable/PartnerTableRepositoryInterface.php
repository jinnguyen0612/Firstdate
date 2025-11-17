<?php

namespace App\Admin\Repositories\PartnerTable;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface PartnerTableRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
    public function searchAllLimit($code , string $keySearch = '', array $meta = [], array $select = ['id', 'name'], int $limit = 10, int $role = 0);
}
