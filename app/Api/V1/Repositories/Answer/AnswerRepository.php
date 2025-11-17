<?php

namespace App\Api\V1\Repositories\Answer;

use App\Admin\Repositories\Answer\AnswerRepository as AdminAnswerRepository;
use App\Api\V1\Repositories\Answer\AnswerRepositoryInterface;
use App\Models\Answer;

class AnswerRepository extends AdminAnswerRepository implements AnswerRepositoryInterface
{

    public function paginate($page = 1, $limit = 10)
    {
        $page = $page ? $page - 1 : 0;
        $this->instance = $this->model
            ->offset($page * $limit)
            ->limit($limit)
            ->orderBy('id', 'desc')
            ->get();
        return $this->instance;
    }

    public function checkRequiredQuestionByAnswerId($answerId){
        $response = $this->model->with(['question'])->findOrFail($answerId);
        if($response->question['is_required'] == 1){
            return true;
        } else return false;
    }

    public function checkDuplicateQuestionByAnswer(array $answer){
        $answerObjects = $this->model->whereIn('id', $answer)->get();
        $hasDuplicate = $answerObjects->pluck('question_id')->duplicates()->isNotEmpty();
        if ($hasDuplicate){
            return true;
        }
            
    }

}