<?php

namespace App\Api\V1\Repositories\UserAnswer;

use App\Admin\Repositories\EloquentRepository;
use App\Api\V1\Repositories\UserAnswer\UserAnswerRepositoryInterface;
use App\Models\UserAnswer;

class UserAnswerRepository extends EloquentRepository implements UserAnswerRepositoryInterface
{
    protected $select = [];

    public function getModel(): string
    {
        return UserAnswer::class;
    }

    public function getAnswerByUserId($user_id)
    {
        return $this->model->with(['question','answer'])->where('user_id', $user_id)->get();
    }
}