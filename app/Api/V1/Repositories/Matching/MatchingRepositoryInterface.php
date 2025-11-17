<?php

namespace App\Api\V1\Repositories\Matching;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface MatchingRepositoryInterface extends EloquentRepositoryInterface
{
    public function getUnmatchedLovers(int $userId, int $limit = 10);
    public function deleteBy(array $conditions);
    public function getMatchingSuccess(int $userId, string $searchTerm = '', int $limit = 10);
}
