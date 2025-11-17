<?php

namespace App\Api\V1\Repositories\SupportCategory;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Traits\BaseAuthCMS;
use App\Admin\Traits\Roles;
use App\Api\V1\Repositories\SupportCategory\SupportCategoryRepositoryInterface;
use App\Admin\Repositories\SupportCategory\SupportCategoryRepository as AdminSupportCategoryRepository;
use App\Models\SupportCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SupportCategoryRepository extends AdminSupportCategoryRepository implements SupportCategoryRepositoryInterface
{
    function __construct(SupportCategory $model)
    {
        parent::__construct($model);
    }

    public function getAllPaginate($limit = 10, $search = '')
    {
        $query = $this->model->newQuery();

        if (!empty($search)) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }

        return $query->orderBy('created_at', 'DESC')->paginate($limit);
    }
}
