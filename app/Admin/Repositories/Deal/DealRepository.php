<?php

namespace App\Admin\Repositories\Deal;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Deal\DealRepositoryInterface;
use App\Models\Deal;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DealRepository extends EloquentRepository implements DealRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return Deal::class;
    }
    
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function findOrFailWithRelation($id, $relations = ['user_female','user_male'])
    {
        return $this->model->with($relations)->findOrFail($id);
    }
}
