<?php

namespace App\Api\V1\Repositories\Support;

use App\Admin\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface SupportRepositoryInterface extends EloquentRepositoryInterface
{
    public function getAllPaginate($category_id = null, $limit = 10, $search = '');
}
