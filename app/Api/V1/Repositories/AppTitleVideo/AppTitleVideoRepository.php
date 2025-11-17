<?php

namespace App\Api\V1\Repositories\AppTitleVideo;

use App\Admin\Repositories\AppTitleVideo\AppTitleVideoRepository as AdminAppTitleVideoRepository;
use App\Models\AppTitleVideo;
use Illuminate\Http\Request;

class AppTitleVideoRepository extends AdminAppTitleVideoRepository implements AppTitleVideoRepositoryInterface
{
    protected $model;

    public function __construct(AppTitleVideo $model)
    {
        $this->model = $model;
    }

    public function get()
    {
        return $this->model->get();
    }

    public function detail($id)
    {
        return $this->model->detail($id);
    }

    public function paginate($page = 1, $limit = 10)
    {
        $page = $page ? $page - 1 : 0;
        $this->instance = $this->model
        ->offset($page * $limit)
        ->limit($limit)
        ->orderBy('id', 'desc')
        ->get();
        return $this->instance;
    }
}
