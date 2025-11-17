<?php

namespace App\Admin\Repositories\PriceList;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\PriceList\PriceListRepositoryInterface;
use App\Models\PriceList;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PriceListRepository extends EloquentRepository implements PriceListRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return PriceList::class;
    }
    
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function findByValue($value): ?PriceList
    {
        $this->getQueryBuilder();
        return $this->instance->where('value', $value)->first();
    }
}
