<?php

namespace App\Admin\Repositories\Package;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Package\PackageRepositoryInterface;
use App\Models\Package;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PackageRepository extends EloquentRepository implements PackageRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return Package::class;
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function findByValue($value): ?Package
    {
        $this->getQueryBuilder();
        return $this->instance->where('value', $value)->first();
    }
}
