<?php

namespace App\Api\V1\Repositories\SupportCategory;

use App\Admin\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface SupportCategoryRepositoryInterface extends EloquentRepositoryInterface
{
    public function getAllPaginate($limit = 10, $search = '');
}
