<?php

namespace App\Api\V1\Repositories\AppTitle;

use App\Admin\Repositories\AppTitle\AppTitleRepository as AdminAppTitleRepository;
use App\Models\AppTitle;
use Illuminate\Http\Request;

class AppTitleRepository extends AdminAppTitleRepository implements AppTitleRepositoryInterface
{
    protected $model;

    public function __construct(AppTitle $model)
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
