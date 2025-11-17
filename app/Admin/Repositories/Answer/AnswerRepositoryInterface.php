<?php

namespace App\Admin\Repositories\Answer;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface AnswerRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
}
