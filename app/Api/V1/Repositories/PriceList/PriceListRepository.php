<?php

namespace App\Api\V1\Repositories\PriceList;

use App\Admin\Repositories\PriceList\PriceListRepository as AdminPriceListRepository;
use App\Models\PriceList;
use Illuminate\Http\Request;

class PriceListRepository extends AdminPriceListRepository implements PriceListRepositoryInterface
{
    protected $model;

    public function __construct(PriceList $model)
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

    public function paginate($limit = 10)
    {
        $this->instance = $this->model
            ->orderBy('id', 'desc')
            ->paginate($limit);
        return $this->instance;
    }
}
