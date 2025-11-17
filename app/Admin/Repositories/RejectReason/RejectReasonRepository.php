<?php

namespace App\Admin\Repositories\RejectReason;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\RejectReason\RejectReasonRepositoryInterface;
use App\Models\RejectReason;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RejectReasonRepository extends EloquentRepository implements RejectReasonRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return RejectReason::class;
    }
    
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }
}
