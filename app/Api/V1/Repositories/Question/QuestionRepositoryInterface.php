<?php

namespace App\Api\V1\Repositories\Question;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface QuestionRepositoryInterface extends EloquentRepositoryInterface
{
    public function paginate($required = null, $limit);
}