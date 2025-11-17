<?php

namespace App\Api\V1\Repositories\Bank;

use App\Admin\Repositories\EloquentRepository;
use App\Api\V1\Repositories\Bank\BankRepositoryInterface;
use App\Models\Bank;

class BankRepository extends EloquentRepository implements BankRepositoryInterface
{

    public function getModel()
    {
        return Bank::class;
    }

    public function getAllPaginate($limit = 10, $search = '')
    {
        $query = $this->model->newQuery();

        if (!empty($search)) {
            $query->where('short_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('name', 'LIKE', '%' . $search . '%');
        }

        return $query->paginate($limit);
    }
}
