<?php

namespace App\Admin\Repositories\ProfileMonthly;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\ProfileMonthly\ProfileMonthlyRepositoryInterface;
use App\Models\ProfileMonthly;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProfileMonthlyRepository extends EloquentRepository implements ProfileMonthlyRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return ProfileMonthly::class;
    }
    
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }
}
