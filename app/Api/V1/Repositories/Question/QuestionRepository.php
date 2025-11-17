<?php

namespace App\Api\V1\Repositories\Question;

use App\Admin\Repositories\Question\QuestionRepository as AdminQuestionRepository;
use App\Api\V1\Repositories\Question\QuestionRepositoryInterface;
use App\Models\Question;

class QuestionRepository extends AdminQuestionRepository implements QuestionRepositoryInterface
{

    public function paginate($required = null, $limit = 10)
    {
        if($required == null){
            $this->instance = $this->model
                ->orderBy('id', 'desc')
                ->simplePaginate($limit);
        }else{
            $this->instance = $this->model
                ->where('is_required',$required)
                ->orderBy('id', 'desc')
                ->simplePaginate($limit);        
        }
        return $this->instance;
    }

}