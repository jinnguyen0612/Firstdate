<?php

namespace App\Api\V1\Repositories\Answer;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface AnswerRepositoryInterface extends EloquentRepositoryInterface
{
    public function paginate($page = 1, $limit = 10);
    public function checkRequiredQuestionByAnswerId($answerId);
    public function checkDuplicateQuestionByAnswer(array $answer);
}