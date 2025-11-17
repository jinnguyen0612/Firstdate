<?php

namespace App\Admin\Repositories\AppTitle;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\AppTitle\AppTitleRepositoryInterface;
use App\Models\AppTitle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AppTitleRepository extends EloquentRepository implements AppTitleRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return AppTitle::class;
    }
    
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }
}
