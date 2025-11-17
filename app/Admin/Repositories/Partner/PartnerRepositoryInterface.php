<?php

namespace App\Admin\Repositories\Partner;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface PartnerRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
    public function searchAllLimit(string $keySearch, array $meta = [], array $select, int $limit);

}
