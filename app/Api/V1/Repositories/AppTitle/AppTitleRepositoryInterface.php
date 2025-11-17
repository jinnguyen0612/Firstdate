<?php

namespace App\Api\V1\Repositories\AppTitle;

use App\Admin\Repositories\EloquentRepositoryInterface;
use App\Admin\Repositories\AppTitle\AppTitleRepositoryInterface as AdminAppTitleRepositoryInterface;
use Illuminate\Http\Request;

interface AppTitleRepositoryInterface extends AdminAppTitleRepositoryInterface
{
    public function getAll();
    public function paginate($page = 1, $limit = 10);
}
