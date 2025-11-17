<?php

namespace App\Api\V1\Repositories\Support;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Traits\BaseAuthCMS;
use App\Admin\Traits\Roles;
use App\Api\V1\Repositories\Support\SupportRepositoryInterface;
use App\Admin\Repositories\Support\SupportRepository as AdminSupportRepository;
use App\Models\Support;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SupportRepository extends AdminSupportRepository implements SupportRepositoryInterface
{
    function __construct(Support $model)
    {
        parent::__construct($model);
    }

    public function getAllPaginate($category_id = null, $limit = 10, $search = '')
    {
        $query = $this->model->newQuery();

        if (!empty($category_id)) {
            $query->where('support_category_id', $category_id);
        }

        if (!empty($search)) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }

        return $query->orderBy('created_at', 'DESC')->paginate($limit);
    }
}
