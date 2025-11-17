<?php

namespace App\Api\V1\Repositories\Otp;

use App\Admin\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface OtpRepositoryInterface extends EloquentRepositoryInterface
{
    public function searchAllLimit(string $keySearch, array $meta, array $select, int $limit);
    public function getQueryBuilderOrderBy(string $column = 'id', string $sort = 'DESC');
    
}