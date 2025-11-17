<?php

namespace App\Admin\Repositories\PriceList;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface PriceListRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
    public function findByValue($value);
}
