<?php

namespace App\Api\V1\Repositories\UserAnswer;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface UserAnswerRepositoryInterface extends EloquentRepositoryInterface
{
        public function getAnswerByUserId($user_id);
}