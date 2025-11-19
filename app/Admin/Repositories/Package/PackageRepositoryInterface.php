<?php

namespace App\Admin\Repositories\Package;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface PackageRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
    public function findByValue($value);
}
