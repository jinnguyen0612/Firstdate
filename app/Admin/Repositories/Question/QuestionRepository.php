<?php

namespace App\Admin\Repositories\Question;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Question\QuestionRepositoryInterface;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class QuestionRepository extends EloquentRepository implements QuestionRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return Question::class;
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function findOrFailWithRelation($id, $relations = ['answers'])
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    public function getAllWithRelation($relations = ['answers'])
    {
        $questions = $this->model->with($relations)->get();
        foreach ($questions as $question) {
            $question['answers'] = $question->answers()->get();
        }
        return $questions;
    }

    public function getRequiredWithRelation($relations = ['answers'])
    {
        $questions = $this->model->with($relations)->where('is_required', 1)->get();
        foreach ($questions as $question) {
            $question['answers'] = $question->answers()->get();
        }
        return $questions;
    }
}
