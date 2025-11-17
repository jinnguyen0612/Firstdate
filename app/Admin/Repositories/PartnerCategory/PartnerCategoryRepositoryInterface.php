<?php

namespace App\Admin\Repositories\PartnerCategory;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface PartnerCategoryRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
    public function searchAllLimit(string $keySearch = '', array $meta = [], array $select = ['id', 'name'], int $limit = 10, int $role = 0);
}
