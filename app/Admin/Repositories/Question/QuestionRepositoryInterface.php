<?php

namespace App\Admin\Repositories\Question;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface QuestionRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
    public function findOrFailWithRelation($id, $relations);
    public function getAllWithRelation();
    public function getRequiredWithRelation();
}
