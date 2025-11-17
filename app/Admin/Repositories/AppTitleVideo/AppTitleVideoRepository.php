<?php

namespace App\Admin\Repositories\AppTitleVideo;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\AppTitleVideo\AppTitleVideoRepositoryInterface;
use App\Models\AppTitleVideo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AppTitleVideoRepository extends EloquentRepository implements AppTitleVideoRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return AppTitleVideo::class;
    }
    
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }
}
