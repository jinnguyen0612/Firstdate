<?php

namespace App\Admin\Repositories\Answer;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Answer\AnswerRepositoryInterface;
use App\Models\Answer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AnswerRepository extends EloquentRepository implements AnswerRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return Answer::class;
    }
    
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }
}
