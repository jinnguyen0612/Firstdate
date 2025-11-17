<?php

namespace App\Api\V1\Repositories\AppTitleVideo;

use App\Admin\Repositories\EloquentRepositoryInterface;
use App\Admin\Repositories\AppTitleVideo\AppTitleVideoRepositoryInterface as AdminAppTitleVideoRepositoryInterface;
use Illuminate\Http\Request;

interface AppTitleVideoRepositoryInterface extends AdminAppTitleVideoRepositoryInterface
{
    public function getAll();
    public function paginate($page = 1, $limit = 10);
}
